@extends('layouts.admin')

@section('title', 'Add New Size - ThreadLine Admin')

@section('content')
<div class="admin-header">
    <div>
        <h1>Add New Size Option</h1>
        <p style="color: #64748b; margin-top: 4px;">Create a new size label and optional size chart measurements.</p>
    </div>
    <div>
        <a href="{{ route('admin.sizes.index') }}" class="btn btn-outline">← Back to Sizes</a>
    </div>
</div>

<div class="table-card" style="padding: 30px; max-width: 500px;">
    @if($errors->any())
        <div class="validation-errors">
            <ul>
                @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.sizes.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label class="form-label">Size Code / Name *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="e.g. S, M, L, XL, XXL, 32/34" required>
        </div>

        <div class="form-group mb-3">
            <label class="form-label">Chest / Width Measurement</label>
            <input type="text" name="width" class="form-control" value="{{ old('width') }}" placeholder='e.g. 21" (53cm)'>
        </div>

        <div class="form-group mb-4">
            <label class="form-label">Length Measurement</label>
            <input type="text" name="length" class="form-control" value="{{ old('length') }}" placeholder='e.g. 29" (74cm)'>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Create Size</button>
            <a href="{{ route('admin.sizes.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
