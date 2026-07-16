<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrainingQuestion;
use App\Models\TrainingTest;

class TrainingQuestionController extends Controller
{
    public function index()
    {
        // Load all tests with their question counts
        $tests = TrainingTest::withCount('questions')->orderBy('name')->get();
        return view('admin.training-questions.index', compact('tests'));
    }

    public function show($test_id)
    {
        $test = TrainingTest::findOrFail($test_id);
        $questions = TrainingQuestion::where('test_id', $test_id)->orderBy('sort_order')->get();
        
        return view('admin.training-questions.show', compact('test', 'questions'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'test_id' => 'required|exists:training_tests,id',
                'question' => 'required|string',
                'question_type' => 'required|string',
                'options' => 'nullable|array',
                'correct_answer' => 'required|string',
                'marks' => 'required|numeric|min:1',
                'sort_order' => 'required|numeric',
                'status' => 'required|string',
            ]);

            $data = $request->all();
            if(isset($data['options']) && is_array($data['options'])) {
                $data['options'] = array_values(array_filter($data['options'], function($val) {
                    return !is_null($val) && $val !== '';
                }));
            }

            if (in_array($request->question_type, ['Single Choice', 'True/False', 'Multiple Choice']) && (!isset($data['options']) || count($data['options']) < 2)) {
                return response()->json(['success' => false, 'message' => 'At least two options are required.'], 400);
            }

            TrainingQuestion::create($data);

            return response()->json(['success' => true, 'message' => 'Question created successfully.']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->validator->errors()->first()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Something went wrong: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'test_id' => 'required|exists:training_tests,id',
                'question' => 'required|string',
                'question_type' => 'required|string',
                'options' => 'nullable|array',
                'correct_answer' => 'required|string',
                'marks' => 'required|numeric|min:1',
                'sort_order' => 'required|numeric',
                'status' => 'required|string',
            ]);

            $question = TrainingQuestion::findOrFail($id);
            $data = $request->all();
            
            if(isset($data['options']) && is_array($data['options'])) {
                $data['options'] = array_values(array_filter($data['options'], function($val) {
                    return !is_null($val) && $val !== '';
                }));
            }

            if (in_array($request->question_type, ['Single Choice', 'True/False', 'Multiple Choice']) && (!isset($data['options']) || count($data['options']) < 2)) {
                return response()->json(['success' => false, 'message' => 'At least two options are required.'], 400);
            }

            $question->update($data);

            return response()->json(['success' => true, 'message' => 'Question updated successfully.']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->validator->errors()->first()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Something went wrong: ' . $e->getMessage()], 500);
        }
    }

}
