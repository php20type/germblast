<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LeadTaskController extends Controller
{
    public function addTask(Request $request, $leadId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'due_date' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'description' => 'nullable|string',
        ]);

        $assignee = User::findOrFail($request->user_id);

        $dueTime = Carbon::parse($request->due_date)->format('Y-m-d H:i:s');

        $task = Task::create([
            'owner_type' => 'Lead',
            'owner_id' => $leadId,
            'title' => $request->title,
            'description' => $request->description,
            'created_time' => now(),
            'due_time' => $dueTime,
            'assignee_id' => $assignee->id,
            'assignee_name' => $assignee->name,
            'subject_type' => 'lead',
            'subject_legacy_id' => $leadId,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Task added successfully',
            'task' => $task,
        ]);
    }

    public function updateTask(Request $request, $taskId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'due_date' => 'required|string', // will parse manually
            'user_id' => 'required|exists:users,id',
            'description' => 'nullable|string',
        ]);

        $assignee = User::findOrFail($request->user_id);

        $dueTime = Carbon::parse($request->due_date)->format('Y-m-d H:i:s');

        $task = Task::where('owner_type', 'lead')
            ->where('id', $taskId)
            ->firstOrFail();

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'due_time' => $dueTime,
            'assignee_id' => $assignee->id,
            'assignee_name' => $assignee->name,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Task updated successfully',
            'task' => $task,
        ]);
    }

    public function markCompleted($taskId)
    {
        $user = auth()->user();

        $task = Task::where('owner_type', 'lead')
            ->where('id', $taskId)
            ->firstOrFail();

        $task->update([
            'completed_time' => now(),
            'completed_user_id' => $user->id,
            'completed_user_name' => $user->name,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Task marked as completed successfully!',
            'task' => $task,
        ]);
    }

    public function reopenTask($taskId)
    {
        $task = Task::findOrFail($taskId);

        $task->update([
            'completed_time' => null,
            'completed_user_id' => null,
            'completed_user_name' => null,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Task reopened successfully',
            'task' => $task,
        ]);
    }

    public function deleteTask($taskId)
    {
        $task = Task::find($taskId);

        if (! $task) {
            return response()->json([
                'status' => 'error',
                'message' => 'Task not found.',
            ], 404);
        }

        $task->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Task deleted successfully.',
        ]);
    }
}
