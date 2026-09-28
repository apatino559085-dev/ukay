<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display all categories.
     */
    public function index()
    {
        $categories = Category::withCount('products')->latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form to create a new category.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a new category.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        Category::create($request->only(['name', 'description']));

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully!');
    }

    /**
     * Show the form to edit a category.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update a category.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update($request->only(['name', 'description']));

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully!');
    }

    /**
     * Delete a category.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully!');
    }
}
