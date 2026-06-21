@extends('layouts.app')

@section('content')

<div class="container py-5 cart-page">

<div class="cart-header mb-4">
    <span class="cart-mark"></span>
    <div>
        <h2 class="cart-title">Shopping Cart</h2>
        @if(session('cart') && count(session('cart')) > 0)
        <small class="cart-subtitle">{{ count(session('cart')) }} item{{ count(session('cart')) == 1 ? '' : 's' }} in your cart</small>
        @endif
    </div>
</div>

@if(session('cart') && count(session('cart')) > 0)

<div class="cart-table-card">
<div class="table-responsive">
<table class="table align-middle cart-table mb-0">

<thead>
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

<td>
<div class="cart-product-cell">
<img src="/product_images/{{ $item['image'] }}" class="cart-thumb">
<strong class="cart-product-name">{{ $item['name'] }}</strong>
</div>
</td>

<td class="price-cell">₹{{ $item['price'] }}</td>

<td>

<form action="/cart/update/{{ $id }}" method="POST" class="qty-update-form">

@csrf

<input type="number"
name="quantity"
value="{{ $item['quantity'] }}"
min="1"
class="qty-input-cart">

<button class="btn-update">
Update
</button>

</form>

</td>

<td class="price-cell subtotal-cell">₹{{ $subtotal }}</td>

<td>

<a href="/cart/remove/{{ $id }}"
class="btn-remove" aria-label="Remove item">
<i class="bi bi-trash3"></i> Remove
</a>

</td>

</tr>

@endforeach

</tbody>

</table>
</div>
</div>


<!-- TOTAL SECTION -->

<div class="cart-total-row">
<span class="cart-total-label">Total</span>
<span class="cart-total-value">₹{{ $total }}</span>
</div>


<!-- ACTION BUTTONS -->

<div class="cart-actions">

<a href="/products" class="btn-cart-secondary">
    Continue Shopping
</a>

<a href="{{ route('checkout') }}" class="btn-cart-primary">
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
   class="btn-cart-whatsapp">

<i class="bi bi-whatsapp"></i> Order Full Cart on WhatsApp

</a>

</div>

@else

<!-- EMPTY CART -->

<div class="cart-empty">

<i class="bi bi-cart-x"></i>
<h3>Your cart is empty</h3>
<p>Browse our products and add items to your cart.</p>

<a href="/products" class="btn-cart-primary">
    Browse Products
</a>

</div>

@endif

</div>


<style>

/* =====================================================
   AD-VANCE 3D — SHOPPING CART
   modern / minimal restyle
   Tokens reused from layout.blade.php; fallbacks included.
===================================================== */

.cart-header{
    display: flex;
    align-items: center;
    gap: 12px;
}

.cart-mark{
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: 1.5px solid var(--ink, #1A1A1A);
    position: relative;
    flex-shrink: 0;
}
.cart-mark::before{
    content: "";
    position: absolute;
    inset: 8px;
    border: 1.5px solid var(--accent, #FF5A1F);
    border-radius: 50%;
}
body.dark-mode .cart-mark{ border-color: var(--ink-dark, #F2F1ED); }

.cart-title{
    font-family: var(--font-display, sans-serif);
    font-weight: 600;
    letter-spacing: -0.01em;
    color: var(--ink, #1A1A1A);
    margin: 0;
}
body.dark-mode .cart-title{ color: var(--ink-dark, #F2F1ED); }

.cart-subtitle{
    color: var(--ink-soft, #6B6B65);
    font-size: 13.5px;
}
body.dark-mode .cart-subtitle{ color: var(--ink-soft-dark, #9B9A92); }

/* TABLE */

.cart-table-card{
    background: var(--bg-raised, #fff);
    border: 1px solid var(--hairline, #E8E6E0);
    border-radius: 6px;
    overflow: hidden;
}
body.dark-mode .cart-table-card{
    background: var(--bg-raised-dark, #1A1A19);
    border-color: var(--hairline-dark, #2C2C29);
}

.cart-table thead tr{
    border-bottom: 1px solid var(--hairline, #E8E6E0);
}
.cart-table thead th{
    font-family: var(--font-mono, monospace);
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--ink-soft, #6B6B65);
    font-weight: 500;
    padding: 14px 16px;
    border: none;
    background: transparent;
}
body.dark-mode .cart-table thead tr{ border-bottom-color: var(--hairline-dark, #2C2C29); }
body.dark-mode .cart-table thead th{ color: var(--ink-soft-dark, #9B9A92); }

.cart-table tbody tr{
    border-bottom: 1px solid var(--hairline, #E8E6E0);
}
.cart-table tbody tr:last-child{ border-bottom: none; }
body.dark-mode .cart-table tbody tr{ border-bottom-color: var(--hairline-dark, #2C2C29); }

.cart-table td{
    padding: 14px 16px;
    border: none;
    color: var(--ink, #1A1A1A);
    font-size: 14px;
}
body.dark-mode .cart-table td{ color: var(--ink-dark, #F2F1ED); }

.cart-product-cell{
    display: flex;
    align-items: center;
    gap: 14px;
}

.cart-thumb{
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 4px;
    border: 1px solid var(--hairline, #E8E6E0);
    background: var(--accent-50, #FFF1EA);
}
body.dark-mode .cart-thumb{
    border-color: var(--hairline-dark, #2C2C29);
    background: var(--accent-50-dark, #2A1A12);
}

.cart-product-name{
    font-size: 14px;
    font-weight: 500;
    color: var(--ink, #1A1A1A);
}
body.dark-mode .cart-product-name{ color: var(--ink-dark, #F2F1ED); }

.price-cell{
    font-family: var(--font-mono, monospace);
}

.subtotal-cell{
    font-weight: 500;
}

/* QUANTITY UPDATE FORM */

.qty-update-form{
    display: flex;
    gap: 8px;
    align-items: center;
}

.qty-input-cart{
    width: 64px;
    border: 1px solid var(--hairline, #E8E6E0);
    border-radius: 3px;
    font-family: var(--font-mono, monospace);
    font-size: 13.5px;
    padding: 7px 8px;
    background: var(--bg-raised, #fff);
    color: var(--ink, #1A1A1A);
    transition: border-color 0.2s ease;
}
.qty-input-cart:focus{
    outline: none;
    border-color: var(--accent, #FF5A1F);
    box-shadow: 0 0 0 3px var(--accent-50, #FFF1EA);
}
body.dark-mode .qty-input-cart{
    background: var(--bg-dark, #0F0F0F);
    border-color: var(--hairline-dark, #2C2C29);
    color: var(--ink-dark, #F2F1ED);
}

.btn-update{
    border: 1px solid var(--hairline, #E8E6E0);
    background: transparent;
    color: var(--ink, #1A1A1A);
    font-size: 12.5px;
    font-weight: 600;
    padding: 7px 12px;
    border-radius: 3px;
    transition: 0.2s ease;
}
.btn-update:hover{
    border-color: var(--ink, #1A1A1A);
    background: var(--ink, #1A1A1A);
    color: var(--bg, #FAFAF8);
}
body.dark-mode .btn-update{
    border-color: var(--hairline-dark, #2C2C29);
    color: var(--ink-dark, #F2F1ED);
}
body.dark-mode .btn-update:hover{
    background: var(--ink-dark, #F2F1ED);
    color: var(--bg-dark, #0F0F0F);
}

/* REMOVE BUTTON */

.btn-remove{
    display: inline-flex;
    align-items: center;
    gap: 6px;
    border: 1px solid var(--hairline, #E8E6E0);
    color: var(--ink-soft, #6B6B65);
    font-size: 12.5px;
    font-weight: 600;
    padding: 7px 12px;
    border-radius: 3px;
    transition: 0.2s ease;
}
.btn-remove:hover{
    border-color: #B3261E;
    color: #B3261E;
}
body.dark-mode .btn-remove{
    border-color: var(--hairline-dark, #2C2C29);
    color: var(--ink-soft-dark, #9B9A92);
}

/* TOTAL ROW */

.cart-total-row{
    display: flex;
    justify-content: flex-end;
    align-items: baseline;
    gap: 14px;
    margin-top: 24px;
    padding-top: 18px;
    border-top: 1px solid var(--hairline, #E8E6E0);
}
body.dark-mode .cart-total-row{
    border-top-color: var(--hairline-dark, #2C2C29);
}

.cart-total-label{
    font-size: 14px;
    color: var(--ink-soft, #6B6B65);
    text-transform: uppercase;
    letter-spacing: 0.04em;
    font-family: var(--font-mono, monospace);
    font-size: 12px;
}
body.dark-mode .cart-total-label{ color: var(--ink-soft-dark, #9B9A92); }

.cart-total-value{
    font-family: var(--font-mono, monospace);
    font-size: 1.7rem;
    font-weight: 500;
    color: var(--ink, #1A1A1A);
}
body.dark-mode .cart-total-value{ color: var(--ink-dark, #F2F1ED); }

/* ACTIONS */

.cart-actions{
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 10px;
    margin-top: 18px;
}

.btn-cart-secondary,
.btn-cart-primary,
.btn-cart-whatsapp{
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-size: 14px;
    font-weight: 600;
    padding: 12px 22px;
    border-radius: 3px;
    transition: 0.2s ease;
    width: 100%;
    max-width: 320px;
}

.btn-cart-secondary{
    background: transparent;
    border: 1px solid var(--hairline, #E8E6E0);
    color: var(--ink, #1A1A1A);
}
.btn-cart-secondary:hover{
    border-color: var(--accent, #FF5A1F);
    color: var(--accent, #FF5A1F);
}
body.dark-mode .btn-cart-secondary{
    border-color: var(--hairline-dark, #2C2C29);
    color: var(--ink-dark, #F2F1ED);
}

.btn-cart-primary{
    background: var(--ink, #1A1A1A);
    border: 1px solid var(--ink, #1A1A1A);
    color: var(--bg, #FAFAF8);
}
.btn-cart-primary:hover{
    background: var(--accent, #FF5A1F);
    border-color: var(--accent, #FF5A1F);
}
body.dark-mode .btn-cart-primary{
    background: var(--ink-dark, #F2F1ED);
    border-color: var(--ink-dark, #F2F1ED);
    color: var(--bg-dark, #0F0F0F);
}

.btn-cart-whatsapp{
    background: transparent;
    border: 1px solid #1E7E34;
    color: #1E7E34;
}
.btn-cart-whatsapp:hover{
    background: #1E7E34;
    color: #fff;
}
body.dark-mode .btn-cart-whatsapp{
    border-color: #7FD99A;
    color: #7FD99A;
}
body.dark-mode .btn-cart-whatsapp:hover{
    background: #1E7E34;
    color: #fff;
}

@media (max-width: 576px){
    .cart-actions{ align-items: stretch; }
    .btn-cart-secondary,
    .btn-cart-primary,
    .btn-cart-whatsapp{ max-width: none; }
    .qty-update-form{ flex-wrap: wrap; }
}

/* EMPTY STATE */

.cart-empty{
    text-align: center;
    padding: 90px 20px;
}
.cart-empty i{
    font-size: 40px;
    color: var(--hairline, #E8E6E0);
    margin-bottom: 14px;
    display: block;
}
.cart-empty h3{
    font-family: var(--font-display, sans-serif);
    font-weight: 600;
    color: var(--ink, #1A1A1A);
}
body.dark-mode .cart-empty h3{ color: var(--ink-dark, #F2F1ED); }
.cart-empty p{
    color: var(--ink-soft, #6B6B65);
    font-size: 14px;
    margin-bottom: 18px;
}
body.dark-mode .cart-empty p{ color: var(--ink-soft-dark, #9B9A92); }
body.dark-mode .cart-empty i{ color: var(--hairline-dark, #2C2C29); }

.cart-empty .btn-cart-primary{
    display: inline-flex;
    width: auto;
    max-width: none;
}

</style>

@endsection