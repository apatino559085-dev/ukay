@extends('layouts.admin')

@section('title', 'Edit Product - ThreadLine Admin')

@section('content')
<div class="admin-header">
    <div>
        <h1>Edit Product</h1>
        <p style="color: #64748b; margin-top: 4px;">Update information for "{{ $product->name }}".</p>
    </div>
    <div>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline">← Back to Products</a>
    </div>
</div>

<div class="table-card" style="padding: 30px; max-width: 800px;">
    @if($errors->any())
        <div class="validation-errors">
            <ul>
                @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label class="form-label">Product Name *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
        </div>

        <div class="form-row mb-3" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label class="form-label">Category *</label>
                <select name="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Price ($) *</label>
                <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
            </div>
        </div>

        <div class="form-row mb-3" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label class="form-label">Material Description</label>
                <input type="text" name="material" class="form-control" value="{{ old('material', $product->material) }}">
            </div>

            <div class="form-group">
                <label class="form-label">Total Stock Quantity *</label>
                <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" min="0" required>
            </div>
        </div>


        <div class="form-group mb-3">
            <label class="form-label">Available Sizes</label>
            <div class="d-flex gap-2" style="flex-wrap: wrap;">
                @php
                    $selectedSizes = old('sizes', $product->sizes->pluck('id')->toArray());
                @endphp
                @foreach($sizes as $size)
                    <label style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; border: 1px solid #e2e8f0; border-radius: 4px; cursor: pointer;">
                        <input type="checkbox" name="sizes[]" value="{{ $size->id }}" {{ in_array($size->id, $selectedSizes) ? 'checked' : '' }}>
                        <strong>{{ $size->name }}</strong>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="form-group mb-4">
            <label class="form-label">Primary Cover Image</label>
            @if($product->image)
                <div class="mb-2">
                    <img src="{{ $product->image }}" alt="Current Primary Image" style="width: 100px; height: 120px; object-fit: cover; border-radius: 4px; border: 1px solid #e2e8f0;">
                </div>
            @endif
            <input type="file" name="image" class="form-control" accept="image/*">
            <small style="color: #64748b; display: block; margin-top: 4px;">Leave blank to keep current cover image.</small>
        </div>

        {{-- Existing Gallery Images --}}
        @if($product->images->count() > 0)
            <div class="form-group mb-4">
                <label class="form-label">Current Gallery Images ({{ $product->images->count() }})</label>
                <div class="d-flex gap-2" style="flex-wrap: wrap;">
                    @foreach($product->images as $galleryImage)
                        <div style="position: relative; width: 100px; text-align: center; border: 1px solid #e2e8f0; border-radius: 4px; padding: 6px; background: #ffffff;">
                            <img src="{{ $galleryImage->image }}" alt="Gallery Image" style="width: 100%; height: 100px; object-fit: cover; border-radius: 4px;">
                            <form action="{{ route('admin.products.deleteImage', $galleryImage) }}" method="POST" style="margin-top: 6px;" onsubmit="return confirm('Delete this gallery image?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" style="width: 100%; padding: 2px 6px; font-size: 11px;">Remove</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="form-group mb-4">
            <label class="form-label">Add More Gallery / Design Angle Images (Select Multiple Files)</label>
            <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
            <small style="color: #64748b; display: block; margin-top: 4px;">Select multiple files to add more designs/angles for customer swipe gallery!</small>
        </div>

        <div class="form-group mb-4">
            <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer;">
                <input type="checkbox" name="featured" value="1" {{ old('featured', $product->featured) ? 'checked' : '' }}>
                <span>Feature this product on Homepage</span>
            </label>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Update Product</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
