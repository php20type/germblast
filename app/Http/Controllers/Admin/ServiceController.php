<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Service;
use App\Models\ServiceOrder;
use App\Models\ServiceOrderSlot;
use App\Models\ServiceOrderSlotFacility;
use App\Services\OrderService;
use App\Models\CompanyLocation;
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
        $lead = Lead::with(['products', 'services.outlines', 'services.orders.orderSlots'])->findOrFail($leadId);

        $services = $lead->services;
        $totalRevenue = $services->sum('total_price');

        return view('admin.leads.service-details', compact('services', 'lead', 'totalRevenue'));
    }

    /**
     * Step 1: Store initial service details + outlines
     */
    public function storeService(Request $request, $leadId)
    {
        $request->validate([
            'service_name'       => 'required|string|max:255',
            'price_per_service'  => 'required|numeric|min:0',
            'number_of_services' => 'required|integer|min:1',
            'po_number'          => 'nullable|string|max:255',
            'outlines'           => 'required',
        ]);

        $pricePerService = $request->price_per_service;
        $numberOfService = $request->number_of_services;
        $totalPrice = round($pricePerService * $numberOfService, 2);

        $service = Service::create([
            'user_id'            => auth()->id(),
            'lead_id'            => $leadId,
            'service_name'       => $request->service_name,
            'price_per_service'  => $pricePerService,
            'number_of_services' => $numberOfService,
            'po_number'          => $request->po_number,
            'total_price'        => $totalPrice,
        ]);

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
            'service_id'    => 'required|exists:services,id',
            'intended_date' => 'required|date',
        ]);

        $service = Service::findOrFail($request->service_id);

        $order = ServiceOrder::create([
            'user_id'       => auth()->id(),
            'service_id'    => $service->id,
            'intended_date' => $request->intended_date,
        ]);

        $order->update([
            'order_no' => $this->orderService->generateOrderNo($order->id),
        ]);

        return redirect()->route('admin.lead.service.details', $service->lead_id)
            ->with('success', 'Intended date added.');
    }

    public function fulfillOrder(Request $request, $orderId)
    {
        $order = ServiceOrder::with([
            'orderSlots.clocks.clockedBy',
            'orderSlots.confirmedBy',
            'orderSlots.facilities.companyLocation',
            'service.outlines',
            'service.lead.company.locations', // ← ADD THIS
        ])->findOrFail($orderId);

        $companyLocations = $order->service->lead->company->locations;

        return view('admin.leads.fulfill-order', compact('order','companyLocations'));
    }

    public function fulfillOrder_book(Request $request, $orderId)
    {
        $request->validate([
            'scheduled_start_time'     => 'required',
            'scheduled_end_time'       => 'required',
            'scheduled_arrival_time'   => 'required',
            'scheduled_office'         => 'required|string',
            'scheduled_recurrence_rule'=> 'required|string',
            'meet'                     => 'required|in:office,facility',
            'overnight'                => 'required|boolean',
        ]);

        $start = \Carbon\Carbon::parse($request->scheduled_start_time);
        $end   = \Carbon\Carbon::parse($request->scheduled_end_time);
        $scheduledHours = round($start->diffInMinutes($end) / 60, 2);

        $order = ServiceOrder::findOrFail($orderId);

        $order->orderSlots()->create([
            'scheduled_start_time'     => $request->scheduled_start_time,
            'scheduled_end_time'       => $request->scheduled_end_time,
            'scheduled_arrival_time'   => $request->scheduled_arrival_time,
            'scheduled_office'         => $request->scheduled_office,
            'scheduled_recurrence_rule'=> $request->scheduled_recurrence_rule,
            'meet'                     => $request->meet,
            'overnight'                => $request->overnight,
            'scheduled_hours'          => $scheduledHours,
        ]);

        $order->update(['status' => 'scheduled']);

        return redirect()->route('admin.lead.service.fulfill_order', $orderId)
            ->with('success', 'Slot booked successfully.');
    }

    public function confirmSlot(Request $request, $slotId)
    {
        $slot = ServiceOrderSlot::findOrFail($slotId);

        $slot->update([
            'is_confirmed' => true,
            'confirmed_at' => now(),
            'confirmed_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Slot confirmed successfully.');
    }

    public function updateSlot(Request $request, $slotId)
    {
        $request->validate([
            'scheduled_start_time'     => 'required',
            'scheduled_end_time'       => 'required',
            'scheduled_arrival_time'   => 'required',
            'scheduled_office'         => 'required|string',
            'scheduled_recurrence_rule'=> 'required|string',
            'meet'                     => 'required|in:office,facility',
            'overnight'                => 'required|boolean',
        ]);

        $slot = ServiceOrderSlot::findOrFail($slotId);

        $start = \Carbon\Carbon::parse($request->scheduled_start_time);
        $end   = \Carbon\Carbon::parse($request->scheduled_end_time);
        $scheduledHours = round($start->diffInMinutes($end) / 60, 2);

        $slot->update([
            'scheduled_start_time'     => $request->scheduled_start_time,
            'scheduled_end_time'       => $request->scheduled_end_time,
            'scheduled_arrival_time'   => $request->scheduled_arrival_time,
            'scheduled_office'         => $request->scheduled_office,
            'scheduled_recurrence_rule'=> $request->scheduled_recurrence_rule,
            'meet'                     => $request->meet,
            'overnight'                => $request->overnight,
            'scheduled_hours'          => $scheduledHours,
            'is_confirmed'             => false, // reset confirmation on edit
            'confirmed_at'             => null,
            'confirmed_by'             => null,
        ]);

        return redirect()->back()->with('success', 'Slot updated successfully.');
    }

    public function addFacility(Request $request, $slotId)
    {
        $request->validate([
            'company_location_id' => 'required|exists:company_locations,id',
        ]);

        $location = CompanyLocation::findOrFail($request->company_location_id);

        $slot = ServiceOrderSlot::findOrFail($slotId);

        // Prevent duplicate
        $alreadyAdded = $slot->facilities()
            ->where('company_location_id', $location->id)
            ->exists();

        if ($alreadyAdded) {
            return redirect()->back()->with('error', 'This facility is already added.');
        }

        $slot->facilities()->create([
            'company_location_id' => $location->id,
        ]);

        return redirect()->back()->with('success', 'Facility added successfully.');
    }

    public function removeFacility(Request $request, $facilityId)
    {
        ServiceOrderSlotFacility::findOrFail($facilityId)->delete();

        return redirect()->back()->with('success', 'Facility removed.');
    }

    /**
     * Clock in - per slot
     */
    public function clockIn(Request $request)
    {
        $request->validate([
            'slot_id' => 'required|exists:service_order_slots,id',
            'type'    => 'required|in:service,travel,break',
        ]);

        $slot = ServiceOrderSlot::findOrFail($request->slot_id);

        // Prevent overlapping active clock of same type
        $activeClock = $slot->clocks()
            ->where('type', $request->type)
            ->whereNull('clocked_out_at')
            ->first();

        if ($activeClock) {
            return redirect()->back()->with('error',
                ucfirst($request->type) . ' clock is already running.'
            );
        }

        $slot->clocks()->create([
            'type'          => $request->type,
            'clocked_by'    => auth()->id(),
            'clocked_in_at' => now(),
        ]);

        $slot->serviceOrder->update(['status' => 'in_progress']);

        return redirect()->back()->with('success',
            ucfirst($request->type) . ' clock started.'
        );
    }

    /**
     * Clock out - per slot
     */
    public function clockOut(Request $request)
    {
        $request->validate([
            'slot_id' => 'required|exists:service_order_slots,id',
            'type'    => 'required|in:service,travel,break',
        ]);

        $slot = ServiceOrderSlot::findOrFail($request->slot_id);

        $activeClock = $slot->clocks()
            ->where('type', $request->type)
            ->whereNull('clocked_out_at')
            ->latest('clocked_in_at')
            ->first();

        if (!$activeClock) {
            return redirect()->back()->with('error',
                'No active ' . $request->type . ' clock found.'
            );
        }

        $activeClock->update([
            'clocked_out_at' => now(),
            'clocked_hours'  => $activeClock->calculateHours(),
        ]);

        return redirect()->back()->with('success',
            ucfirst($request->type) . ' clock stopped.'
        );
    }

        public function calendar()
    {
        return view('admin.calendar.index');
    }

    public function calendarOrders()
    {
        $orders = ServiceOrder::with(['service.lead.company','orderSlots'])
            ->whereNotNull('intended_date')
            ->get();

        $events = $orders->map(function ($order) {
            return [
                'id'    => $order->id,
                'title' => $order->service->service_name ?? 'Service Order',
                'start' => $order->intended_date,
                'end'   => $order->intended_date,
                'color' => match($order->status) {
                    'scheduled'   => '#0d6efd',
                    'in_progress' => '#ffc107',
                    'completed'   => '#198754',
                    'cancelled'   => '#dc3545',
                    default       => '#6c757d',
                },
                'extendedProps' => [
                    'order_no'     => $order->order_no,
                    'service_name' => $order->service->service_name ?? '-',
                    'lead_name'    => $order->service->lead->name ?? '-',
                    'company_name' => $order->service->lead->company->name ?? '-',
                    'po_number'    => $order->service->po_number ?? '-',
                    'price'        => $order->service->price_per_service ?? '-',
                    'status'       => $order->status,
                    'scheduled_start_time' => $order->orderSlots->first()?->scheduled_start_time,
                    'fulfill_url'  => route('admin.lead.service.fulfill_order', $order->id),
                ],
            ];
        });

        return response()->json($events);
    }
}
