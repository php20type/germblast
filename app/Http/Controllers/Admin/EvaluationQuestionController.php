<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EvaluationQuestion;

class EvaluationQuestionController extends Controller
{
    public function index()
    {
        $questions = EvaluationQuestion::orderBy('role')->orderBy('section')->get();
        return view('admin.operations.evaluation_questions.index', compact('questions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'role' => 'required|string|max:255',
            'section' => 'required|string|max:255',
            'question_text' => 'required|string',
            'max_score' => 'required|integer|min:1',
        ]);

        EvaluationQuestion::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Question created successfully.'
        ]);
    }

    public function update(Request $request, $id)
    {
        $question = EvaluationQuestion::findOrFail($id);

        $validated = $request->validate([
            'role' => 'required|string|max:255',
            'section' => 'required|string|max:255',
            'question_text' => 'required|string',
            'max_score' => 'required|integer|min:1',
        ]);

        $question->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Question updated successfully.'
        ]);
    }

    public function destroy($id)
    {
        $question = EvaluationQuestion::findOrFail($id);
        $question->delete();

        return response()->json([
            'status' => true,
            'message' => 'Question deleted successfully.'
        ]);
    }
}
