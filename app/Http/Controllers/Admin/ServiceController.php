<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Service;
use App\Models\ServiceOrder;
use App\Services\OrderService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function getServiceDetails(Request $request, $leadId)
    {
        $lead = Lead::with(['products', 'services.outlines', 'services.orders'])->findOrFail($leadId);

        $services = $lead->services;
        $totalRevenue = $services->sum('total_price');

        return view('admin.leads.service-details', compact('services', 'lead','totalRevenue'));
    }

    /**
     * Step 1: Store initial service details + outlines
     */
    public function storeService(Request $request, $leadId)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'price_per_service' => 'required|numeric|min:0',
            'number_of_services' => 'required|integer|min:1',
            'po_number' => 'nullable|string|max:255',
            'outlines' => 'required',
        ]);

        $pricePerService = $request->price_per_service;
        $numberOfService = $request->number_of_services;
        // $totalPrice = $pricePerService * $numberOfService;
        $totalPrice = round($pricePerService * $numberOfService, 2);

        $service = Service::create([
            'user_id' => auth()->id(),
            'lead_id' => $leadId,
            'service_name' => $request->service_name,
            'price_per_service' => $pricePerService,
            'number_of_services' => $numberOfService,
            'po_number' => $request->po_number,
            'total_price' => $totalPrice,
        ]);

        // Tagify sends JSON: [{"value":"outline1"},{"value":"outline2"}]
        if ($request->filled('outlines')) {
            $outlines = json_decode($request->outlines, true);
            if (is_array($outlines)) {
                foreach ($outlines as $outline) {
                    $service->outlines()->create([
                        'outline_name' => $outline['value'],
                    ]);
                }
            }
        }

        return redirect()->route('admin.lead.service.details', $leadId)
            ->with('success', 'Service details added successfully.');
    }

    /**
     * Step 2: Add intended date → creates a ServiceOrder record
     */
    public function addIntendedDate(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'intended_date' => 'required|date',
        ]);

        $service = Service::findOrFail($request->service_id);

        $order = ServiceOrder::create([
            'user_id' => auth()->id(),
            'service_id' => $service->id,
            'intended_date' => $request->intended_date,
        ]);

        $orderNo = $this->orderService->generateOrderNo($order->id);

        // Update the payment with invoice number
        $order->update([
            'order_no' => $orderNo,
        ]);

        return redirect()->route('admin.lead.service.details', $service->lead_id)
            ->with('success', 'Intended date added.');
    }

    public function clockIn(Request $request)
    {
        $request->validate(['service_order_id' => 'required|exists:service_orders,id']);

        // Prevent double clock-in
        $existing = ServiceOrder::where('service_order_id', $request->service_order_id)
            ->whereNull('clocked_out_at')
            ->exists();

        if ($existing) {
            return redirect()->back()->with('error', 'Already clocked in.');
        }

        ServiceOrder::create([
            'service_order_id' => $request->service_order_id,
            'user_id' => auth()->id(),
            'clocked_in_at' => now(),
        ]);

        ServiceOrder::find($request->service_order_id)->update(['status' => 'in_progress']);

        return redirect()->back()->with('success', 'Clocked in successfully.');
    }

    public function clockOut(Request $request)
    {
        $request->validate([
            'service_order_id' => 'required|exists:service_orders,id',
            'notes' => 'nullable|string',
        ]);

        $clock = ServiceOrder::where('service_order_id', $request->service_order_id)
            ->where('user_id', auth()->id())
            ->whereNull('clocked_out_at')
            ->firstOrFail();

        $clock->update([
            'clocked_out_at' => now(),
            'notes' => $request->notes,
        ]);

        ServiceOrder::find($request->service_order_id)->update(['status' => 'completed']);

        return redirect()->back()->with('success', 'Clocked out successfully.');
    }

    public function fulfillOrder(Request $request)
    {
        return view('admin.leads.fulfill-order');
    }
}
