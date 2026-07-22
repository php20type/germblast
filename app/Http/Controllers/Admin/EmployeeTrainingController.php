<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrainingCategory;
use App\Models\TrainingTest;

class EmployeeTrainingController extends Controller
{
    public function index()
    {
        // Get categories that have active tests
        $categories = TrainingCategory::with([
            'tests' => function ($query) {
                $query->where('status', 'Active')->orderBy('name');
            }
        ])->orderBy('name')->get();

        $userAttempts = \App\Models\TrainingAttempt::where('employee_id', auth()->id())->get();

        return view('admin.employee-training.index', compact('categories', 'userAttempts'));
    }

    public function show($test_id)
    {
        $test = TrainingTest::with([
            'category',
            'questions' => function ($query) {
                $query->orderBy('sort_order', 'asc');
            }
        ])->findOrFail($test_id);

        $attempts = \App\Models\TrainingAttempt::where('employee_id', auth()->id())
            ->where('training_test_id', $test_id)
            ->get();



        $attemptsUsed = $attempts->count();

        return view('admin.employee-training.show', compact('test', 'attemptsUsed'));
    }

    public function submit(Request $request, $test_id)
    {
        try {
            $test = TrainingTest::with('questions')->findOrFail($test_id);

            $attempts = \App\Models\TrainingAttempt::where('employee_id', auth()->id())
                ->where('training_test_id', $test_id)
                ->get();

            // Calculate score
            $totalMarks = 0;
            $earnedMarks = 0;
            $answers = $request->input('answers', []);

            foreach ($test->questions as $question) {
                $totalMarks += $question->marks;
                $userAnswer = $answers[$question->id] ?? null;

                if (is_array($userAnswer)) {
                    if (count($userAnswer) == 1 && $userAnswer[0] == $question->correct_answer) {
                        $earnedMarks += $question->marks;
                    }
                } else {
                    if ($userAnswer == $question->correct_answer) {
                        $earnedMarks += $question->marks;
                    }
                }
            }

            $percentage = $totalMarks > 0 ? ($earnedMarks / $totalMarks) * 100 : 0;
            $status = $percentage >= $test->passing_percentage ? 'Passed' : 'Failed';

            \App\Models\TrainingAttempt::create([
                'employee_id' => auth()->id(),
                'training_test_id' => $test_id,
                'attempt_number' => $attempts->count() + 1,
                'score' => $percentage,
                'status' => $status,
                'submitted_at' => now(),
            ]);

            $message = $status == 'Passed' ? 'Congratulations! You passed the test with a score of ' . round($percentage, 2) . '%.' : 'You failed the test with a score of ' . round($percentage, 2) . '%.';

            return response()->json([
                'success' => true,
                'message' => $message,
                'redirect_url' => route('admin.employee-training.index')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    public function certificate($attempt_id)
    {
        $attempt = \App\Models\TrainingAttempt::where('id', $attempt_id)
            ->where('status', 'Passed')
            ->firstOrFail();

        $test = TrainingTest::findOrFail($attempt->training_test_id);



        $employee = \App\Models\User::findOrFail($attempt->employee_id);

        return view('admin.employee-training.certificate', compact('attempt', 'test', 'employee'));
    }
}
