@extends('layouts.admin')

@section('title', 'Manage Clothing Sizes - ThreadLine Admin')

@section('content')
<div class="admin-header">
    <div>
        <h1>Sizes & Dimensions</h1>
        <p style="color: #64748b; margin-top: 4px;">Configure sizing options (XS, S, M, L, XL, XXL) and size chart measurements.</p>
    </div>
    <div>
        <a href="{{ route('admin.sizes.create') }}" class="btn btn-primary">+ Add New Size</a>
    </div>
</div>

<div class="table-card" style="max-width: 800px;">
    @if($sizes->count() > 0)
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Size Code</th>
                    <th>Chest / Width</th>
                    <th>Length</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sizes as $size)
                    <tr>
                        <td>#{{ $size->id }}</td>
                        <td><strong style="font-size: 16px;">{{ $size->name }}</strong></td>
                        <td>{{ $size->width ?? 'N/A' }}</td>
                        <td>{{ $size->length ?? 'N/A' }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.sizes.edit', $size) }}" class="btn btn-outline btn-sm">Edit</a>
                                <form action="{{ route('admin.sizes.destroy', $size) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this size option?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">
            <p>No size options configured.</p>
            <a href="{{ route('admin.sizes.create') }}" class="btn btn-primary mt-2">+ Add Size</a>
        </div>
    @endif
</div>
@endsection
