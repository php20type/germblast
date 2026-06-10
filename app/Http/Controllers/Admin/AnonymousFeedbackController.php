<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnonymousFeedback;
use Illuminate\Http\Request;

class AnonymousFeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = AnonymousFeedback::latest()->get();
        return view('admin.hr.feedback.index', compact('feedbacks'));
    }

    public function create()
    {
        return view('admin.hr.feedback.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:5000',
        ]);

        AnonymousFeedback::create([
            'description' => $request->description,
        ]);

        if ($request->ajax()) {
            return response()->json(['message' => 'Feedback submitted successfully.']);
        }

        return redirect()->route('admin.hr.feedback.create')
            ->with('success', 'Feedback submitted successfully.');
    }

    public function destroy($id)
    {
        AnonymousFeedback::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Feedback deleted.');
    }
}
