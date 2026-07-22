<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TrainingTest;
use App\Models\TrainingAttempt;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class TrainingReportController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:training.view', only: ['index']),
        ];
    }
    public function index()
    {
        // Get all active tests to display as columns
        $tests = TrainingTest::where('status', 'Active')->orderBy('name')->get();
        
        // Get all non-customer users
        $employees = User::withoutRole('customer')->orderBy('name')->get();

        // Get all attempts to process them
        $attempts = TrainingAttempt::all();

        // Build a matrix of employee_id -> test_id -> latest attempt
        $matrix = [];
        foreach ($employees as $emp) {
            $matrix[$emp->id] = [];
            foreach ($tests as $test) {
                // Find all attempts for this employee and this test
                $empTests = $attempts->where('employee_id', $emp->id)->where('training_test_id', $test->id);
                
                if ($empTests->count() > 0) {
                    // Check if they ever passed
                    $passed = $empTests->where('status', 'Passed')->sortByDesc('submitted_at')->first();
                    $latest = $empTests->sortByDesc('submitted_at')->first();
                    
                    if ($passed) {
                        $matrix[$emp->id][$test->id] = [
                            'status' => 'Passed',
                            'score' => $passed->score,
                            'date' => $passed->submitted_at,
                            'attempts' => $empTests->sortBy('attempt_number')
                        ];
                    } else {
                        $matrix[$emp->id][$test->id] = [
                            'status' => 'Failed',
                            'score' => $latest->score,
                            'date' => $latest->submitted_at,
                            'attempts' => $empTests->sortBy('attempt_number')
                        ];
                    }
                } else {
                    $matrix[$emp->id][$test->id] = [
                        'status' => 'Not Started',
                        'score' => null,
                        'date' => null,
                        'attempts' => collect([])
                    ];
                }
            }
        }

        return view('admin.training-report.index', compact('tests', 'employees', 'matrix'));
    }
}
