@extends('layouts.app')

@section('content')

<div class="container mt-5">

<h3>Custom Orders</h3>

@foreach($orders as $order)

<div class="card mb-3">

<div class="card-body">

<p><strong>Name:</strong> {{ $order->name }}</p>
<p><strong>Phone:</strong> {{ $order->phone }}</p>
<p><strong>Description:</strong> {{ $order->description }}</p>

<p>
<strong>File:</strong> 
<a href="{{ asset('custom_uploads/'.$order->file) }}" target="_blank">
Download
</a>
</p>

<p><strong>Status:</strong> {{ $order->status }}</p>

</div>

</div>

@endforeach

</div>

@endsection