<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoreValuePraise;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CoreValuePraiseController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:team_praise.view', only: ['index']),
            new Middleware('permission:team_praise.add', only: ['create', 'store']),
        ];
    }

    /**
     * Display a listing of the praise submissions.
     */
    public function index()
    {
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
            'recipient_id' => 'required|exists:users,id',
            'reason'       => 'required|string|max:5000',
            'core_value'   => 'required|string|in:Excellence,Extraordinary,Growth,Integrity,Ownership',
        ]);

        $recipient = User::findOrFail($request->recipient_id);

        CoreValuePraise::create([
            'sender_id'      => auth()->id(),
            'recipient_id'   => $recipient->id,
            'recipient_name' => $recipient->name,
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
