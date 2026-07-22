<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnonymousFeedback;
use Illuminate\Http\Request;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AnonymousFeedbackController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:anonymous_feedback.view', only: ['index']),
            new Middleware('permission:anonymous_feedback.add', only: ['create', 'store']),
        ];
    }

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

}
