@extends('layouts.admin')

@section('title', 'Manage Categories - ThreadLine Admin')

@section('content')
<div class="admin-header">
    <div>
        <h1>Categories</h1>
        <p style="color: #64748b; margin-top: 4px;">Organize products into clothing categories.</p>
    </div>
    <div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">+ Add New Category</a>
    </div>
</div>

<div class="table-card">
    @if($categories->count() > 0)
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Products Count</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>#{{ $category->id }}</td>
                        <td><strong>{{ $category->name }}</strong></td>
                        <td>{{ $category->description ?? 'No description provided.' }}</td>
                        <td>
                            <span class="badge badge-customer">{{ $category->products_count }} products</span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-outline btn-sm">Edit</a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure? Products in this category will become uncategorized.');">
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
            <p>No categories created yet.</p>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mt-2">+ Add Category</a>
        </div>
    @endif
</div>
@endsection
