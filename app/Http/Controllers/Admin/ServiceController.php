<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Service;
use App\Models\ServiceOrder;
use App\Models\ServiceOrderInvoice;
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
use App\Models\Equipment;
use App\Models\EquipmentStatusLog;
use App\Models\ServiceOrderRoomRecord;
use App\Models\ServiceOrderEquipmentRecord;
use App\Models\ServiceOrderCleanPatch;
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
        $offices = \App\Models\OfficeLocation::where('is_active', 1)->get();

        return view('admin.leads.service-details', compact('services', 'lead', 'totalRevenue', 'offices'));
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
     * Step 2: Add intended date → creates a ServiceOrder record (manual creation)
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

    public function addRecurrenceSchedule(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'scheduled_start_time' => 'nullable|string',
            'scheduled_end_time' => 'nullable|string',
            'scheduled_arrival_time' => 'nullable|string',
            'scheduled_office' => 'nullable|string',
            'scheduled_recurrence_count' => 'required|integer|min:1',
            'recurrence_rule_1' => 'nullable|string',
            'recurrence_rule_2' => 'nullable|string',
            'recurrence_rule_3' => 'nullable|string',
        ]);

        $service = Service::findOrFail($request->service_id);
        $recurrenceCount = $request->input('scheduled_recurrence_count');

        $rule1 = $request->input('recurrence_rule_1', 'N/A');
        $rule2 = $request->input('recurrence_rule_2', 'N/A');
        $rule3 = $request->input('recurrence_rule_3', 'N/A');

        $ruleStr = "{$rule1} {$rule2} of a {$rule3}";
        if ($rule1 === 'N/A' && $rule2 === 'N/A' && $rule3 === 'N/A') {
            $ruleStr = 'N/A';
        }

        // Generate recurrence dates starting dynamically from the current date
        $dates = $this->generateRecurrenceDates($recurrenceCount, $rule1, $rule2, $rule3);

        foreach ($dates as $date) {
            $order = ServiceOrder::create([
                'user_id' => auth()->id(),
                'service_id' => $service->id,
                'intended_date' => $date,
                'status' => 'scheduled',
            ]);

            $order->update([
                'order_no' => $this->orderService->generateOrderNo($order->id),
            ]);

            // Calculate start and end datetimes
            $scheduledStart = null;
            $scheduledEnd = null;
            $scheduledHours = null;

            if ($request->filled('scheduled_start_time')) {
                $scheduledStart = \Carbon\Carbon::parse("$date " . $request->scheduled_start_time);
            }
            if ($request->filled('scheduled_end_time')) {
                $scheduledEnd = \Carbon\Carbon::parse("$date " . $request->scheduled_end_time);
            }
            if ($scheduledStart && $scheduledEnd) {
                $scheduledHours = abs(round($scheduledStart->diffInMinutes($scheduledEnd) / 60, 2));
            }

            // Find matching territory ID for the scheduled office string
            $officeId = null;
            if ($request->filled('scheduled_office')) {
                $cleanOfficeName = explode(',', $request->scheduled_office)[0];
                $territory = Territory::where('name', $request->scheduled_office)
                    ->orWhere('name', 'like', '%' . $cleanOfficeName . '%')
                    ->first();
                if ($territory) {
                    $officeId = $territory->id;
                }
            }

            // Create slot record for the order
            $order->orderSlots()->create([
                'scheduled_start_time' => $scheduledStart,
                'scheduled_end_time' => $scheduledEnd,
                'scheduled_arrival_time' => $request->scheduled_arrival_time,
                'scheduled_office' => $officeId,
                'scheduled_recurrence_count' => $recurrenceCount,
                'scheduled_recurrence_rule' => $ruleStr,
                'scheduled_hours' => $scheduledHours,
                'meet' => 'office',
                'overnight' => 0,
                'status' => 'scheduled',
            ]);
        }

        return redirect()->route('admin.lead.service.details', $service->lead_id)
            ->with('success', 'Recurring service orders generated successfully.');
    }

    private function generateRecurrenceDates($count, $rule1, $rule2, $rule3)
    {
        $dates = [];
        $today = new \DateTime('today');
        $pointer = clone $today;

        if ($rule1 !== 'N/A' && $rule2 !== 'N/A') {
            while (count($dates) < $count) {
                $year = $pointer->format('Y');
                $month = $pointer->format('m');
                $calculated = $this->getNthWeekdayOfMonth($year, $month, $rule1, $rule2);

                if ($calculated && $calculated >= $today) {
                    $dates[] = $calculated->format('Y-m-d');
                }

                // Increment pointer
                if ($rule3 === 'Week') {
                    $pointer->modify('+1 week');
                } elseif ($rule3 === 'Month') {
                    $pointer->modify('+1 month');
                } elseif ($rule3 === 'Quarter') {
                    $pointer->modify('+3 month');
                } elseif ($rule3 === 'Half-Year') {
                    $pointer->modify('+6 month');
                } else {
                    $pointer->modify('+1 day');
                }
            }
        } else {
            while (count($dates) < $count) {
                $dates[] = $pointer->format('Y-m-d');

                // Increment pointer
                if ($rule3 === 'Week') {
                    $pointer->modify('+1 week');
                } elseif ($rule3 === 'Month') {
                    $pointer->modify('+1 month');
                } elseif ($rule3 === 'Quarter') {
                    $pointer->modify('+3 month');
                } elseif ($rule3 === 'Half-Year') {
                    $pointer->modify('+6 month');
                } else {
                    $pointer->modify('+1 day');
                }
            }
        }

        return $dates;
    }

    private function getNthWeekdayOfMonth($year, $month, $nth, $weekday)
    {
        $firstDay = new \DateTime("$year-$month-01");
        $lastDay = new \DateTime("last day of $year-$month");

        $dates = [];
        for ($d = clone $firstDay; $d <= $lastDay; $d->modify('+1 day')) {
            if ($d->format('l') === $weekday) {
                $dates[] = clone $d;
            }
        }

        if (empty($dates)) {
            return null;
        }

        switch ($nth) {
            case 'First':
                return $dates[0];
            case 'Second':
                return isset($dates[1]) ? $dates[1] : end($dates);
            case 'Third':
                return isset($dates[2]) ? $dates[2] : end($dates);
            case 'Fourth':
                return isset($dates[3]) ? $dates[3] : end($dates);
            case 'Last':
                return end($dates);
            default:
                return $dates[0];
        }
    }

    public function fulfillOrder(Request $request, $orderId)
    {
        $order = ServiceOrder::with([
            'invoice',
            'invoices.creator',
            'invoices.updater',
            'invoices.sender',
            'orderSlots.clocks.clockedBy',
            'orderSlots.confirmedBy',
            'orderSlots.facilities.companyLocation',
            'orderSlots.office',
            'orderSlots.staff.user',
            'orderSlots.vehicles',
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
        $disciplinaryIssues = DisciplinaryIssue::orderBy('name')->get();

        // Get employees assigned to this order (from slots staff)
        $assignedEmployees = $order->orderSlots()
            ->with('staff.user')
            ->get()
            ->flatMap(function ($slot) {
                return $slot->staff->map(fn ($staff) => $staff->user);
            })
            ->unique('id');

        $assignedDrivers = $assignedEmployees->filter(function ($user) {
            return $user && $user->isDriverTrained();
        })->values();

        $allVehicles = $order->orderSlots()
            ->with('vehicles')
            ->get()
            ->flatMap(function ($slot) {
                return $slot->vehicles;
            })
            ->unique('id');

        return view('admin.leads.fulfill-order', compact('order', 'companyLocations', 'territories', 'allStaff', 'disciplinaryIssues', 'assignedEmployees', 'assignedDrivers', 'allVehicles'));
    }

    public function service_dashboard(Request $request, $orderId)
    {
        $order = ServiceOrder::with([
            'invoice',
            'orderSlots.clocks.clockedBy',
            'orderSlots.confirmedBy',
            'orderSlots.facilities.companyLocation',
            'orderSlots.office',
            'orderSlots.staff.user',
            'orderSlots.vehicles',
            'orderSlots.equipments.type',
            'service.outlines',
            'service.lead.company.locations',
            'notes.user',
            'employeePerformances.employee',
            'employeePerformances.issue',
            'employeePerformances.user',
            'roomRecords.creator',
            'equipmentRecords.creator',
            'equipmentRecords.equipment.type',
            'cleanPatches.creator',
        ])->findOrFail($orderId);

        $companyLocations = $order->service->lead->company->locations;
        $territories = Territory::orderBy('name')->get();

        $allStaff = User::whereNotNull('territory_id')
            ->whereNotNull('staff_type')
            ->get()
            ->groupBy(['territory_id', 'staff_type']);

        // Fetch all disciplinary issues
        $disciplinaryIssues = DisciplinaryIssue::orderBy('name')->get();

        // Get employees assigned to this order (from slots staff)
        $assignedEmployees = $order->orderSlots()
            ->with('staff.user')
            ->get()
            ->flatMap(function ($slot) {
                return $slot->staff->map(fn($staff) => $staff->user);
            })
            ->unique('id');

        $assignedDrivers = $assignedEmployees->filter(function ($user) {
            return $user && $user->isDriverTrained();
        })->values();

        $allVehicles = $order->orderSlots()
            ->with('vehicles')
            ->get()
            ->flatMap(function ($slot) {
                return $slot->vehicles;
            })
            ->unique('id');

        $equipments = Equipment::select('id', 'barcode', 'serial_number')->orderBy('barcode')->get();

        return view('admin.leads.service-dashboard', compact('order', 'companyLocations', 'territories', 'allStaff', 'disciplinaryIssues', 'assignedEmployees', 'assignedDrivers', 'allVehicles', 'equipments'));
    }

    public function assignEquipment(Request $request, $slotId)
    {
        $request->validate([
            'barcode' => 'required|string',
        ]);

        $slot = ServiceOrderSlot::with('serviceOrder')->findOrFail($slotId);

        // Find the equipment by barcode
        $equipment = Equipment::where('barcode', $request->barcode)->first();

        if (!$equipment) {
            return redirect()->back()->with('error', 'Equipment barcode not found.');
        }

        // Check if already assigned to this slot
        $alreadyAssignedToSlot = $slot->equipments()->where('equipment_id', $equipment->id)->exists();
        if ($alreadyAssignedToSlot) {
            return redirect()->back()->with('error', 'This equipment is already assigned to this slot.');
        }

        // Check if already assigned to any other slot
        if ($equipment->isAssigned()) {
            return redirect()->back()->with('error', 'This equipment is already assigned to another active order/slot.');
        }

        // Create status log
        EquipmentStatusLog::create([
            'equipment_id' => $equipment->id,
            'from_status' => config("mapping.equipment_status.{$equipment->status}", $equipment->status),
            'to_status' => 'assigned',
            'note' => 'Equipment assigned to job ' . ($slot->serviceOrder->order_no ?? $slot->serviceOrder->id) . ' by ' . (auth()->user()->name ?? 'System'),
            'territory_id' => $slot->scheduled_office ?: null,
            'changed_by' => auth()->id(),
        ]);

        // Attach equipment
        $slot->equipments()->attach($equipment->id);

        // Update equipment status to assigned
        $equipment->update(['status' => Equipment::STATUS_ASSIGNED]);

        return redirect()->back()->with('success', 'Equipment assigned successfully.');
    }

    public function removeEquipment(Request $request, $slotId, $equipmentId)
    {
        $slot = ServiceOrderSlot::with('serviceOrder')->findOrFail($slotId);
        $equipment = Equipment::findOrFail($equipmentId);

        // Create status log
        EquipmentStatusLog::create([
            'equipment_id' => $equipment->id,
            'from_status' => config("mapping.equipment_status.{$equipment->status}", $equipment->status),
            'to_status' => 'dirty',
            'note' => 'Equipment unassigned from job ' . ($slot->serviceOrder->order_no ?? $slot->serviceOrder->id) . ' by ' . (auth()->user()->name ?? 'System'),
            'territory_id' => $slot->scheduled_office ?: null,
            'changed_by' => auth()->id(),
        ]);

        // Detach
        $slot->equipments()->detach($equipment->id);

        // Update equipment status
        $equipment->update(['status' => Equipment::STATUS_DIRTY]);

        return redirect()->back()->with('success', 'Equipment removed successfully.');
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
            'status'                   => 'scheduled',
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
            'status' => 'confirmed',
        ]);

        $this->notify->dayOfService($slot);

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
        $staff = ServiceOrderSlotStaff::with(['user', 'slot.serviceOrder.service'])->findOrFail($staffId);
        $user = $staff->user;
        $slot = $staff->slot;

        $staff->delete();

        if ($user && $slot) {
            $this->notify->staffUnassignedFromOrder($user, $slot);
        }

        return redirect()->back()->with('success', 'Staff removed from slot.');
    }

    public function toggleLeader(Request $request, $staffId)
    {
        $staff = ServiceOrderSlotStaff::with(['user', 'slot.serviceOrder.service'])->findOrFail($staffId);
        $staff->is_leader = !$staff->is_leader;
        $staff->save();

        $user = $staff->user;
        $slot = $staff->slot;

        if ($user && $slot) {
            if ($staff->is_leader) {
                $this->notify->staffMarkedAsLeader($user, $slot);
            } else {
                $this->notify->staffUnmarkedAsLeader($user, $slot);
            }
        }

        return redirect()->back()->with('success', 'Staff leadership status updated.');
    }

    public function assignVehicles(Request $request, $slotId)
    {
        $request->validate([
            'vehicle_ids' => 'required|array|min:1',
            'vehicle_ids.*' => 'exists:vehicles,id',
        ]);

        $slot = ServiceOrderSlot::findOrFail($slotId);

        $start = $slot->scheduled_start_time;
        $end   = $slot->scheduled_end_time;

        if ($start && $end) {
            $occupiedStart = $start->copy()->subHour();
            $occupiedEnd   = $end->copy()->addHour();
            $targetDate    = $start->toDateString();

            foreach ($request->vehicle_ids as $vehicleId) {
                // Find conflicting slots on the same day for this vehicle
                $existingSlots = ServiceOrderSlot::where('id', '!=', $slot->id)
                    ->whereHas('vehicles', function ($q) use ($vehicleId) {
                        $q->where('vehicles.id', $vehicleId);
                    })
                    ->get()
                    ->filter(function ($s) use ($targetDate) {
                        return $s->scheduled_start_time && $s->scheduled_start_time->toDateString() === $targetDate;
                    });

                foreach ($existingSlots as $existingSlot) {
                    $existingStart = $existingSlot->scheduled_start_time;
                    $existingEnd   = $existingSlot->scheduled_end_time;

                    if ($existingStart && $existingEnd) {
                        $existingOccupiedStart = $existingStart->copy()->subHour();
                        $existingOccupiedEnd   = $existingEnd->copy()->addHour();

                        // Overlap check on occupied durations (inclusive of 1 hour buffer)
                        if ($occupiedStart < $existingOccupiedEnd && $occupiedEnd > $existingOccupiedStart) {
                            $vehicle = Vehicle::find($vehicleId);
                            $vehicleName = $vehicle ? ($vehicle->name ?? $vehicle->plate_number) : 'Vehicle';
                            
                            $formattedStart = $existingStart->format('h:i A');
                            $formattedEnd = $existingEnd->format('h:i A');
                            $bufferStart = $existingOccupiedStart->format('h:i A');
                            $bufferEnd = $existingOccupiedEnd->format('h:i A');
                            
                            return back()->with('error', "Vehicle '{$vehicleName}' is already booked on this day from {$formattedStart} to {$formattedEnd} (Occupied buffer: {$bufferStart} to {$bufferEnd}).");
                        }
                    }
                }
            }
        }

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

        $note = ServiceNote::create([
            'service_order_id'  => $orderId,
            'user_id'           => auth()->id(),
            'notes'             => $request->notes,
            'image_path'        => $imagePath,
            'notify_sales_team' => $request->boolean('notify_sales_team'),
        ]);

        if ($note->notify_sales_team) {
            $this->notify->serviceNoteAdded($note);
        }

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

    public function addServiceOutline(Request $request, $serviceId)
    {
        $request->validate([
            'outline_name' => 'required|string|max:255',
        ]);

        ServiceOutline::create([
            'service_id'   => $serviceId,
            'outline_name' => $request->outline_name,
            'range'        => 0,
        ]);

        return redirect()->back()->with('success', 'Department added successfully.');
    }

    /**
     * Clock in - per slot
     */
    public function clockIn(Request $request)
    {
        $request->validate([
            'slot_id'        => 'required|exists:service_order_slots,id',
            'type'           => 'required|in:service,travel,break,office work,warehouse,training,service prep,umc',
            'vehicle_id'     => 'required_if:type,travel|nullable|exists:vehicles,id',
            'driver_user_id' => 'required_if:type,travel|nullable|exists:users,id',
        ]);

        $slot = ServiceOrderSlot::findOrFail($request->slot_id);

        // Prevent the slot from having two active clocks of the same type simultaneously
        $activeClock = $slot->clocks()
            ->where('type', $request->type)
            ->whereNull('clocked_out_at')
            ->first();

        if ($activeClock) {
            return redirect()->back()->with('error',
                ucfirst($request->type) . ' clock is already running for this slot.'
            );
        }

        $clockData = [
            'type'          => $request->type,
            'clocked_by'    => auth()->id(),
            'clocked_in_at' => now(),
        ];

        if ($request->type === 'travel') {
            $clockData['vehicle_id']    = $request->vehicle_id;
            $clockData['driver_user_id'] = $request->driver_user_id;
        }

        $slot->clocks()->create($clockData);

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
                'No active ' . $request->type . ' clock found for this slot.'
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
                'color' => match($slot->status) {
                    'scheduled'   => '#ffb81c',
                    'confirmed'   => '#0d6efd',
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
                    'status'       => $slot->status ?? 'pending',
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

        // Update pre_checklist_consumables if provided
        if ($request->has('pre_checklist_consumables')) {
            $request->validate([
                'pre_checklist_consumables' => 'nullable|array',
                'pre_checklist_consumables.*' => 'nullable|numeric|min:0',
            ]);
            $updateData['pre_checklist_consumables'] = $request->input('pre_checklist_consumables');
        }

        // Update post_checklist_consumables if provided
        if ($request->has('post_checklist_consumables')) {
            $request->validate([
                'post_checklist_consumables' => 'nullable|array',
                'post_checklist_consumables.*' => 'nullable|numeric|min:0',
            ]);
            $updateData['post_checklist_consumables'] = $request->input('post_checklist_consumables');
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

    public function myJobs(Request $request)
    {
        $userId = auth()->id();

        // Parse date from request, default to today
        $date = $request->date
            ? \Carbon\Carbon::parse($request->date)
            : \Carbon\Carbon::today();

        // Retrieve slots assigned to this user on the selected date
        $slots = ServiceOrderSlot::with([
                'serviceOrder.service.lead.company',
                'vehicles',
                'staff.user'
            ])
            ->whereDate('scheduled_start_time', $date)
            ->where('is_confirmed', true)
            ->whereHas('staff', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->orderBy('scheduled_start_time')
            ->get();

        // Calculate total hours scheduled for this user today
        $totalHours = 0;
        foreach ($slots as $slot) {
            $userPivot = $slot->staff->firstWhere('user_id', $userId);
            // If specific slot hours are set on pivot, use that; otherwise fallback to scheduled_hours
            $totalHours += $userPivot && $userPivot->slot_hours ? $userPivot->slot_hours : ($slot->scheduled_hours ?? 0);
        }

        return view('admin.jobs.my-jobs', compact('slots', 'date', 'totalHours'));
    }

    /**
     * Save/Append hotel details to the service order
     */
    public function saveHotelDetails(Request $request, $orderId)
    {
        $request->validate([
            'hotel_name'         => 'required|string|max:255',
            'full_address'       => 'nullable|string|max:500',
            'confirmation_no'    => 'nullable|string|max:255',
            'check_in'           => 'nullable|date',
            'check_out'          => 'nullable|date',
        ]);

        $order = ServiceOrder::findOrFail($orderId);

        // Retrieve existing hotel details array
        $hotels = $order->hotel_details ?? [];

        // Generate a unique ID for the new hotel entry
        $newHotel = [
            'id'              => uniqid(),
            'hotel_name'      => $request->input('hotel_name'),
            'full_address'    => $request->input('full_address'),
            'confirmation_no' => $request->input('confirmation_no'),
            'check_in'        => $request->input('check_in'),
            'check_out'       => $request->input('check_out'),
        ];

        $hotels[] = $newHotel;

        $order->update([
            'hotel_details' => $hotels
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Hotel details added successfully',
                'hotels'  => $hotels
            ]);
        }

        return redirect()->back()->with('success', 'Hotel details added successfully.');
    }

    /**
     * Delete a specific hotel detail entry from the array list
     */
    public function deleteHotelDetail(Request $request, $orderId)
    {
        $request->validate([
            'hotel_entry_id' => 'required|string',
        ]);

        $order = ServiceOrder::findOrFail($orderId);
        $hotels = $order->hotel_details ?? [];

        // Filter out the requested hotel ID
        $updatedHotels = array_filter($hotels, function ($hotel) use ($request) {
            return ($hotel['id'] ?? '') !== $request->input('hotel_entry_id');
        });

        // Reindex array keys
        $updatedHotels = array_values($updatedHotels);

        $order->update([
            'hotel_details' => $updatedHotels
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Hotel detail removed successfully',
                'hotels'  => $updatedHotels
            ]);
        }

        return redirect()->back()->with('success', 'Hotel detail removed successfully.');
    }

    /**
     * Save/Append ATP details to the service order
     */
    public function saveAtpDetails(Request $request, $orderId)
    {
        $request->validate([
            'atp_type'    => 'required|in:pre,post',
            'facility_id' => 'required|string',
            'result'      => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $order = ServiceOrder::findOrFail($orderId);
        $atpRecords = $order->atp_details ?? [];

        $newRecord = [
            'id'          => uniqid(),
            'atp_type'    => $request->input('atp_type'),
            'facility_id' => $request->input('facility_id'),
            'result'      => $request->input('result'),
            'description' => $request->input('description'),
            'created_at'  => now()->toDateTimeString(),
        ];

        $atpRecords[] = $newRecord;

        $order->update([
            'atp_details' => $atpRecords
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'ATP details added successfully',
                'atp_details' => $atpRecords
            ]);
        }

        return redirect()->back()->with('success', 'ATP details added successfully.');
    }

    /**
     * Delete a specific ATP detail entry from the array list
     */
    public function deleteAtpDetail(Request $request, $orderId)
    {
        $request->validate([
            'atp_entry_id' => 'required|string',
        ]);

        $order = ServiceOrder::findOrFail($orderId);
        $atpRecords = $order->atp_details ?? [];

        // Filter out the requested ATP ID
        $updatedRecords = array_filter($atpRecords, function ($record) use ($request) {
            return ($record['id'] ?? '') !== $request->input('atp_entry_id');
        });

        // Reindex array keys
        $updatedRecords = array_values($updatedRecords);

        $order->update([
            'atp_details' => $updatedRecords
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'ATP detail removed successfully',
                'atp_details' => $updatedRecords
            ]);
        }

        return redirect()->back()->with('success', 'ATP detail removed successfully.');
    }

    /**
     * Update Service Order status manually.
     */
    public function updateOrderStatus(Request $request, $orderId)
    {
        $request->validate([
            'status' => 'required|string|in:pending,scheduled,in_progress,completed,cancelled',
        ]);

        $order = ServiceOrder::findOrFail($orderId);
        $newStatus = $request->input('status');

        if ($newStatus === 'completed') {
            // Verify that all associated Scheduled Slots are already marked as Completed.
            $nonCompletedSlots = $order->orderSlots->filter(function ($slot) {
                return $slot->status !== 'completed';
            });

            if ($nonCompletedSlots->isNotEmpty()) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Cannot mark Service Order as Completed because there are ' . $nonCompletedSlots->count() . ' slot(s) not yet marked as Completed.'
                    ], 422);
                }
                return redirect()->back()->with('error', 'Cannot mark Service Order as Completed because there are ' . $nonCompletedSlots->count() . ' slot(s) not yet marked as Completed.');
            }
        }

        $order->update([
            'status' => $newStatus
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Service Order status updated to ' . ucfirst($newStatus) . ' successfully.',
                'status' => $newStatus
            ]);
        }

        return redirect()->back()->with('success', 'Service Order status updated to ' . ucfirst($newStatus) . ' successfully.');
    }

    /**
     * Update Scheduled Slot status manually.
     */
    public function updateSlotStatus(Request $request, $slotId)
    {
        $request->validate([
            'status' => 'required|string|in:pending,scheduled,confirmed,in_progress,completed,cancelled',
        ]);

        $slot = ServiceOrderSlot::findOrFail($slotId);
        $newStatus = $request->input('status');

        $slot->update([
            'status' => $newStatus
        ]);

        if (in_array($newStatus, ['confirmed', 'in_progress'])) {
            $this->notify->dayOfService($slot);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Slot status updated to ' . ucfirst($newStatus) . ' successfully.',
                'status' => $newStatus
            ]);
        }

        return redirect()->back()->with('success', 'Slot status updated to ' . ucfirst($newStatus) . ' successfully.');
    }

    public function saveInvoice(Request $request, $orderId, $invoiceId = null)
    {
        $order = ServiceOrder::findOrFail($orderId);

        $request->validate([
            'invoice_no' => 'required|string',
            'invoice_type' => 'required|string|in:Deposit,Progress,Final,Adjustment',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'notes' => 'nullable|string',
            'items' => 'required|array',
            'items.*.type' => 'required|string',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        $totalAmount = 0;
        $items = [];
        foreach ($request->items as $item) {
            $subtotal = round($item['qty'] * $item['price'], 2);
            $totalAmount += $subtotal;
            $items[] = [
                'type' => $item['type'],
                'qty' => (int) $item['qty'],
                'price' => (float) $item['price'],
                'total' => $subtotal,
            ];
        }

        if ($invoiceId) {
            $invoice = ServiceOrderInvoice::findOrFail($invoiceId);
            if (in_array($invoice->status, ['Paid', 'Cancelled'])) {
                return redirect()->back()->with('error', 'Cannot modify Paid or Cancelled invoices.');
            }
            $invoice->update([
                'invoice_no' => $request->invoice_no,
                'invoice_type' => $request->invoice_type,
                'invoice_date' => $request->invoice_date,
                'due_date' => $request->due_date,
                'notes' => $request->notes,
                'line_items' => $items,
                'total_amount' => $totalAmount,
                'updated_by' => auth()->id(),
            ]);
        } else {
            ServiceOrderInvoice::create([
                'service_order_id' => $order->id,
                'invoice_no' => $request->invoice_no,
                'invoice_type' => $request->invoice_type,
                'invoice_date' => $request->invoice_date,
                'due_date' => $request->due_date,
                'status' => 'Draft',
                'notes' => $request->notes,
                'line_items' => $items,
                'total_amount' => $totalAmount,
                'created_by' => auth()->id(),
            ]);
        }

        return redirect()->back()->with('success', 'Invoice details updated successfully.');
    }

    public function shareInvoice(Request $request, $invoiceId)
    {
        $invoice = ServiceOrderInvoice::findOrFail($invoiceId);
        $order = ServiceOrder::with('service.lead.company.companyEmail', 'service.lead.company.locations')->findOrFail($invoice->service_order_id);

        $recipientEmail = $request->input('recipient_email') ?: ($order->service->lead->company->companyEmail->email ?? $order->service->lead->email ?? null);
        if (!$recipientEmail) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Customer does not have a valid email address.']);
            }
            return redirect()->back()->with('error', 'Customer does not have a valid email address.');
        }

        if ($invoice->status === 'Cancelled') {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Cannot share cancelled invoices.']);
            }
            return redirect()->back()->with('error', 'Cannot share cancelled invoices.');
        }

        $invoiceDetails = [
            'invoice_no' => $invoice->invoice_no,
            'invoice_type' => $invoice->invoice_type,
            'invoice_date' => $invoice->invoice_date ? ($invoice->invoice_date instanceof \Carbon\Carbon ? $invoice->invoice_date->format('Y-m-d') : $invoice->invoice_date) : date('Y-m-d'),
            'due_date' => $invoice->due_date ? ($invoice->due_date instanceof \Carbon\Carbon ? $invoice->due_date->format('Y-m-d') : $invoice->due_date) : date('Y-m-d'),
            'status' => $invoice->status,
            'notes' => $invoice->notes,
            'items' => $invoice->line_items,
            'total_amount' => $invoice->total_amount,
        ];
        $invoiceDetails['company_name'] = $order->service->lead->company->name ?? 'N/A';
        $invoiceDetails['email_message'] = $request->email_message ?? 'Please find details of your invoice below.';

        // Generate PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.invoice', compact('order', 'invoiceDetails'));
        $pdfContent = base64_encode($pdf->output());

        $attachment = [
            'base64_data' => $pdfContent,
            'name' => 'invoice-' . ($invoice->invoice_no ?? $order->id) . '.pdf',
            'mime' => 'application/pdf',
        ];

        // Dispatch SendEmailJob using NotificationService
        $this->notify->shareInvoice($recipientEmail, $order, $invoiceDetails, $attachment);

        // Update status and sent info
        $invoice->update([
            'status' => 'Sent',
            'sent_by' => auth()->id(),
            'sent_date' => now(),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Invoice shared with customer successfully.'
            ]);
        }

        return redirect()->back()->with('success', 'Invoice shared with customer successfully.');
    }

    public function downloadInvoicePdf($invoiceId)
    {
        $invoice = ServiceOrderInvoice::findOrFail($invoiceId);
        $order = ServiceOrder::with('service.lead.company')->findOrFail($invoice->service_order_id);

        $invoiceDetails = [
            'invoice_no' => $invoice->invoice_no,
            'invoice_type' => $invoice->invoice_type,
            'invoice_date' => $invoice->invoice_date ? ($invoice->invoice_date instanceof \Carbon\Carbon ? $invoice->invoice_date->format('Y-m-d') : $invoice->invoice_date) : date('Y-m-d'),
            'due_date' => $invoice->due_date ? ($invoice->due_date instanceof \Carbon\Carbon ? $invoice->due_date->format('Y-m-d') : $invoice->due_date) : date('Y-m-d'),
            'status' => $invoice->status,
            'notes' => $invoice->notes,
            'items' => $invoice->line_items,
            'total_amount' => $invoice->total_amount,
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.invoice', compact('order', 'invoiceDetails'));
        return $pdf->download('invoice-' . ($invoice->invoice_no ?? $order->id) . '.pdf');
    }

    public function downloadInvoiceCsv($invoiceId)
    {
        $invoice = ServiceOrderInvoice::findOrFail($invoiceId);
        $order = ServiceOrder::with('service.lead.company')->findOrFail($invoice->service_order_id);

        $invoiceDetails = [
            'invoice_no' => $invoice->invoice_no,
            'invoice_type' => $invoice->invoice_type,
            'invoice_date' => $invoice->invoice_date ? ($invoice->invoice_date instanceof \Carbon\Carbon ? $invoice->invoice_date->format('Y-m-d') : $invoice->invoice_date) : date('Y-m-d'),
            'due_date' => $invoice->due_date ? ($invoice->due_date instanceof \Carbon\Carbon ? $invoice->due_date->format('Y-m-d') : $invoice->due_date) : date('Y-m-d'),
            'status' => $invoice->status,
            'notes' => $invoice->notes,
            'items' => $invoice->line_items,
            'total_amount' => $invoice->total_amount,
        ];
        $items = $invoiceDetails['items'] ?? [];

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="invoice-' . ($invoice->invoice_no ?? $order->id) . '.csv"',
        ];

        $callback = function () use ($order, $invoiceDetails, $items) {
            $file = fopen('php://output', 'w');

            // Metadata / Header info
            fputcsv($file, ['Invoice Number', $invoiceDetails['invoice_no']]);
            fputcsv($file, ['Invoice Type', $invoiceDetails['invoice_type'] ?? 'Final']);
            fputcsv($file, ['Order Number', $order->order_no ?? 'N/A']);
            fputcsv($file, ['Invoice Date', $invoiceDetails['invoice_date'] ?? '']);
            fputcsv($file, ['Due Date', $invoiceDetails['due_date'] ?? '']);

            fputcsv($file, ['Customer Name', $order->service->lead->company->name ?? 'N/A']);
            fputcsv($file, []); // Empty row

            // Line Items header
            fputcsv($file, ['Item Description', 'Quantity', 'Price', 'Total']);

            // Line Items data
            foreach ($items as $item) {
                fputcsv($file, [
                    $item['type'] ?? '',
                    $item['qty'] ?? 1,
                    $item['price'] ?? 0.00,
                    $item['total'] ?? 0.00,
                ]);
            }

            fputcsv($file, []); // Empty row
            fputcsv($file, ['', '', 'Amount Due', $invoiceDetails['total_amount'] ?? 0.00]);
            
            if (!empty($invoiceDetails['notes'])) {
                fputcsv($file, []);
                fputcsv($file, ['Notes', $invoiceDetails['notes']]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function markPaid(Request $request, $invoiceId)
    {
        $invoice = ServiceOrderInvoice::findOrFail($invoiceId);

        if ($invoice->status === 'Cancelled') {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Cannot mark a cancelled invoice as Paid.']);
            }
            return redirect()->back()->with('error', 'Cannot mark a cancelled invoice as Paid.');
        }

        $invoice->update([
            'status' => 'Paid',
            'updated_by' => auth()->id()
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Invoice marked as Paid successfully.'
            ]);
        }

        return redirect()->back()->with('success', 'Invoice marked as Paid successfully.');
    }

    public function cancelInvoice(Request $request, $invoiceId)
    {
        $invoice = ServiceOrderInvoice::findOrFail($invoiceId);

        $request->validate([
            'cancellation_reason' => 'required|string|max:1000'
        ]);

        if ($invoice->status === 'Paid') {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Cannot cancel a paid invoice.']);
            }
            return redirect()->back()->with('error', 'Cannot cancel a paid invoice.');
        }

        $invoice->update([
            'status' => 'Cancelled',
            'cancellation_reason' => $request->cancellation_reason,
            'updated_by' => auth()->id()
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Invoice cancelled successfully.'
            ]);
        }

        return redirect()->back()->with('success', 'Invoice cancelled successfully.');
    }

    public function saveRoomRecord(Request $request, $orderId)
    {
        $request->validate([
            'barcode' => 'required|string',
        ]);

        $order = ServiceOrder::findOrFail($orderId);

        $order->roomRecords()->create([
            'barcode' => $request->barcode,
            'created_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Room barcode recorded successfully.');
    }

    public function deleteRoomRecord($recordId)
    {
        $record = ServiceOrderRoomRecord::findOrFail($recordId);
        $record->delete();

        return redirect()->back()->with('success', 'Room barcode record deleted successfully.');
    }

    public function saveEquipmentRecord(Request $request, $orderId)
    {
        $request->validate([
            'barcode' => 'required|string',
            'status' => 'required|string|in:service,washed',
        ]);

        $exists = Equipment::where('barcode', $request->barcode)->exists();
        if (!$exists) {
            return redirect()->back()->with('error', 'Warning: The entered barcode is not registered in the system.')->withInput();
        }

        $order = ServiceOrder::findOrFail($orderId);

        $order->equipmentRecords()->create([
            'barcode' => $request->barcode,
            'status' => $request->status,
            'created_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Equipment barcode record saved successfully.');
    }

    public function deleteEquipmentRecord($recordId)
    {
        $record = ServiceOrderEquipmentRecord::findOrFail($recordId);
        $record->delete();

        return redirect()->back()->with('success', 'Equipment barcode record deleted successfully.');
    }

    public function saveCleanPatch(Request $request, $orderId)
    {
        $request->validate([
            'barcode' => 'required|string',
            'patch_size' => 'required|string',
        ]);

        $order = ServiceOrder::findOrFail($orderId);

        $order->cleanPatches()->create([
            'barcode' => $request->barcode,
            'patch_size' => $request->patch_size,
            'created_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Clean patch record saved successfully.');
    }

    public function deleteCleanPatch($patchId)
    {
        $patch = ServiceOrderCleanPatch::findOrFail($patchId);
        $patch->delete();

        return redirect()->back()->with('success', 'Clean patch record deleted successfully.');
    }
}


