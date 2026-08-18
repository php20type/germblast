<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OfficeDuty;
use App\Models\OfficeDutyCompletion;
use Illuminate\Http\Request;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class OfficeDutyController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:office_duties.view', only: ['index']),
            new Middleware('permission:office_duties.add', only: ['store']),
            new Middleware('permission:office_duties.edit', only: ['update', 'complete', 'reopen']),
        ];
    }
    public function index()
    {
        $duties = OfficeDuty::with('lastPerformedBy')->get();

        return view('admin.office-duties.index', compact('duties'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'frequency' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        try {
            $duty = OfficeDuty::create($request->all());

            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Task created successfully.'
                ]);
            }

            return redirect()->back()->with('success', 'Task created successfully.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Something went wrong!'], 500);
            }
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'frequency' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        try {
            $duty = OfficeDuty::findOrFail($id);
            $duty->update($request->all());

            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Task updated successfully.'
                ]);
            }

            return redirect()->back()->with('success', 'Task updated successfully.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Something went wrong!'], 500);
            }
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function complete(Request $request, $id)
    {
        $request->validate([
            'description' => 'required|string|max:255',
        ]);

        try {
            $duty = OfficeDuty::findOrFail($id);
            
            $now = now();
            $formattedDate = $now->format('m/d h:i a');

            OfficeDutyCompletion::create([
                'office_duty_id' => $duty->id,
                'user_id' => auth()->id(),
                'notes' => $request->description,
                'completed_at' => $now,
            ]);

            $duty->update([
                'last_performed_by' => auth()->id(),
                'last_performed_on' => $formattedDate,
                'notes' => $request->description,
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Task completed successfully.'
                ]);
            }

            return redirect()->back()->with('success', 'Task completed successfully.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Something went wrong!'], 500);
            }
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }
    public function reopen(Request $request, $id)
    {
        try {
            $duty = OfficeDuty::findOrFail($id);
            
            OfficeDutyCompletion::where('office_duty_id', $duty->id)->delete();

            // Clear the completion status on the duty itself
            $duty->update([
                'last_performed_by' => null,
                'last_performed_on' => null,
                'notes' => null,
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Task reopened successfully.'
                ]);
            }

            return redirect()->back()->with('success', 'Task reopened successfully.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Something went wrong!'], 500);
            }
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }
}
