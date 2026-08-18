<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\EvaluationScore;

class EvaluationController extends Controller
{
    public function index()
    {
        $supervisors = User::role('supervisor')->with(['evaluationRequests', 'evaluationScores.question'])->get();
        $sit = User::role('training_supervisor')->with(['evaluationRequests', 'evaluationScores.question'])->get();
        $operationsManagers = User::role('operations_manager')->with(['evaluationRequests', 'evaluationScores.question'])->get();
        $technicians = User::role('technician')->with(['evaluationRequests', 'evaluationScores.question', 'sitAttempts'])->get();

        // Calculate aggregate scores for the View Scores panel
        $allUsers = $supervisors->concat($sit)->concat($operationsManagers)->concat($technicians);
        $aggregatedScores = [];
        
        foreach ($allUsers as $user) {
            if ($user->evaluationScores->count() > 0) {
                $groupedByEval = $user->evaluationScores->groupBy(function ($score) {
                    if ($score->evaluation_request_id) {
                        return 'req_' . $score->evaluation_request_id;
                    } elseif ($score->sit_evaluation_attempt_id) {
                        return 'sit_' . $score->sit_evaluation_attempt_id;
                    }
                    return 'unknown_' . $score->created_at->format('Y-m-d_H:i:s');
                });

                $evaluations = [];
                foreach ($groupedByEval as $evalId => $evalScores) {
                    $sections = $evalScores->groupBy(function ($score) {
                        return $score->question ? $score->question->section : 'General';
                    })->map(function ($scores) {
                        $totalScore = $scores->sum('score');
                        $totalMax = $scores->sum('max_score');
                        $percentage = $totalMax > 0 ? ($totalScore / $totalMax) * 100 : 0;
                        return [
                            'total_score' => $totalScore,
                            'total_max' => $totalMax,
                            'percentage' => round($percentage)
                        ];
                    });

                    $firstScore = $evalScores->first();
                    $evaluatorName = $firstScore->evaluatorUser ? $firstScore->evaluatorUser->name : 'Unknown';
                    $date = $firstScore->created_at ? $firstScore->created_at->format('n-j-y') : 'Unknown';

                    $evaluations[] = [
                        'evaluator' => $evaluatorName,
                        'date' => $date,
                        'created_at' => $firstScore->created_at,
                        'sections' => $sections
                    ];
                }

                usort($evaluations, function($a, $b) {
                    return $b['created_at'] <=> $a['created_at'];
                });

                $aggregatedScores[$user->id] = $evaluations;
            }
        }

        // Calculate overall average for each role
        $roleAverages = [
            'supervisor' => $this->calculateRoleAverage($supervisors),
            'operations_manager' => $this->calculateRoleAverage($operationsManagers),
            'sit' => $this->calculateRoleAverage($sit),
            'technician' => $this->calculateRoleAverage($technicians),
        ];

        return view('admin.operations.evaluations.index', compact('supervisors', 'sit', 'operationsManagers', 'technicians', 'aggregatedScores', 'roleAverages', 'allUsers'));
    }

    private function calculateRoleAverage($users)
    {
        $totalScores = 0;
        $totalMax = 0;
        foreach ($users as $user) {
            if ($user->evaluationScores->count() > 0) {
                $totalScores += $user->evaluationScores->sum('score');
                $totalMax += $user->evaluationScores->sum('max_score');
            }
        }
        if ($totalMax > 0) {
            $percentage = ($totalScores / $totalMax) * 100;
            return round($percentage);
        }
        return null;
    }

    public function create($target_id)
    {
        $targetUser = User::findOrFail($target_id);
        
        // Determine role to fetch questions
        $roleName = $targetUser->roles->first()->name ?? 'technician';
        if ($roleName === 'technician') {
            $questions = \App\Models\EvaluationQuestion::where('role', 'technician')->get()->groupBy('section');
        } else {
            $questions = \App\Models\EvaluationQuestion::where('role', $roleName)->get()->groupBy('section');
        }

        return view('admin.operations.evaluations.create', compact('targetUser', 'questions', 'roleName'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'target_user_id' => 'required|exists:users,id',
            'scores' => 'required|array',
            'remarks' => 'nullable|string',
            'development_plan' => 'nullable|string',
            'other_comments' => 'nullable|string',
        ]);

        $targetUser = User::findOrFail($request->target_user_id);
        $roleName = $targetUser->roles->first()->name ?? 'technician';

        // Save scores
        $sitAttemptId = null;
        $evalRequestId = null;

        // 1. Create or update the Evaluation Header
        if ($roleName === 'technician' || $roleName === 'training_supervisor') {
            $attempt = \App\Models\SitEvaluationAttempt::create([
                'technician_id' => $targetUser->id,
                'evaluator_id' => auth()->id(),
                'attempt_number' => \App\Models\SitEvaluationAttempt::where('technician_id', $targetUser->id)->count() + 1,
                'completed_at' => now(),
                'remarks' => $request->remarks,
                'development_plan' => $request->development_plan,
                'other_comments' => $request->other_comments,
            ]);
            $sitAttemptId = $attempt->id;
        } else {
            $evaluationRequest = \App\Models\EvaluationRequest::where('target_user_id', $targetUser->id)
                ->where('status', 'pending')
                ->first();
            
            if ($evaluationRequest) {
                $evaluationRequest->update([
                    'evaluator_user_id' => auth()->id(),
                    'status' => 'completed',
                    'completed_at' => now(),
                    'remarks' => $request->remarks,
                    'development_plan' => $request->development_plan,
                    'other_comments' => $request->other_comments,
                ]);
                $evalRequestId = $evaluationRequest->id;
            } else {
                // In case they evaluate without a pending request, create a standalone request record
                $evaluationRequest = \App\Models\EvaluationRequest::create([
                    'target_user_id' => $targetUser->id,
                    'evaluator_user_id' => auth()->id(),
                    'status' => 'completed',
                    'completed_at' => now(),
                    'remarks' => $request->remarks,
                    'development_plan' => $request->development_plan,
                    'other_comments' => $request->other_comments,
                ]);
                $evalRequestId = $evaluationRequest->id;
            }
        }

        // 2. Save Scores linked to the Header
        foreach ($request->scores as $questionId => $scoreValue) {
            $question = \App\Models\EvaluationQuestion::find($questionId);
            if ($question) {
                EvaluationScore::create([
                    'target_user_id' => $targetUser->id,
                    'evaluator_user_id' => auth()->id(),
                    'evaluation_type' => $roleName,
                    'evaluation_question_id' => $question->id,
                    'sit_evaluation_attempt_id' => $sitAttemptId,
                    'evaluation_request_id' => $evalRequestId,
                    'score' => $scoreValue,
                    'max_score' => $question->max_score ?? 3,
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Evaluation submitted successfully.',
        ], 200);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $roleName = $user->roles->first()->name ?? 'technician';
        
        if ($roleName === 'technician' || $roleName === 'training_supervisor') {
            $evaluations = \App\Models\SitEvaluationAttempt::with(['scores.question', 'scores.evaluatorUser'])
                ->where('technician_id', $id)
                ->orderBy('completed_at', 'asc')
                ->get();
        } else {
            $evaluations = \App\Models\EvaluationRequest::with(['scores.question', 'scores.evaluatorUser'])
                ->where('target_user_id', $id)
                ->where('status', 'completed')
                ->orderBy('completed_at', 'asc')
                ->get();
        }

        return view('admin.operations.evaluations.show', compact('user', 'evaluations', 'roleName'));
    }
}
