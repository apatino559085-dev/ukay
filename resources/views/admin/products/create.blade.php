@extends('layouts.admin')

@section('title', 'Add New Product - ThreadLine Admin')

@section('content')
<div class="admin-header">
    <div>
        <h1>Add New Product</h1>
        <p style="color: #64748b; margin-top: 4px;">Create a new item in your store's catalog.</p>
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

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-3">
            <label class="form-label">Product Name *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="e.g. Oversized Heavyweight Tee" required>
        </div>

        <div class="form-row mb-3" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label class="form-label">Category *</label>
                <select name="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Price ($) *</label>
                <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}" placeholder="49.99" required>
            </div>
        </div>

        <div class="form-row mb-3" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label class="form-label">Material Description</label>
                <input type="text" name="material" class="form-control" value="{{ old('material') }}" placeholder="e.g. 100% Organic Cotton, 240 GSM">
            </div>

            <div class="form-group">
                <label class="form-label">Total Stock Quantity *</label>
                <input type="number" name="stock" class="form-control" value="{{ old('stock', 50) }}" min="0" required>
            </div>
        </div>

        <div class="form-group mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" placeholder="Detailed product specifications, fit guide, and details...">{{ old('description') }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label class="form-label">Available Sizes</label>
            <div class="d-flex gap-2" style="flex-wrap: wrap;">
                @foreach($sizes as $size)
                    <label style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; border: 1px solid #e2e8f0; border-radius: 4px; cursor: pointer;">
                        <input type="checkbox" name="sizes[]" value="{{ $size->id }}" {{ in_array($size->id, old('sizes', [])) ? 'checked' : '' }}>
                        <strong>{{ $size->name }}</strong>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="form-group mb-3">
            <label class="form-label">Product Image</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            <small style="color: #64748b; display: block; margin-top: 4px;">Recommended size: 800x1000px JPG, PNG, or WEBP.</small>
        </div>

        <div class="form-group mb-4">
            <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer;">
                <input type="checkbox" name="featured" value="1" {{ old('featured') ? 'checked' : '' }}>
                <span>Feature this product on Homepage</span>
            </label>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Create Product</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
