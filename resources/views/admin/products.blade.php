@extends('layouts.app')

@section('content')

<div class="container py-5">

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0">📦 Admin Panel</h2>
        <small class="text-muted">Manage your products & orders</small>
    </div>

    <a href="{{ route('admin.products.create') }}" class="btn btn-primary shadow-sm">
        + Add Product
    </a>
</div>


<!-- ADMIN NAVIGATION -->
<div class="mb-4">

    <a href="{{ route('admin.products') }}" class="btn btn-outline-dark me-2">
        Products
    </a>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark me-2">Dashboard</a>
    <a href="{{ route('admin.orders') }}" class="btn btn-outline-dark me-2">
        Orders
    </a>

    <a href="{{ route('admin.custom.orders') }}" class="btn btn-outline-dark">
        Custom Orders
    </a>

</div>


<!-- SUCCESS MESSAGE -->
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif


<!-- PRODUCT TABLE -->
<div class="card shadow-sm border-0">

<div class="card-body">

<table class="table table-hover align-middle">

<thead class="table-dark">
<tr>
<th>#</th>
<th>Image</th>
<th>Name</th>
<th>Price</th>
<th>Stock</th>
<th class="text-center">Actions</th>
</tr>
</thead>

<tbody>

@forelse($products as $product)

<tr>

<td>{{ $product->id }}</td>

<td>
<img src="/product_images/{{ $product->image }}"
     width="60"
     height="60"
     class="rounded shadow-sm object-fit-cover">
</td>

<td class="fw-semibold">
{{ $product->name }}
</td>

<td class="text-success fw-bold">
₹{{ $product->price }}
</td>

<td>
<span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }}">
    {{ $product->stock }}
</span>
</td>

<td class="text-center">

<a href="{{ route('admin.products.edit', $product->id) }}"
   class="btn btn-sm btn-warning me-1">
   ✏
</a>

<a href="{{ route('admin.products.delete', $product->id) }}"
   class="btn btn-sm btn-danger"
   onclick="return confirm('Delete this product?')">
   🗑
</a>

</td>

</tr>

@empty

<tr>
<td colspan="6" class="text-center text-muted">
No products found
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</div>

@endsection