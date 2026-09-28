@extends('layouts.admin')

@section('title', 'Add New Category - ThreadLine Admin')

@section('content')
<div class="admin-header">
    <div>
        <h1>Add New Category</h1>
        <p style="color: #64748b; margin-top: 4px;">Create a new category for sorting clothing items.</p>
    </div>
    <div>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline">← Back to Categories</a>
    </div>
</div>

<div class="table-card" style="padding: 30px; max-width: 600px;">
    @if($errors->any())
        <div class="validation-errors">
            <ul>
                @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label class="form-label">Category Name *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="e.g. Outerwear, T-Shirts, Denim" required>
        </div>

        <div class="form-group mb-4">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" placeholder="Brief description of this category...">{{ old('description') }}</textarea>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Create Category</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
