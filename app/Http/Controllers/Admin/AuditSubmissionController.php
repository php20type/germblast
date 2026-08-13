<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\AuditSubmission;
use Illuminate\Support\Facades\Auth;

class AuditSubmissionController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'service_order_slot_id' => 'required|exists:service_order_slots,id',
                'audit_question_id' => 'required|exists:audit_questions,id',
                'employee_id' => 'nullable|exists:users,id',
                'score' => 'nullable|integer|min:1|max:5',
                'notes' => 'nullable|string',
                'photo' => 'nullable|image|max:5120',
            ]);

            $data = $request->except('photo');
            $data['created_by'] = Auth::id();

            if ($request->hasFile('photo')) {
                $data['photo_path'] = $request->file('photo')->store('audit_photos', 'public');
            }

            AuditSubmission::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Record added successfully.'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $submission = AuditSubmission::findOrFail($id);

            $request->validate([
                'employee_id' => 'nullable|exists:users,id',
                'score' => 'nullable|integer|min:1|max:5',
                'notes' => 'nullable|string',
                'photo' => 'nullable|image|max:5120',
            ]);

            $data = $request->except('photo');

            if ($request->hasFile('photo')) {
                $data['photo_path'] = $request->file('photo')->store('audit_photos', 'public');
            }

            $submission->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Record updated successfully.'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $submission = AuditSubmission::findOrFail($id);
            $submission->delete();

            return response()->json([
                'success' => true,
                'message' => 'Record deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }
}
