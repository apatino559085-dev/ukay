<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\Size;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display all products.
     */
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form to create a new ukay product.
     */
    public function create()
    {
        $categories = Category::all();
        $sizes = Size::all();
        return view('admin.products.create', compact('categories', 'sizes'));
    }

    /**
     * Store a new ukay product.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'brand'        => 'required|string|max:255',
            'price'        => 'required|numeric|min:0',
            'category_id'  => 'required|exists:categories,id',
            'size_text'    => 'required|string|max:255',
            'condition'    => 'required|string|max:255',
            'color'        => 'nullable|string|max:255',
            'material'     => 'nullable|string|max:255',
            'measurements' => 'nullable|string|max:255',
            'description'  => 'nullable|string',
            'stock'        => 'required|integer|min:0',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'images.*'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'featured'     => 'nullable|boolean',
        ]);

        $data = $request->only([
            'name', 'brand', 'size_text', 'color', 'condition', 'measurements',
            'description', 'price', 'category_id', 'material', 'stock'
        ]);
        $data['featured'] = $request->has('featured');
        $data['status']   = ($request->stock <= 0) ? 'sold' : 'available';

        // Handle single primary cover image
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . rand(100, 999) . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images/products'), $imageName);
            $data['image'] = 'images/products/' . $imageName;
        }

        // Create product
        $product = Product::create($data);

        // Handle multiple gallery images
        if ($request->hasFile('images')) {
            $sortOrder = 1;
            foreach ($request->file('images') as $file) {
                $imageName = time() . '_' . rand(100, 999) . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/products'), $imageName);
                $path = 'images/products/' . $imageName;

                if (!$product->image && $sortOrder === 1) {
                    $product->update(['image' => $path]);
                }

                $product->images()->create([
                    'image' => $path,
                    'sort_order' => $sortOrder++,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Ukay item created successfully!');
    }

    /**
     * Show the form to edit a product.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $sizes = Size::all();
        $product->load(['sizes', 'images']);
        return view('admin.products.edit', compact('product', 'categories', 'sizes'));
    }

    /**
     * Update a product.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'brand'        => 'required|string|max:255',
            'price'        => 'required|numeric|min:0',
            'category_id'  => 'required|exists:categories,id',
            'size_text'    => 'required|string|max:255',
            'condition'    => 'required|string|max:255',
            'color'        => 'nullable|string|max:255',
            'material'     => 'nullable|string|max:255',
            'measurements' => 'nullable|string|max:255',
            'description'  => 'nullable|string',
            'stock'        => 'required|integer|min:0',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'images.*'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'featured'     => 'nullable|boolean',
        ]);

        $data = $request->only([
            'name', 'brand', 'size_text', 'color', 'condition', 'measurements',
            'description', 'price', 'category_id', 'material', 'stock'
        ]);
        $data['featured'] = $request->has('featured');
        $data['status']   = ($request->stock <= 0) ? 'sold' : 'available';

        // Handle main primary cover image update
        if ($request->hasFile('image')) {
            $rawPath = $product->getRawOriginal('image');
            if ($rawPath && file_exists(public_path($rawPath))) {
                @unlink(public_path($rawPath));
            }

            $imageName = time() . '_' . rand(100, 999) . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images/products'), $imageName);
            $data['image'] = 'images/products/' . $imageName;
        }

        $product->update($data);

        // Handle additional gallery images upload
        if ($request->hasFile('images')) {
            $currentMaxSort = $product->images()->max('sort_order') ?? 0;
            foreach ($request->file('images') as $file) {
                $currentMaxSort++;
                $imageName = time() . '_' . rand(100, 999) . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/products'), $imageName);
                $path = 'images/products/' . $imageName;

                $product->images()->create([
                    'image' => $path,
                    'sort_order' => $currentMaxSort,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Ukay item updated successfully!');
    }

    /**
     * Delete an individual gallery image.
     */
    public function deleteImage(ProductImage $image)
    {
        $rawPath = $image->getRawOriginal('image');
        if ($rawPath && file_exists(public_path($rawPath))) {
            @unlink(public_path($rawPath));
        }

        $image->delete();

        return redirect()->back()->with('success', 'Gallery image deleted successfully!');
    }

    /**
     * Delete a product.
     */
    public function destroy(Product $product)
    {
        $rawPath = $product->getRawOriginal('image');
        if ($rawPath && file_exists(public_path($rawPath))) {
            @unlink(public_path($rawPath));
        }

        foreach ($product->images as $galleryImg) {
            $galleryPath = $galleryImg->getRawOriginal('image');
            if ($galleryPath && file_exists(public_path($galleryPath))) {
                @unlink(public_path($galleryPath));
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Ukay item deleted successfully!');
    }
}
