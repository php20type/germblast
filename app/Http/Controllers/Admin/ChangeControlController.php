<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChangeRequest;
use App\Models\ChangeRequestTask;
use App\Models\ChangeRequestDocumentation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ChangeControlController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:change_control.view', only: ['index', 'show']),
            new Middleware('permission:change_control.add', only: ['store']),
            new Middleware('permission:change_control.edit', only: ['update', 'updateStatus', 'storeTask', 'updateTaskStatus', 'storeDocumentation']),
        ];
    }
    /**
     * Display a listing of change requests.
     */
    public function index()
    {
        $requests = ChangeRequest::with('requester')->get();
        return view('admin.change-control.index', compact('requests'));
    }

    /**
     * Store a newly created change request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        try {
            $changeRequest = ChangeRequest::create([
                'title' => $request->title,
                'description' => $request->description,
                'requester_id' => auth()->id(),
                'status' => 'Open',
            ]);

            // Add an initial system documentation entry
            ChangeRequestDocumentation::create([
                'change_request_id' => $changeRequest->id,
                'user_id' => auth()->id(),
                'notes' => 'Change request created.',
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Change request created successfully.'
                ]);
            }

            return redirect()->back()
                ->with('success', 'Change request created successfully.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Something went wrong!'], 500);
            }
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Update the specified change request.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        try {
            $changeRequest = ChangeRequest::findOrFail($id);
            $changeRequest->update([
                'title' => $request->title,
                'description' => $request->description,
            ]);

            // Add a documentation entry
            ChangeRequestDocumentation::create([
                'change_request_id' => $changeRequest->id,
                'user_id' => auth()->id(),
                'notes' => 'Change request details updated.',
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Change request updated successfully.'
                ]);
            }

            return redirect()->route('admin.change-control.index')
                ->with('success', 'Change request updated successfully.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Something went wrong!'], 500);
            }
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Display the specified change request detail page.
     */
    public function show($id)
    {
        $changeRequest = ChangeRequest::with(['requester', 'tasks.assignee', 'documentations.user'])
            ->findOrFail($id);
        
        $users = User::all();

        return view('admin.change-control.show', compact('changeRequest', 'users'));
    }

    /**
     * Update the status of a change request.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:Open,Approved,Rejected,Closed',
        ]);

        try {
            $changeRequest = ChangeRequest::findOrFail($id);
            $oldStatus = $changeRequest->status;
            $changeRequest->update([
                'status' => $request->status
            ]);

            // Record status change in documentation history
            ChangeRequestDocumentation::create([
                'change_request_id' => $changeRequest->id,
                'user_id' => auth()->id(),
                'notes' => "Status changed from '{$oldStatus}' to '{$request->status}'.",
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Status updated successfully.'
                ]);
            }

            return redirect()->back()->with('success', 'Status updated successfully.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Something went wrong!'], 500);
            }
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Store a new task for a change request.
     */
    public function storeTask(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
        ]);

        try {
            $changeRequest = ChangeRequest::findOrFail($id);

            $task = ChangeRequestTask::create([
                'change_request_id' => $changeRequest->id,
                'title' => $request->title,
                'assigned_to' => $request->assigned_to,
                'due_date' => $request->due_date,
                'status' => 'Pending',
            ]);

            // Record task creation in documentation history
            $assigneeName = $task->assignee ? $task->assignee->name : 'Unassigned';
            ChangeRequestDocumentation::create([
                'change_request_id' => $changeRequest->id,
                'user_id' => auth()->id(),
                'notes' => "Task '{$task->title}' added. Assigned to: {$assigneeName}.",
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Task added successfully.'
                ]);
            }

            return redirect()->back()->with('success', 'Task added successfully.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Something went wrong!'], 500);
            }
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Update/toggle the status of a task.
     */
    public function updateTaskStatus(Request $request, $id, $taskId)
    {
        $request->validate([
            'status' => 'required|string|in:Pending,Completed',
        ]);

        try {
            $task = ChangeRequestTask::where('change_request_id', $id)->findOrFail($taskId);
            $task->update([
                'status' => $request->status
            ]);

            // Record task update in documentation history
            ChangeRequestDocumentation::create([
                'change_request_id' => $id,
                'user_id' => auth()->id(),
                'notes' => "Task '{$task->title}' marked as {$request->status}.",
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Task status updated successfully.'
                ]);
            }

            return redirect()->back()->with('success', 'Task status updated successfully.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Something went wrong!'], 500);
            }
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Store a new documentation/history entry.
     */
    public function storeDocumentation(Request $request, $id)
    {
        $request->validate([
            'notes' => 'required|string',
        ]);

        try {
            $changeRequest = ChangeRequest::findOrFail($id);

            ChangeRequestDocumentation::create([
                'change_request_id' => $changeRequest->id,
                'user_id' => auth()->id(),
                'notes' => $request->notes,
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Documentation entry added successfully.'
                ]);
            }

            return redirect()->back()->with('success', 'Documentation entry added successfully.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Something went wrong!'], 500);
            }
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }
}
