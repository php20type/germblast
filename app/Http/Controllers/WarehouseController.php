<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WarehouseTask;
use App\Models\WarehouseTaskCompletion;
use App\Models\Vehicle;
use App\Models\WarehouseSchedule;
use App\Models\User;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class WarehouseController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:warehouse.view', only: ['maintenance']),
            new Middleware('permission:warehouse.add', only: ['store', 'update', 'complete', 'reset', 'destroy']),
            new Middleware('permission:warehouse_calendar.view', only: ['calendar']),
            new Middleware('permission:warehouse_calendar.edit', only: ['storeSchedule', 'destroySchedule']),
        ];
    }
    /**
     * Display the warehouse maintenance dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function maintenance()
    {
        $generalTasks = WarehouseTask::with(['vehicle', 'completions' => fn($q) => $q->with('user')->latest('completed_at')])->where('form_type', 1)->get();
        $dataTasks = WarehouseTask::with(['vehicle', 'completions' => fn($q) => $q->with('user')->latest('completed_at')])->where('form_type', 2)->get();
        $vehicleTasks = WarehouseTask::with(['vehicle', 'completions' => fn($q) => $q->with('user')->latest('completed_at')])->where('form_type', 3)->get();
        $trailerTasks = WarehouseTask::with(['vehicle', 'completions' => fn($q) => $q->with('user')->latest('completed_at')])->where('form_type', 4)->get();
        $inventoryTasks = WarehouseTask::with(['vehicle', 'completions' => fn($q) => $q->with('user')->latest('completed_at')])->where('form_type', 5)->get();

        // Load active vehicles to dynamically populate selection options in Blade form
        $vehicles = Vehicle::where('is_retired', 0)->orderBy('name')->get();

        return view('warehous.maintenance', compact(
            'generalTasks', 
            'dataTasks', 
            'vehicleTasks', 
            'trailerTasks', 
            'inventoryTasks', 
            'vehicles'
        ));
    }

    /**
     * Store a newly created warehouse task in the database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'supplier' => 'nullable|string|max:255',
            'unit_of_measure' => 'nullable|string|max:255',
            'reorder_point' => 'nullable|string|max:255',
            'reorder_quantity' => 'nullable|string|max:255',
            'frequency' => 'required|integer',
            'form_type' => 'required|integer',
            'vehicle_id' => 'nullable|integer',
        ]);

        try {
            // Nullify vehicle_id if it's 0 or empty string
            if (empty($validated['vehicle_id'])) {
                $validated['vehicle_id'] = null;
            }

            WarehouseTask::create($validated);

            return response()->json([
                'success' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong!',
            ], 500);
        }
    }

    /**
     * Update the specified task settings in the database.
     */
    public function update(Request $request, $id)
    {
        $task = WarehouseTask::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'supplier' => 'nullable|string|max:255',
            'unit_of_measure' => 'nullable|string|max:255',  
            'reorder_point' => 'nullable|string|max:255',
            'reorder_quantity' => 'nullable|string|max:255',
            'frequency' => 'required|integer',
            'form_type' => 'required|integer',
            'vehicle_id' => 'nullable|integer',
        ]);

        try {
            if (empty($validated['vehicle_id'])) {
                $validated['vehicle_id'] = null;
            }

            $task->update($validated);

            return response()->json([
                'success' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong!',
            ], 500);
        }
    }

    /**
     * Complete a pending warehouse task.
     */
    public function complete(Request $request, $id)
    {
        $task = WarehouseTask::findOrFail($id);

        $validated = $request->validate([
            'last_performed_by' => 'required|string|max:255',
            'last_performed_on' => 'required|string|max:255',
            'notes' => 'required|string',
        ]);

        try {
            WarehouseTaskCompletion::create([
                'warehouse_task_id' => $task->id,
                'user_id' => auth()->id(),
                'notes' => $validated['notes'],
                'completed_at' => now(),
            ]);

            $task->update([
                'last_performed_by' => $validated['last_performed_by'],
                'last_performed_on' => $validated['last_performed_on'],
                'notes' => $validated['notes'],
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong!',
            ], 500);
        }
    }

    /**
     * Reset a completed task back to pending (due).
     */
    public function reset($id)
    {
        try {
            $task = WarehouseTask::findOrFail($id);
            
            $latestCompletion = $task->completions()->latest('completed_at')->first();
            if ($latestCompletion) {
                $latestCompletion->delete();
            }
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong!',
            ], 500);
        }
    }

    /**
     * Remove the specified task from database storage.
     */
    public function destroy($id)
    {
        try {
            $task = WarehouseTask::findOrFail($id);
            $task->delete();
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong!',
            ], 500);
        }
    }

    /**
     * Display the warehouse calendar dashboard.
     */
    public function calendar()
    {
        $schedules = WarehouseSchedule::all()->map(function ($schedule) {
            $typeName = $schedule->type == 1 ? 'Regular Service' : 'Call';
            return [
                'id' => (string) $schedule->id,
                'title' => $schedule->employee . ' - ' . $typeName,
                'start' => $schedule->start_time ? $schedule->start_time->toIso8601String() : '',
                'end' => $schedule->end_time ? $schedule->end_time->toIso8601String() : '',
                'type' => $typeName,
                'employee' => $schedule->employee
            ];
        });

        $employees = User::orderBy('name')->get();
        if ($employees->isEmpty()) {
            $employees = collect([
                (object) ['id' => 1, 'name' => 'Blake Mitchell'],
                (object) ['id' => 2, 'name' => 'Jacob Campbell'],
                (object) ['id' => 3, 'name' => 'Carlo Saia Lubbock'],
            ]);
        }

        return view('warehous.calendar', compact('employees', 'schedules'));
    }

    /**
     * Store a newly created schedule.
     */
    public function storeSchedule(Request $request)
    {
        $validated = $request->validate([
            'employee' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
            'type' => 'required|integer|in:1,2',
        ]);

        try {
            $schedule = WarehouseSchedule::create($validated);

            $typeName = $schedule->type == 1 ? 'Regular Service' : 'Call';

            return response()->json([
                'success' => true,
                'schedule' => [
                    'id' => (string) $schedule->id,
                    'title' => $schedule->employee . ' - ' . $typeName,
                    'start' => $schedule->start_time ? $schedule->start_time->toIso8601String() : '',
                    'end' => $schedule->end_time ? $schedule->end_time->toIso8601String() : '',
                    'type' => $typeName,
                    'employee' => $schedule->employee
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong!',
            ], 500);
        }
    }

    /**
     * Delete the specified schedule.
     */
    public function destroySchedule($id)
    {
        try {
            $schedule = WarehouseSchedule::findOrFail($id);
            $schedule->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong!',
            ], 500);
        }
    }
}
