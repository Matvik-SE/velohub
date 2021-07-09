<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::where('parent_id', 0)
            ->with('children')
            ->get([
                'id',
                'parent_id',
                'is_active',
                'is_parent',
                'ord',
                'title',
                'title_short'
            ]);

        return response()->json($categories);
    }

    public function get($id): JsonResponse
    {
        $category = Category::with([
            'features' => fn ($query) => $query->with('children'),
            'parameters'
        ])->findOrFail($id);

        return response()->json($category);
    }

    public function post(Request $request): JsonResponse
    {
        $request->validate([
            'parent_id' => 'required|integer',
            'title' => 'required|min:2|max:255',
            'title_short' => 'required|min:2|max:255',
        ]);

        $category = Category::create($request->all());

        return response()->json($category);
    }

    public function patch(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'parent_id' => 'required|integer',
            'title' => 'required|min:2|max:255',
            'title_short' => 'required|min:2|max:255',
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->all());

        return response()->json(
            $category->only(array_keys($category->getChanges()))
        );
    }

    public function delete(int $id): JsonResponse
    {
        Category::findOrFail($id)->delete();

        return response()->json($id);
    }
}
