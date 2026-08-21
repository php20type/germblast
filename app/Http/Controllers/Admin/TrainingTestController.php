<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrainingTest;
use App\Models\TrainingCategory;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class TrainingTestController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:training.view', only: ['index']),
            new Middleware('permission:training.add', only: ['create', 'store']),
            new Middleware('permission:training.edit', only: ['edit', 'update']),
        ];
    }
    public function index()
    {
        $tests = TrainingTest::with('category')->get();
        $categories = TrainingCategory::all();
        return view('admin.training-tests.index', compact('tests', 'categories'));
    }

    public function create()
    {
        $categories = TrainingCategory::all();
        return view('admin.training-tests.create', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'category_id' => 'required|exists:training_categories,id',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'video_url' => 'nullable|url|max:255',
                'passing_percentage' => 'required|integer|min:0|max:100',
                'status' => 'required|string',
            ]);

            TrainingTest::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Training Test created successfully.'
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

    public function edit($id)
    {
        $test = TrainingTest::findOrFail($id);
        $categories = TrainingCategory::all();
        return view('admin.training-tests.edit', compact('test', 'categories'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'category_id' => 'required|exists:training_categories,id',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'video_url' => 'nullable|url|max:255',
                'passing_percentage' => 'required|integer|min:0|max:100',
                'status' => 'required|string',
            ]);

            $test = TrainingTest::findOrFail($id);
            $test->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Training Test updated successfully.'
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

}
