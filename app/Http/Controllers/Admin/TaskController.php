<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyTask;
use App\Models\LeadTask;
use App\Models\PeopleTask;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // public function ajax_store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'due_date' => 'nullable|date',
    //         'assignee_id' => 'nullable|exists:users,id',
    //         'related_to' => 'required|integer',
    //         'related_type' => 'required|string|in:company,people,lead',
    //         'notes' => 'nullable|string',
    //     ]);

    //     $assignee = User::find($validated['assignee_id']);
    //     $assigneeName = $assignee->name;
    //     $dueTime = Carbon::parse($validated['due_date'])->format('Y-m-d H:i:s');

    //     // Prepare base task data (common fields)
    //     $data = [
    //         'title' => $validated['name'],
    //         'description' => $validated['notes'] ?? null,
    //         'created_time' => now(),
    //         'due_time' => $dueTime,
    //         'assignee_id' => $validated['assignee_id'] ?? null,
    //         'assignee_name' => $assigneeName,
    //         'created_at' => now(),
    //     ];

    //     // Create task in respective model
    //     switch ($validated['related_type']) {
    //         case 'company':
    //             $data['company_id'] = $validated['related_to'];
    //             CompanyTask::create($data);
    //             break;

    //         case 'people':
    //             $data['people_id'] = $validated['related_to'];
    //             PeopleTask::create($data);
    //             break;

    //         case 'lead':
    //             $data['lead_id'] = $validated['related_to'];
    //             LeadTask::create($data);
    //             break;

    //         default:
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Invalid related type.',
    //             ], 422);
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Task added successfully.',
    //     ]);
    // }

    public function ajax_store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'due_date' => 'nullable|date',
            'assignee_id' => 'nullable|exists:users,id',
            'related_to' => 'required|integer',
            'related_type' => 'required|string|in:company,people,lead',
            'notes' => 'nullable|string',
        ]);

        $assignee = User::find($validated['assignee_id']);
        $assigneeName = $assignee ? $assignee->name : null;
        $dueTime = $validated['due_date'] ? Carbon::parse($validated['due_date'])->format('Y-m-d H:i:s') : null;

        // Prepare unified task data
        $data = [
            'title' => $validated['name'],
            'description' => $validated['notes'] ?? null,
            'created_time' => now(),
            'due_time' => $dueTime,
            'assignee_id' => $validated['assignee_id'] ?? null,
            'assignee_name' => $assigneeName,
            'owner_type' => ucfirst($validated['related_type']), // Company, People, Lead
            'owner_id' => $validated['related_to'],
        ];

        // Create the task in unified tasks table
        Task::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Task added successfully.',
        ]);
    }
}
