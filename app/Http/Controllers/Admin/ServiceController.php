<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Service;
use App\Models\ServiceOrder;
use App\Models\ServiceOrderSlot;
use App\Models\ServiceOutline;
use App\Models\ServiceNote;
use App\Models\ServiceOrderSlotFacility;
use App\Models\ServiceOrderSlotStaff;
use App\Models\DisciplinaryIssue;
use App\Services\NotificationService;
use App\Services\OrderService;
use App\Models\CompanyLocation;
use App\Models\Territory;
use App\Models\Vehicle;
use App\Models\User;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $orderService;
    protected $notify;

    public function __construct(OrderService $orderService, NotificationService $notify)
    {
        $this->orderService = $orderService;
        $this->notify = $notify;
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
            'orderSlots.office',
            'orderSlots.staff.user',
            'service.outlines',
            'service.lead.company.locations',
            'notes.user',
            'employeePerformances.employee',
            'employeePerformances.issue',
            'employeePerformances.user',
        ])->findOrFail($orderId);

        $companyLocations = $order->service->lead->company->locations;
        $territories = Territory::orderBy('name')->get();

        $allStaff = User::whereNotNull('territory_id')
        ->whereNotNull('staff_type')
        ->get()
        ->groupBy(['territory_id', 'staff_type']);

        // Fetch all disciplinary issues
        $disciplinaryIssues = \App\Models\DisciplinaryIssue::orderBy('name')->get();

        // Get employees assigned to this order (from slots staff)
        $assignedEmployees = $order->orderSlots()
            ->with('staff.user')
            ->get()
            ->flatMap(function ($slot) {
                return $slot->staff->map(fn ($staff) => $staff->user);
            })
            ->unique('id');

        return view('admin.leads.fulfill-order', compact('order','companyLocations','territories','allStaff','disciplinaryIssues','assignedEmployees'));
    }

    public function fulfillOrder_book(Request $request, $orderId)
    {
        $request->validate([
            'scheduled_start_time'     => 'required',
            'scheduled_end_time'       => 'required',
            'scheduled_arrival_time'   => 'required',
            'scheduled_office' => 'required|exists:territories,id',
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
            'scheduled_office' => 'required|exists:territories,id',
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

    public function getUserMonthlySlots(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date'    => 'required|date',
        ]);

        $date = \Carbon\Carbon::parse($request->date);

        // Month range
        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth   = $date->copy()->endOfMonth();

        $slots = ServiceOrderSlot::whereHas('staff', function ($q) use ($request) {
                $q->where('user_id', $request->user_id);
            })
            ->whereBetween('scheduled_start_time', [$startOfMonth, $endOfMonth])
            ->with('office')
            ->orderBy('scheduled_start_time')
            ->get()
            ->map(function ($slot) {
                return [
                    'office'      => $slot->office->name ?? 'N/A',
                    'start_time'  => \Carbon\Carbon::parse($slot->scheduled_start_time)->format('d M Y h:i A'),
                    'end_time'    => \Carbon\Carbon::parse($slot->scheduled_end_time)->format('d M Y h:i A'),
                    'hours'       => $slot->scheduled_hours,
                ];
            });

        return response()->json($slots);
    }

    public function assignStaff(Request $request, $slotId)
    {
        $request->validate([
            'user_ids'   => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id',
        ]);

        $slot = ServiceOrderSlot::with('serviceOrder.service')->findOrFail($slotId);
        $slotHours = $slot->scheduled_hours ?? 0;

        foreach ($request->user_ids as $userId) {
            $alreadyAssigned = $slot->staff()->where('user_id', $userId)->exists();
            if ($alreadyAssigned) continue;

            $user = User::findOrFail($userId);
            $cost = round($slotHours * ($user->hourly_rate ?? 0), 2);

            $slot->staff()->create([
                'user_id'    => $userId,
                'slot_hours' => $slotHours,
                'cost'       => $cost,
            ]);

            $this->notify->staffAssignedToOrder($user, $slot);
        }

        return redirect()->back()->with('success', 'Staff assigned successfully.');
    }

    public function removeStaff(Request $request, $staffId)
    {
        ServiceOrderSlotStaff::findOrFail($staffId)->delete();

        return redirect()->back()->with('success', 'Staff removed from slot.');
    }

    public function assignVehicles(Request $request, $slotId)
    {
        $request->validate([
            'vehicle_ids' => 'required|array|min:1',
            'vehicle_ids.*' => 'exists:vehicles,id',
        ]);

        $slot = ServiceOrderSlot::findOrFail($slotId);

        foreach ($request->vehicle_ids as $vehicleId) {
            if (!$slot->vehicles()->where('vehicle_id', $vehicleId)->exists()) {
                $slot->vehicles()->attach($vehicleId);
            }
        }

        return back()->with('success', 'Vehicles assigned successfully.');
    }

    public function removeVehicle($slotId, $vehicleId)
    {
        $slot = ServiceOrderSlot::findOrFail($slotId);
        $slot->vehicles()->detach($vehicleId);

        return back()->with('success', 'Vehicle removed.');
    }

    public function addServiceNote(Request $request, $orderId)
    {
        $request->validate([
            'notes' => 'required|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('photo')) {
            $imagePath = $request->file('photo')->store('service-notes', 'public');
        }

        ServiceNote::create([
            'service_order_id'  => $orderId,
            'user_id'           => auth()->id(),
            'notes'             => $request->notes,
            'image_path'        => $imagePath,
            'notify_sales_team' => $request->boolean('notify_sales_team'),
        ]);

        return redirect()->back()->with('success', 'Note added successfully.');
    }

    public function updateInventory(Request $request, $orderId)
    {
        $request->validate([
            'microfiber'        => 'nullable|integer|min:0',
            'swabs'             => 'nullable|integer|min:0',
            'oxivir_jars'       => 'nullable|integer|min:0',
            'opticide_gallons'  => 'nullable|integer|min:0',
            'halomist'          => 'nullable|integer|min:0',
            'water'             => 'nullable|integer|min:0',
        ]);

        $order = ServiceOrder::findOrFail($orderId);

        $order->update([
            'microfiber'       => $request->microfiber ?? 0,
            'swabs'            => $request->swabs ?? 0,
            'oxivir_jars'      => $request->oxivir_jars ?? 0,
            'opticide_gallons' => $request->opticide_gallons ?? 0,
            'halomist'         => $request->halomist ?? 0,
            'water'            => $request->water ?? 0,
        ]);

        return redirect()->back()->with('success', 'Inventory updated successfully.');
    }

    public function updateOutlineRange(Request $request, $outlineId)
    {
        $request->validate([
            'range'       => 'required|integer|min:0|max:100',
            'description' => 'nullable|string',
        ]);

        ServiceOutline::findOrFail($outlineId)->update([
            'range'       => $request->range,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Outline updated successfully.');
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

    public function schedulingCalendar()
    {
        return view('admin.calendar.scheduling-calendar');
    }

    public function schedulingCalendarOrders()
    {
        $slots = ServiceOrderSlot::with([
                'serviceOrder.service.lead.company',
                'serviceOrder'
            ])
            ->where('is_confirmed', true)
            ->get();

        $events = $slots->map(function ($slot) {
            $order = $slot->serviceOrder;

            return [
                'id'    => $slot->id,
                'title' => $order->service->service_name ?? 'Service Order',
                'start' => $slot->scheduled_start_time,
                'end'   => $slot->scheduled_end_time,
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
                    'scheduled_start_time' => $slot->scheduled_start_time,
                    'fulfill_url'  => route('admin.lead.service.fulfill_order', $order->id),
                ],
            ];
        });

        return response()->json($events);
    }


    public function vehiclePlanning(Request $request)
    {
        $date = $request->date
            ? \Carbon\Carbon::parse($request->date)
            : now();

        $start = $date->copy()->startOfWeek();
        $end   = $date->copy()->endOfWeek();

        $slots = ServiceOrderSlot::with([
                'serviceOrder.service.lead.company',
                'vehicles'
            ])
            ->where('is_confirmed', true)
            ->whereBetween('scheduled_start_time', [$start, $end])
            ->orderBy('scheduled_start_time')
            ->get()
            ->groupBy(function ($slot) {
                return \Carbon\Carbon::parse($slot->scheduled_start_time)->format('Y-m-d');
            });

        $vehicles = Vehicle::where('is_retired', 0)->get();

        return view('admin.vehicle-planning.index', compact('slots', 'vehicles', 'start', 'end', 'date'));
    }

    /**
     * Update checklist fields (narratives, debrief, status)
     */
    public function updateChecklist(Request $request, $orderId)
    {
        $order = ServiceOrder::findOrFail($orderId);

        $updateData = [];

        // Update service_plan_narrative if provided
        if ($request->has('service_plan_narrative')) {
            $updateData['service_plan_narrative'] = $request->input('service_plan_narrative');
        }

        // Update sales_narrative if provided
        if ($request->has('sales_narrative')) {
            $updateData['sales_narrative'] = $request->input('sales_narrative');
        }

        // Update plan_review_status if provided
        if ($request->has('plan_review_status')) {
            $updateData['plan_review_status'] = $request->input('plan_review_status');
        }

        // Update plan_debrief if provided
        if ($request->has('plan_debrief')) {
            $updateData['plan_debrief'] = $request->input('plan_debrief');
        }

        // Update the order if there's data to update
        if (!empty($updateData)) {
            $order->update($updateData);
        }

        // Check if this is an AJAX request
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Checklist updated successfully',
                'order' => $order
            ]);
        }

        return redirect()->back()->with('success', 'Checklist updated successfully.');
    }

    /**
     * Store employee performance record
     */
    public function storeEmployeePerformance(Request $request, $orderId)
    {
        try {
            $request->validate([
                'employee_id' => 'required|exists:users,id',
                'disciplinary_issue_id' => 'required|exists:disciplinary_issues,id',
                'notes' => 'nullable|string',
            ]);

            $order = ServiceOrder::findOrFail($orderId);

            $performanceData = [
                'user_id' => auth()->id(),
                'employee_id' => $request->employee_id,
                'disciplinary_issue_id' => $request->disciplinary_issue_id,
                'notes' => $request->notes ?? null,
            ];

            \Log::info('Creating employee performance:', $performanceData);

            $performance = $order->employeePerformances()->create($performanceData);

            \Log::info('Employee performance created:', $performance->toArray());

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Employee performance recorded successfully',
                    'performance' => $performance->load('employee', 'issue', 'user')
                ]);
            }

            return redirect()->back()->with('success', 'Employee performance recorded successfully.');
        } catch (\Exception $e) {
            \Log::error('Error storing employee performance: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to record employee performance: ' . $e->getMessage());
        }
    }

    public function all_schedules(Request $request)
    {
        $date = $request->date
            ? \Carbon\Carbon::parse($request->date)
            : now();

        $start = $date->copy()->startOfWeek();
        $end   = $date->copy()->endOfWeek();

        $slots = ServiceOrderSlot::with([
                'serviceOrder.service.lead.company',
                'vehicles'
            ])
            ->where('is_confirmed', true)
            ->whereBetween('scheduled_start_time', [$start, $end])
            ->orderBy('scheduled_start_time')
            ->get()
            ->groupBy(function ($slot) {
                return \Carbon\Carbon::parse($slot->scheduled_start_time)->format('Y-m-d');
            });

        $vehicles = Vehicle::where('is_retired', 0)->get();

         $employees = User::whereNotNull('territory_id')
        ->whereNotNull('staff_type')
        ->orderBy('name')
        ->get();

        return view('admin.all-schedules', compact('slots', 'vehicles', 'start', 'end', 'date','employees'));
    }
}
