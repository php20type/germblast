<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        // $request->validate([
        //     'company_id' => 'nullable|exists:companies,id',
        //     'user_id' => 'required|exists:users,id',
        //     'title' => 'nullable|string|max:255',
        //     'description' => 'nullable|string',
        //     'due_date' => 'nullable|date',
        // ]);

        $task = Task::create([
            'company_id' => $request->company_id,
            'user_id' => $request->user_id,
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
        ]);

        return response()->json(['status' => 'success', 'task' => $task]);
    }


    public function ajax_store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'due_date' => 'nullable',
            'assignee_id' => 'nullable|exists:users,id',
        ]);

        $data = [
            'title' => $validated['name'],
            'due_date' => $validated['due_date'] ?? null,
            'user_id' => $validated['assignee_id'] ?? null,
        ];


        if (!empty($request->company_id)) {
            $data['company_id'] = $request->company_id;
        }


        $task = Task::create($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Task added successfully.',
                'task' => $task
            ]);
        }

        return redirect()->back()->with('success', 'Task added successfully.');
    }

}
