<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::byUserId()
            ->withCount('projects')
            ->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $userId = Auth::id();
        // Add user_id to the request data
        $request->merge(['user_id' => $userId]);

        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->where(fn($q) => $q->where('user_id', $userId)),
            ],
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.categories.create')
                ->withErrors($validator)
                ->withInput();
        }

        Category::create($request->only(['name', 'user_id']));

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $userId = $category->user_id ?? Auth::id();

        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->where(fn($q) => $q->where('user_id', $userId))->ignore($category->id),
            ],
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.categories.edit', $category->id)
                ->withErrors($validator)
                ->withInput();
        }

        $category->update($request->all());

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        // Check if category has projects
        if ($category->projects()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Cannot delete category with associated projects.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
