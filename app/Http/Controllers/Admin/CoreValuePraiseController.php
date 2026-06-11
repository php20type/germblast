<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoreValuePraise;
use App\Models\User;
use Illuminate\Http\Request;

class CoreValuePraiseController extends Controller
{
    /**
     * Display a listing of the praise submissions.
     */
    public function index()
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        $praises = CoreValuePraise::with(['sender', 'recipient'])->latest()->get();
        return view('admin.hr.praise.index', compact('praises'));
    }

    /**
     * Show the form for creating a new praise submission.
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('admin.hr.praise.create', compact('users'));
    }

    /**
     * Store a newly created praise submission in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'recipient_id'   => 'nullable|exists:users,id',
            'reason'         => 'required|string|max:5000',
            'core_value'     => 'required|string|in:Excellence,Extraordinary,Growth,Integrity,Ownership',
        ]);

        CoreValuePraise::create([
            'sender_id'      => auth()->id(),
            'recipient_id'   => $request->recipient_id,
            'recipient_name' => $request->recipient_name,
            'reason'         => $request->reason,
            'core_value'     => $request->core_value,
        ]);

        if ($request->ajax()) {
            return response()->json(['message' => 'Praise submitted successfully.']);
        }

        return redirect()->route('admin.hr.praise.create')
            ->with('success', 'Praise submitted successfully.');
    }
}
