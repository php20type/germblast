<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceOrderInvoice;
use Carbon\Carbon;

class RevenueReportController extends Controller
{
    public function index(Request $request)
    {
        // Parse requested date or default to current date
        $date = $request->input('date') ? Carbon::parse($request->input('date')) : now();
        
        $data = $this->getRevenueData($date);
        $records = $data['records'];
        $totalRevenue = $data['totalRevenue'];

        return view('admin.corporate-tools.revenue-report', compact('date', 'records', 'totalRevenue'));
    }

    /**
     * Shared revenue report data fetcher
     */
    private function getRevenueData(Carbon $date): array
    {
        $start = $date->copy()->startOfMonth();
        $end   = $date->copy()->endOfMonth();

        // Get invoices for the specified month
        $invoices = ServiceOrderInvoice::whereBetween('invoice_date', [$start->toDateString(), $end->toDateString()])
            ->with([
                'serviceOrder.service.lead.company'
            ])
            ->get();

        $records = [];
        $totalRevenue = 0;

        foreach ($invoices as $invoice) {
            $company = $invoice->serviceOrder->service->lead->company ?? null;
            $clientName = $company ? $company->name : 'System';
            
            $formattedDate = $invoice->invoice_date ? Carbon::parse($invoice->invoice_date)->format('m/d/y') : '-';

            $lineItems = is_array($invoice->line_items) ? $invoice->line_items : json_decode($invoice->line_items, true);

            if (!empty($lineItems)) {
                foreach ($lineItems as $item) {
                    $records[] = [
                        'invoice_id' => $invoice->id,
                        'service_order_id' => $invoice->serviceOrder->id ?? null,
                        'invoice_no' => $invoice->invoice_no,
                        'client' => $clientName,
                        'date' => $formattedDate,
                        'line_item' => $item['type'] ?? '-',
                        'qty' => $item['qty'] ?? 0,
                        'price' => '$' . number_format((float)($item['price'] ?? 0), 2),
                        'line_total' => '$' . number_format((float)($item['total'] ?? 0), 2)
                    ];
                    $totalRevenue += (float)($item['total'] ?? 0);
                }
            } else {
                // Fallback if no line items exist but invoice has a total
                $records[] = [
                    'invoice_id' => $invoice->id,
                    'service_order_id' => $invoice->serviceOrder->id ?? null,
                    'invoice_no' => $invoice->invoice_no,
                    'client' => $clientName,
                    'date' => $formattedDate,
                    'line_item' => 'Total Amount',
                    'qty' => 1,
                    'price' => '$' . number_format((float)$invoice->total_amount, 2),
                    'line_total' => '$' . number_format((float)$invoice->total_amount, 2)
                ];
                $totalRevenue += (float)$invoice->total_amount;
            }
        }

        return [
            'records' => $records,
            'totalRevenue' => $totalRevenue
        ];
    }
}
