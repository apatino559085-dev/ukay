@extends('layouts.admin')

@section('title', 'Edit Ukay Item - THRIFT FINDS Admin')

@section('content')
<div class="admin-header">
    <div>
        <h1>Edit Ukay Item</h1>
        <p style="color: #64748b; margin-top: 4px;">Update details for "{{ $product->name }}".</p>
    </div>
    <div>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline">← Back to Ukay Items</a>
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

        <div class="form-row mb-3" style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
            <div class="form-group">
                <label class="form-label">Item Name *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Brand *</label>
                <input type="text" name="brand" class="form-control" value="{{ old('brand', $product->brand) }}" required>
            </div>
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
                <label class="form-label">Price (₱ PHP) *</label>
                <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
            </div>
        </div>

        <div class="form-row mb-3" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label class="form-label">Size Label *</label>
                <input type="text" name="size_text" class="form-control" value="{{ old('size_text', $product->size_text) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Condition *</label>
                <select name="condition" class="form-control" required>
                    <option value="Good" {{ old('condition', $product->condition) == 'Good' ? 'selected' : '' }}>Good</option>
                    <option value="Excellent" {{ old('condition', $product->condition) == 'Excellent' ? 'selected' : '' }}>Excellent</option>
                    <option value="New / Like New" {{ old('condition', $product->condition) == 'New / Like New' ? 'selected' : '' }}>New / Like New</option>
                    <option value="Fair" {{ old('condition', $product->condition) == 'Fair' ? 'selected' : '' }}>Fair</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Color</label>
                <input type="text" name="color" class="form-control" value="{{ old('color', $product->color) }}">
            </div>
        </div>

        <div class="form-row mb-3" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label class="form-label">Material Description</label>
                <input type="text" name="material" class="form-control" value="{{ old('material', $product->material) }}">
            </div>

            <div class="form-group">
                <label class="form-label">Stock Quantity * (0 = SOLD OUT)</label>
                <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" min="0" required>
            </div>
        </div>

        <div class="form-group mb-3">
            <label class="form-label">Exact Measurements</label>
            <input type="text" name="measurements" class="form-control" value="{{ old('measurements', $product->measurements) }}">
        </div>

        <div class="form-group mb-3">
            <label class="form-label">Item Description</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="form-group mb-4">
            <label class="form-label">Primary Cover Image</label>
            @if($product->image)
                <div class="mb-2">
                    <img src="{{ $product->image }}" alt="Current Cover Image" style="width: 100px; height: 120px; object-fit: cover; border-radius: 4px; border: 1px solid #e2e8f0;">
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
            <label class="form-label">Add More Angle Photos (Select Multiple)</label>
            <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
        </div>

        <div class="form-group mb-4">
            <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer;">
                <input type="checkbox" name="featured" value="1" {{ old('featured', $product->featured) ? 'checked' : '' }}>
                <span>Feature this item on Homepage</span>
            </label>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Update Ukay Item</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
