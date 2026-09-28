@extends('layouts.admin')

@section('title', 'Manage Products - ThreadLine Admin')

@section('content')
<div class="admin-header">
    <div>
        <h1>Products</h1>
        <p style="color: #64748b; margin-top: 4px;">Manage clothing catalog, stock, prices, and sizes.</p>
    </div>
    <div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ Add New Product</a>
    </div>
</div>

<div class="table-card">
    @if($products->count() > 0)
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Featured</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="table-img">
                        </td>
                        <td>
                            <strong>{{ $product->name }}</strong>
                            <div style="font-size: 12px; color: #64748b;">{{ $product->material ?? 'Standard Material' }}</div>
                        </td>
                        <td>{{ $product->category->name ?? 'Uncategorized' }}</td>
                        <td><strong>${{ number_format($product->price, 2) }}</strong></td>
                        <td>
                            @if($product->stock > 5)
                                <span style="color: #166534; font-weight: 600;">{{ $product->stock }} in stock</span>
                            @elseif($product->stock > 0)
                                <span style="color: #92400e; font-weight: 600;">Low: {{ $product->stock }} left</span>
                            @else
                                <span style="color: #991b1b; font-weight: 600;">Out of Stock</span>
                            @endif
                        </td>
                        <td>
                            @if($product->featured)
                                <span class="badge badge-completed">Featured</span>
                            @else
                                <span class="badge badge-customer">Regular</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline btn-sm">Edit</a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
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
            <p>No products available. Click below to add your first product.</p>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary mt-2">+ Add Product</a>
        </div>
    @endif
</div>
@endsection
