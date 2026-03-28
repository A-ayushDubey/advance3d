@extends('layouts.app')

@section('content')

<div class="container py-5">

<h2 class="fw-bold mb-4">📊 Admin Dashboard</h2>

<!-- NAV -->
<div class="mb-4">
    <a href="{{ route('admin.dashboard') }}" class="btn btn-dark me-2">Dashboard</a>
    <a href="{{ route('admin.products') }}" class="btn btn-outline-dark me-2">Products</a>
    <a href="{{ route('admin.orders') }}" class="btn btn-outline-dark me-2">Orders</a>
    <a href="{{ route('admin.custom.orders') }}" class="btn btn-outline-dark">Custom Orders</a>
</div>

<!-- STATS -->
<div class="row g-4 mb-4">

<div class="col-md-3">
<div class="card p-4 shadow-sm text-center">
<h6>Total Products</h6>
<h3>{{ $totalProducts }}</h3>
</div>
</div>

<div class="col-md-3">
<div class="card p-4 shadow-sm text-center">
<h6>Total Orders</h6>
<h3>{{ $totalOrders }}</h3>
</div>
</div>

<div class="col-md-3">
<div class="card p-4 shadow-sm text-center">
<h6>Pending</h6>
<h3 class="text-warning">{{ $pendingOrders }}</h3>
</div>
</div>

<div class="col-md-3">
<div class="card p-4 shadow-sm text-center">
<h6>Revenue</h6>
<h3 class="text-success">₹{{ $revenue }}</h3>
</div>
</div>

</div>

<!-- CHART -->
<div class="card p-4 shadow-sm mb-4">
<h5>Monthly Revenue</h5>
<canvas id="revenueChart"></canvas>
</div>

<!-- ROW -->
<div class="row">

<!-- RECENT ORDERS -->
<div class="col-md-6">
<div class="card p-3 shadow-sm">

<h5>Recent Orders</h5>

<ul class="list-group">

@foreach($recentOrders as $order)
<li class="list-group-item d-flex justify-content-between">
    Order #{{ $order->id }}
    <span>₹{{ $order->total }}</span>
</li>
@endforeach

</ul>

</div>
</div>

<!-- TOP PRODUCTS -->
<div class="col-md-6">
<div class="card p-3 shadow-sm">

<h5>Top Products</h5>

<ul class="list-group">

@foreach($topProducts as $item)
<li class="list-group-item d-flex justify-content-between">
    {{ $item->product->name ?? 'Deleted' }}
    <span>{{ $item->total_qty }} sold</span>
</li>
@endforeach

</ul>

</div>
</div>

</div>

</div>

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('revenueChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_keys($monthlyRevenue->toArray())) !!},
        datasets: [{
            label: 'Revenue',
            data: {!! json_encode(array_values($monthlyRevenue->toArray())) !!}
        }]
    }
});
</script>

@endsection