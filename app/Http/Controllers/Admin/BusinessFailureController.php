<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessFailure;
use App\Models\BusinessFailureDocumentation;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class BusinessFailureController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:business_failures.view', only: ['index']),
            new Middleware('permission:business_failures.add', only: ['store', 'storeDocumentation', 'update', 'updateDocumentation']),
        ];
    }
    /**
     * Display a listing of the business failures.
     */
    public function index()
    {
        $failures = BusinessFailure::with(['creator', 'documentations.user'])
            ->orderBy('record_opened_date', 'desc')
            ->get();

        return view('admin.failures.index', compact('failures'));
    }

    /**
     * Store a newly created business failure.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        try {
            $failure = BusinessFailure::create([
                'title' => $request->title,
                'record_opened_date' => now()->toDateString(),
                'description' => $request->description,
                'created_by' => auth()->id(),
            ]);

            // Add an initial documentation log
            /* BusinessFailureDocumentation::create([
                'business_failure_id' => $failure->id,
                'user_id' => auth()->id(),
                'notes' => 'Business Failure record opened.',
            ]); */

            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Feedback saved successfully.',
                    'redirect' => route('admin.failures.index')
                ]);
            }

            return redirect()->route('admin.failures.index')
                ->with('success', 'Feedback saved successfully.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Something went wrong!'], 500);
            }
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Store a new documentation entry for a business failure.
     */
    public function storeDocumentation(Request $request, $id)
    {
        $request->validate([
            'notes' => 'required|string',
        ]);

        try {
            $failure = BusinessFailure::findOrFail($id);

            BusinessFailureDocumentation::create([
                'business_failure_id' => $failure->id,
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

    /**
     * Update an existing business failure.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        try {
            $failure = BusinessFailure::findOrFail($id);
            $failure->update([
                'title' => $request->title,
                'description' => $request->description,
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Feedback updated successfully.'
                ]);
            }

            return redirect()->back()->with('success', 'Feedback updated successfully.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Something went wrong!'], 500);
            }
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Update an existing documentation entry.
     */
    public function updateDocumentation(Request $request, $id)
    {
        $request->validate([
            'notes' => 'required|string',
        ]);

        try {
            $documentation = BusinessFailureDocumentation::findOrFail($id);
            $documentation->update([
                'notes' => $request->notes,
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Documentation entry updated successfully.'
                ]);
            }

            return redirect()->back()->with('success', 'Documentation entry updated successfully.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Something went wrong!'], 500);
            }
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }
}
