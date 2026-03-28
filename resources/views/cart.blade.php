@extends('layouts.app')

@section('content')

<div class="container py-5">

<h2 class="mb-4 fw-bold">Shopping Cart</h2>

@if(session('cart') && count(session('cart')) > 0)

<table class="table align-middle">

<thead class="table-dark">
<tr>
<th>Product</th>
<th>Price</th>
<th>Quantity</th>
<th>Subtotal</th>
<th>Action</th>
</tr>
</thead>

<tbody>

@php $total = 0; @endphp

@foreach(session('cart') as $id => $item)

@php
$subtotal = $item['price'] * $item['quantity'];
$total += $subtotal;
@endphp

<tr>

<td class="d-flex align-items-center">

<img src="/product_images/{{ $item['image'] }}"
width="70"
class="me-3 rounded shadow-sm">

<strong>{{ $item['name'] }}</strong>

</td>

<td>₹{{ $item['price'] }}</td>

<td>

<form action="/cart/update/{{ $id }}" method="POST" class="d-flex">

@csrf

<input type="number"
name="quantity"
value="{{ $item['quantity'] }}"
min="1"
class="form-control me-2"
style="width:80px">

<button class="btn btn-sm btn-dark">
Update
</button>

</form>

</td>

<td>₹{{ $subtotal }}</td>

<td>

<a href="/cart/remove/{{ $id }}"
class="btn btn-danger btn-sm">
Remove
</a>

</td>

</tr>

@endforeach

</tbody>

</table>


<!-- TOTAL SECTION -->

<div class="text-end mt-4">

<h3 class="fw-bold">
Total: ₹{{ $total }}
</h3>

</div>


<!-- ACTION BUTTONS -->

<div class="text-end mt-3">

<a href="/products" class="btn btn-outline-dark mt-3">
Continue Shopping
</a>

<a href="{{ route('checkout') }}" class="btn btn-primary mt-3">
Proceed to Checkout
</a>

@php
$message = "Hello, I want to order:%0A%0A";
$total = 0;

foreach(session('cart') as $item){
    $message .= $item['name']." x ".$item['quantity']." = ₹".($item['price']*$item['quantity'])."%0A";
    $total += $item['price']*$item['quantity'];
}

$message .= "%0ATotal: ₹".$total;
@endphp

<a href="https://wa.me/918827502969?text={{ $message }}" 
   target="_blank" 
   class="btn btn-success mt-3 w-100">

<i class="bi bi-whatsapp"></i> Order Full Cart on WhatsApp

</a>



</div>

@else

<!-- EMPTY CART -->

<div class="text-center py-5">

<h3>Your cart is empty</h3>

<p class="text-muted">
Browse our products and add items to your cart.
</p>

<a href="/products" class="btn btn-dark mt-3">
Browse Products
</a>

</div>

@endif

</div>

@endsection