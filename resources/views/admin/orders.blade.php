@extends('layouts.app')

@section('content')

<div class="container mt-5">

<h3>All Orders</h3>

@foreach($orders as $order)

<div class="card mb-4">

<div class="card-header d-flex justify-content-between">
    <strong>Order #{{ $order->id }}</strong>
    <span>Status: <b>{{ ucfirst($order->status) }}</b></span>
</div>

<div class="card-body">

<p><strong>Name:</strong> {{ $order->name }}</p>
<p><strong>Phone:</strong> {{ $order->phone }}</p>
<p><strong>Address:</strong> {{ $order->address }}</p>

<h5>Items:</h5>

<ul class="list-group mb-3">

@foreach($order->items as $item)

<li class="list-group-item d-flex justify-content-between">
    {{ $item->product->name ?? 'Deleted Product' }} x {{ $item->quantity }}
    <span>₹{{ $item->price * $item->quantity }}</span>
</li>

@endforeach

</ul>

<p><strong>Total:</strong> ₹{{ $order->total }}</p>

<!-- STATUS UPDATE -->

<form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
@csrf

<select name="status" class="form-control mb-2">

<option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
<option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
<option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
<option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>

</select>

<button class="btn btn-primary btn-sm">Update Status</button>

</form>

</div>

</div>

@endforeach

</div>

@endsection