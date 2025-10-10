<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function add_note(Request $request)
    {
        $user_id = auth()->id();

        // Validate request
        $validated = $request->validate([
            'note' => 'required|string',
            'mentioned_company_ids' => 'nullable|string',
            'mentioned_people_ids' => 'nullable|string',
            'mentioned_user_ids' => 'nullable|string',
            'owner_type' => 'required|string',
            'owner_id' => 'required|integer',
        ]);

        // Create note
        $note = Note::create([
            'user_id' => $user_id,
            'note' => $validated['note'],
            'owner_type' => $validated['owner_type'],
            'owner_id' => $validated['owner_id'],
        ]);

        // Helper: convert comma-separated string to array safely
        $convertToArray = fn ($value) => array_filter(is_array($value) ? $value : explode(',', $value));

        // Attach mentioned companies
        if ($request->filled('mentioned_company_ids')) {
            $note->companies()->sync($convertToArray($request->mentioned_company_ids));
        }

        // Attach mentioned peoples
        if ($request->filled('mentioned_people_ids')) {
            $note->peoples()->sync($convertToArray($request->mentioned_people_ids));
        }

        // Attach mentioned users
        if ($request->filled('mentioned_user_ids')) {
            $note->users()->sync($convertToArray($request->mentioned_user_ids));
        }

        // Return JSON for AJAX
        return response()->json([
            'status' => 'success',
            'message' => 'Note added successfully!',
            'data' => $note->load('companies', 'peoples', 'users'),
        ]);
    }
}
