<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceOrder;
use Carbon\Carbon;

class ResidentialReportController extends Controller
{
    public function index(Request $request)
    {
        // Parse requested date or default to current date
        $date = $request->input('date') ? Carbon::parse($request->input('date')) : now();
        
        $records = $this->getResidentialData($date);

        return view('admin.corporate-tools.residential-report', compact('date', 'records'));
    }

    /**
     * Shared residential report data fetcher
     */
    private function getResidentialData(Carbon $date): array
    {
        $start = $date->copy()->startOfMonth();
        $end   = $date->copy()->endOfMonth();

        // Industry ID 17 = Residential
        $orders = ServiceOrder::where('status', 'completed')
            ->where(function($q) use ($start, $end) {
            $q->whereBetween('intended_date', [$start->toDateString(), $end->toDateString()])
              ->orWhereHas('orderSlots', function($slotQ) use ($start, $end) {
                  $slotQ->whereBetween('scheduled_start_time', [$start, $end]);
              });
        })
        ->whereHas('service.lead.company', function($q) {
            $q->where('industry_id', 17);
        })
        ->with([
            'service.lead.company.companyAddress',
            'invoice',
            'orderSlots'
        ])
        ->get();

        $records = [];

        foreach ($orders as $order) {
            $company = $order->service->lead->company ?? null;
            $clientName = $company ? $company->name : 'System';
            
            // Get first slot scheduled date or fallback to intended_date
            $firstSlot = $order->orderSlots->first();
            $dateObj = $firstSlot && $firstSlot->scheduled_start_time
                ? $firstSlot->scheduled_start_time
                : ($order->intended_date ? Carbon::parse($order->intended_date) : null);
            $formattedDate = $dateObj ? $dateObj->format('m/d/y') : '-';

            // City mapping from company address
            $city = '';
            if ($company && $company->companyAddress) {
                $city = $company->companyAddress->address ?? '';
            }

            // Price calculation
            $price = 0;
            if ($order->invoice) {
                $price = $order->invoice->total_amount;
            } elseif ($order->service) {
                $price = $order->service->price_per_service ?? $order->service->total_price ?? 0;
            }

            $records[] = [
                'id' => $order->id,
                'client' => $clientName,
                'city' => $city,
                'special' => '', // Special logic could go here (e.g. if is_hot lead)
                'date' => $formattedDate,
                'price' => '$' . number_format((float)$price, 2)
            ];
        }

        return $records;
    }
}
