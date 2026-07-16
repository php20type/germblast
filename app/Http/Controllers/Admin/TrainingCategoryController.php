<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrainingCategory;

class TrainingCategoryController extends Controller
{
    public function index()
    {
        $categories = TrainingCategory::orderBy('sort_order')->get();
        return view('admin.training-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.training-categories.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'sort_order' => 'nullable|integer',
                'status' => 'nullable|string',
            ]);

            TrainingCategory::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Training Category created successfully.'
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
        $category = TrainingCategory::findOrFail($id);
        return view('admin.training-categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'sort_order' => 'nullable|integer',
                'status' => 'nullable|string',
            ]);

            $category = TrainingCategory::findOrFail($id);
            $category->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Training Category updated successfully.'
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
