@extends('layouts.admin')

@section('title', 'Manage Ukay Items - THRIFT FINDS Admin')

@section('content')
<div class="admin-header">
    <div>
        <h1>Ukay Items</h1>
        <p style="color: #64748b; margin-top: 4px;">Manage thrift inventory, brand details, sizes, conditions, and stock status.</p>
    </div>
    <div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ Add New Ukay Item</a>
    </div>
</div>

<div class="table-card">
    @if($products->count() > 0)
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Item & Brand</th>
                    <th>Category</th>
                    <th>Size</th>
                    <th>Condition</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="table-img">
                        </td>
                        <td>
                            <strong>{{ $product->name }}</strong>
                            <div style="font-size: 12px; color: #64748b;">Brand: {{ $product->brand ?? 'Unbranded' }}</div>
                        </td>
                        <td>{{ $product->category->name ?? 'Uncategorized' }}</td>
                        <td><strong>{{ $product->size_text ?? 'Free Size' }}</strong></td>
                        <td><span class="badge badge-customer">{{ $product->condition ?? 'Good' }}</span></td>
                        <td><strong>{{ $product->formatted_price }}</strong></td>
                        <td>
                            @if($product->is_sold)
                                <span class="badge badge-cancelled">SOLD OUT</span>
                            @else
                                <span class="badge badge-completed">AVAILABLE (1)</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline btn-sm">Edit</a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this ukay item?');">
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

        <div style="padding: 20px;">
            {{ $products->links() }}
        </div>
    @else
        <div class="empty-state">
            <p>No ukay items in inventory yet. Click below to add your first pre-loved item.</p>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary mt-2">+ Add Ukay Item</a>
        </div>
    @endif
</div>
@endsection
