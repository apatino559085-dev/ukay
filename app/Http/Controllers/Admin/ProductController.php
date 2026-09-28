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
     * Show the form to create a new product.
     */
    public function create()
    {
        $categories = Category::all();
        $sizes = Size::all();
        return view('admin.products.create', compact('categories', 'sizes'));
    }

    /**
     * Store a new product.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'material'    => 'nullable|string|max:255',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'images.*'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'featured'    => 'nullable|boolean',
            'sizes'       => 'nullable|array',
            'sizes.*'     => 'exists:sizes,id',
        ]);

        $data = $request->only(['name', 'price', 'category_id', 'material', 'stock']);
        $data['featured'] = $request->has('featured');

        // Handle single primary image
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

                // Set primary image if not set yet
                if (!$product->image && $sortOrder === 1) {
                    $product->update(['image' => $path]);
                }

                $product->images()->create([
                    'image' => $path,
                    'sort_order' => $sortOrder++,
                ]);
            }
        }

        // Attach sizes
        if ($request->has('sizes')) {
            foreach ($request->sizes as $sizeId) {
                $product->sizes()->attach($sizeId, ['stock' => $request->stock]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully!');
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
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'material'    => 'nullable|string|max:255',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'images.*'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'featured'    => 'nullable|boolean',
            'sizes'       => 'nullable|array',
            'sizes.*'     => 'exists:sizes,id',
        ]);

        $data = $request->only(['name', 'price', 'category_id', 'material', 'stock']);
        $data['featured'] = $request->has('featured');

        // Handle main primary image update
        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path($product->image))) {
                @unlink(public_path($product->image));
            }

            $imageName = time() . '_' . rand(100, 999) . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images/products'), $imageName);
            $data['image'] = 'images/products/' . $imageName;
        }

        $product->update($data);

        // Handle additional multiple gallery images upload
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

        // Sync sizes
        if ($request->has('sizes')) {
            $syncData = [];
            foreach ($request->sizes as $sizeId) {
                $syncData[$sizeId] = ['stock' => $request->stock];
            }
            $product->sizes()->sync($syncData);
        } else {
            $product->sizes()->detach();
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
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
        if ($product->image && file_exists(public_path($product->image))) {
            @unlink(public_path($product->image));
        }

        foreach ($product->images as $galleryImg) {
            $rawPath = $galleryImg->getRawOriginal('image');
            if ($rawPath && file_exists(public_path($rawPath))) {
                @unlink(public_path($rawPath));
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }
}
