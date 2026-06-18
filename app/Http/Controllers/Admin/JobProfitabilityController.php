<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceOrder;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class JobProfitabilityController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->date
            ? Carbon::parse($request->date)
            : Carbon::now();

        $data = $this->getProfitabilityData($date);

        return view('admin.reports.profitability', [
            'records' => $data['records'],
            'date' => $data['date']
        ]);
    }

    public function downloadPdf(Request $request)
    {
        $date = $request->date
            ? Carbon::parse($request->date)
            : Carbon::now();

        $data = $this->getProfitabilityData($date);

        $pdf = Pdf::loadView('pdf.profitability', [
            'records' => $data['records'],
            'date' => $data['date']
        ]);

        return $pdf->download('job-profitability-' . $date->format('Y-m') . '.pdf');
    }

    public function downloadCsv(Request $request)
    {
        $date = $request->date
            ? Carbon::parse($request->date)
            : Carbon::now();

        $data = $this->getProfitabilityData($date);
        $records = $data['records'];

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="job-profitability-' . $date->format('Y-m') . '.csv"',
        ];

        $callback = function () use ($records, $date) {
            $file = fopen('php://output', 'w');

            // Metadata / Header
            fputcsv($file, ['Job Profitability Report']);
            fputcsv($file, ['Month', $date->format('F Y')]);
            fputcsv($file, ['Generated At', now()->format('Y-m-d H:i:s')]);
            fputcsv($file, []); // Empty row

            // Table Headers
            fputcsv($file, [
                'Client',
                'Date',
                'Price ($)',
                'Hours',
                'OT',
                'Budget Hours',
                'Ratio Hours',
                'Actual Labor ($)',
                'Budget Labor ($)',
                'Ratio Labor',
                'Delta ($)'
            ]);

            // Data Rows
            foreach ($records as $record) {
                fputcsv($file, [
                    $record['client'],
                    $record['date'],
                    $record['price'],
                    $record['hours'],
                    $record['ot'],
                    $record['budget_hours'],
                    $record['ratio_hours'],
                    $record['actual_labor'],
                    $record['budget_labor'],
                    $record['ratio_labor'],
                    $record['delta']
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Shared profitability data fetcher
     */
    private function getProfitabilityData(Carbon $date): array
    {
        $start = $date->copy()->startOfMonth();
        $end   = $date->copy()->endOfMonth();

        $orders = ServiceOrder::where(function($q) use ($start, $end) {
            $q->whereBetween('intended_date', [$start->toDateString(), $end->toDateString()])
              ->orWhereHas('orderSlots', function($slotQ) use ($start, $end) {
                  $slotQ->whereBetween('scheduled_start_time', [$start, $end]);
              });
        })
        ->with([
            'service.lead.company',
            'invoice',
            'orderSlots.clocks.clockedBy',
            'orderSlots.staff.user'
        ])
        ->get();

        $records = [];

        foreach ($orders as $order) {
            $clientName = $order->service->lead->company->name ?? 'System';
            
            // Get first slot scheduled date or fallback to intended_date
            $firstSlot = $order->orderSlots->first();
            $dateObj = $firstSlot && $firstSlot->scheduled_start_time
                ? $firstSlot->scheduled_start_time
                : ($order->intended_date ? Carbon::parse($order->intended_date) : null);
            $formattedDate = $dateObj ? $dateObj->format('m/d/y') : '-';

            // Price calculation
            $price = 0;
            if ($order->invoice) {
                $price = $order->invoice->total_amount;
            } elseif ($order->service) {
                $price = $order->service->price_per_service ?? $order->service->total_price ?? 0;
            }

            // Budget hours & Budget labor
            $budgetHours = 0;
            $budgetLabor = 0;
            $hasStaff = false;

            foreach ($order->orderSlots as $slot) {
                if ($slot->staff->isNotEmpty()) {
                    $hasStaff = true;
                    $budgetHours += $slot->staff->sum('slot_hours');
                    $budgetLabor += $slot->staff->sum('cost');
                }
            }

            if (!$hasStaff) {
                $budgetHours = $order->orderSlots->sum('scheduled_hours');
                // fallback budget labor estimate ($25/hr default)
                $budgetLabor = $budgetHours * 25;
            }

            // Actual hours, Overtime hours & Actual labor cost from Clocks
            $actualHours = 0;
            $otHours = 0;
            $actualLabor = 0;
            $hasClocks = false;

            foreach ($order->orderSlots as $slot) {
                if ($slot->clocks->isNotEmpty()) {
                    $hasClocks = true;
                    // Group clocks by technician clocked_by
                    $userClocks = $slot->clocks->groupBy('clocked_by');

                    foreach ($userClocks as $userId => $clocks) {
                        if (!$userId) continue;

                        $totalClocksHours = 0;
                        foreach ($clocks as $clock) {
                            if (in_array(strtolower($clock->type), ['service', 'travel'])) {
                                $totalClocksHours += $clock->clocked_hours ?? $clock->calculateHours();
                            }
                        }

                        if ($totalClocksHours > 0) {
                            $user = $clocks->first()->clockedBy ?? \App\Models\User::find($userId);
                            $rate = $user ? ($user->hourly_rate ?? 0) : 0;
                            if ($rate == 0) {
                                $rate = 20; // fallback rate
                            }

                            // 8-hour overtime threshold per slot/day
                            $reg = min(8, $totalClocksHours);
                            $ot = max(0, $totalClocksHours - 8);

                            $actualHours += $reg;
                            $otHours += $ot;
                            $actualLabor += ($reg * $rate) + ($ot * $rate * 1.5);
                        }
                    }
                }
            }

            // If there are no slots scheduled, we treat all metrics as '-'
            $hasSlots = $order->orderSlots->isNotEmpty();

            // Calculate Ratios and Delta
            if ($hasSlots) {
                $ratioHours = $budgetHours > 0 ? ($actualHours + $otHours) / $budgetHours : 0;
                $ratioLabor = $budgetLabor > 0 ? $actualLabor / $budgetLabor : 0;
                $delta = $actualLabor - $budgetLabor;

                // Format values
                $displayHours = $actualHours > 0 ? number_format($actualHours, 2) : '0.00';
                $displayOt = $otHours > 0 ? number_format($otHours, 2) : '-';
                $displayBudgetHours = number_format($budgetHours, 2);
                $displayRatioHours = number_format($ratioHours, 2);

                $displayActualLabor = number_format($actualLabor, 2);
                $displayBudgetLabor = number_format($budgetLabor, 2);
                $displayRatioLabor = number_format($ratioLabor, 2);
                
                $formattedDelta = ($delta >= 0 ? '' : '-') . number_format(abs($delta), 2);

                // Row highlights matching business logic
                if (!$hasClocks) {
                    $rowClass = 'row-yellow';
                    $textColor = '';
                    $priceColor = '';
                    $deltaColor = '';
                } else {
                    $ratio = $budgetLabor > 0 ? $actualLabor / $budgetLabor : 1;
                    if ($actualLabor < $budgetLabor) {
                        $diff = $budgetLabor - $actualLabor;
                        if ($diff >= 50 || $ratio <= 0.90) {
                            $rowClass = 'row-green';
                            $textColor = 'text-success';
                            $priceColor = 'text-success';
                            $deltaColor = 'text-success';
                        } else {
                            $rowClass = '';
                            $textColor = '';
                            $priceColor = '';
                            $deltaColor = '';
                        }
                    } else {
                        $diff = $actualLabor - $budgetLabor;
                        if ($diff >= 100 || $ratio >= 1.10) {
                            $rowClass = 'row-pink';
                            $textColor = 'text-danger';
                            $priceColor = 'text-danger';
                            $deltaColor = 'text-danger';
                        } else {
                            $rowClass = '';
                            $textColor = '';
                            $priceColor = '';
                            $deltaColor = '';
                        }
                    }
                }
            } else {
                $displayHours = '-';
                $displayOt = '-';
                $displayBudgetHours = '-';
                $displayRatioHours = '-';
                $displayActualLabor = '-';
                $displayBudgetLabor = '-';
                $displayRatioLabor = '-';
                $formattedDelta = '-';
                $rowClass = 'row-yellow';
                $textColor = '';
                $priceColor = '';
                $deltaColor = '';
            }

            $records[] = [
                'id' => $order->id,
                'client' => $clientName,
                'date' => $formattedDate,
                'price' => number_format($price, 2),
                'hours' => $displayHours,
                'ot' => $displayOt,
                'budget_hours' => $displayBudgetHours,
                'ratio_hours' => $displayRatioHours,
                'actual_labor' => $displayActualLabor,
                'budget_labor' => $displayBudgetLabor,
                'ratio_labor' => $displayRatioLabor,
                'delta' => $formattedDelta,
                'row_class' => $rowClass,
                'text_color' => $textColor,
                'price_color' => $priceColor,
                'delta_color' => $deltaColor
            ];
        }

        return [
            'records' => $records,
            'date' => $date
        ];
    }
}
