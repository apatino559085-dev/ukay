@extends('layouts.admin')

@section('title', 'Add New Ukay Item - THRIFT FINDS Admin')

@section('content')
<div class="admin-header">
    <div>
        <h1>Add New Ukay Item</h1>
        <p style="color: #64748b; margin-top: 4px;">Add a unique 1-of-1 pre-loved piece to the store inventory.</p>
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

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-row mb-3" style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
            <div class="form-group">
                <label class="form-label">Item Name *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="e.g. Vintage Denim Jacket" required>
            </div>

            <div class="form-group">
                <label class="form-label">Brand *</label>
                <input type="text" name="brand" class="form-control" value="{{ old('brand') }}" placeholder="e.g. Levi's, Adidas, Nike" required>
            </div>
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
                <label class="form-label">Price (₱ PHP) *</label>
                <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}" placeholder="450.00" required>
            </div>
        </div>

        <div class="form-row mb-3" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label class="form-label">Size Label *</label>
                <input type="text" name="size_text" class="form-control" value="{{ old('size_text') }}" placeholder="e.g. Medium, Large, 32" required>
            </div>

            <div class="form-group">
                <label class="form-label">Condition *</label>
                <select name="condition" class="form-control" required>
                    <option value="Good" {{ old('condition') == 'Good' ? 'selected' : '' }}>Good</option>
                    <option value="Excellent" {{ old('condition') == 'Excellent' ? 'selected' : '' }}>Excellent</option>
                    <option value="New / Like New" {{ old('condition') == 'New / Like New' ? 'selected' : '' }}>New / Like New</option>
                    <option value="Fair" {{ old('condition') == 'Fair' ? 'selected' : '' }}>Fair</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Color</label>
                <input type="text" name="color" class="form-control" value="{{ old('color') }}" placeholder="e.g. Washed Blue">
            </div>
        </div>

        <div class="form-row mb-3" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label class="form-label">Material Description</label>
                <input type="text" name="material" class="form-control" value="{{ old('material') }}" placeholder="e.g. 100% Cotton Denim">
            </div>

            <div class="form-group">
                <label class="form-label">Stock Quantity * (Ukay is usually 1)</label>
                <input type="number" name="stock" class="form-control" value="{{ old('stock', 1) }}" min="0" required>
            </div>
        </div>

        <div class="form-group mb-3">
            <label class="form-label">Exact Measurements</label>
            <input type="text" name="measurements" class="form-control" value="{{ old('measurements') }}" placeholder='e.g. Shoulder: 18", Chest: 21", Length: 27"'>
        </div>

        <div class="form-group mb-3">
            <label class="form-label">Item Description</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Describe the item condition, authenticity details, or vintage characteristics...">{{ old('description') }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label class="form-label">Primary Cover Image</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            <small style="color: #64748b; display: block; margin-top: 4px;">Main photo shown on store cards.</small>
        </div>

        <div class="form-group mb-3">
            <label class="form-label">Additional Angle / Detail Photos (Select Multiple)</label>
            <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
            <small style="color: #64748b; display: block; margin-top: 4px;">Select additional photos so customers can swipe through item angles.</small>
        </div>

        <div class="form-group mb-4">
            <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer;">
                <input type="checkbox" name="featured" value="1" {{ old('featured', 1) ? 'checked' : '' }}>
                <span>Feature this item on Homepage</span>
            </label>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Save Ukay Item</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
