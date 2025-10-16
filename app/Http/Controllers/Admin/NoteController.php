<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Models\NoteComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function delete_note(Request $request, $id)
    {
        DB::transaction(function () use ($id) {
            $note = Note::findOrFail($id);

            // Delete pivot table entries (related entities)
            $note->companies()->detach();
            $note->peoples()->detach();
            $note->users()->detach();

            // Delete comments
            $note->comments()->delete();

            // Finally delete the note itself
            $note->delete();
        });

        return response()->json([
            'message' => 'Note deleted successfully.',
        ]);
    }

    public function add_comment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:2000',
        ]);

        $note = Note::find($id);
        if (! $note) {
            return response()->json(['message' => 'Note not found.'], 404);
        }

        NoteComment::create([
            'note_id' => $id,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);

        return response()->json(['message' => 'Comment added successfully.']);
    }

    public function delete_comment(Request $request, $id)
    {
        $comment = NoteComment::find($id);

        if (! $comment) {
            return response()->json(['message' => 'Comment not found.'], 404);
        }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully.']);
    }
}
