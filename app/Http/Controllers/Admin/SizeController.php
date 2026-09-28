<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * Display all sizes.
     */
    public function index()
    {
        $sizes = Size::all();
        return view('admin.sizes.index', compact('sizes'));
    }

    /**
     * Show the form to create a new size.
     */
    public function create()
    {
        return view('admin.sizes.create');
    }

    /**
     * Store a new size.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:10|unique:sizes,name',
            'width'  => 'nullable|string|max:20',
            'length' => 'nullable|string|max:20',
        ]);

        Size::create($request->only(['name', 'width', 'length']));

        return redirect()->route('admin.sizes.index')
            ->with('success', 'Size created successfully!');
    }

    /**
     * Show the form to edit a size.
     */
    public function edit(Size $size)
    {
        return view('admin.sizes.edit', compact('size'));
    }

    /**
     * Update a size.
     */
    public function update(Request $request, Size $size)
    {
        $request->validate([
            'name'   => 'required|string|max:10|unique:sizes,name,' . $size->id,
            'width'  => 'nullable|string|max:20',
            'length' => 'nullable|string|max:20',
        ]);

        $size->update($request->only(['name', 'width', 'length']));

        return redirect()->route('admin.sizes.index')
            ->with('success', 'Size updated successfully!');
    }

    /**
     * Delete a size.
     */
    public function destroy(Size $size)
    {
        $size->delete();

        return redirect()->route('admin.sizes.index')
            ->with('success', 'Size deleted successfully!');
    }
}
