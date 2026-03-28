@extends('layouts.app')

@section('content')

<div class="container mt-5">

<h3 class="mb-4">🧾 Checkout</h3>

<form action="{{ route('place.order') }}" method="POST">
@csrf

<div class="row">

<!-- LEFT: USER DETAILS -->
<div class="col-md-6">

<div class="card p-4 shadow-sm">

<h5 class="mb-3">Billing Details</h5>

<input type="text" name="name" class="form-control mb-3" placeholder="Full Name" required>

<input type="text" name="phone" class="form-control mb-3" placeholder="Phone Number" required>

<textarea name="address" class="form-control mb-3" placeholder="Address" required></textarea>

<h6 class="mt-3">Select Payment Method</h6>

<div class="form-check">
<input class="form-check-input" type="radio" name="payment_method" value="cod" checked>
<label class="form-check-label">Cash on Delivery</label>
</div>

<div class="form-check">
<input class="form-check-input" type="radio" name="payment_method" value="upi">
<label class="form-check-label">UPI (PhonePe / GPay / Paytm)</label>
</div>

<div class="form-check">
<input class="form-check-input" type="radio" name="payment_method" value="razorpay">
<label class="form-check-label">Online Payment (Razorpay)</label>
</div>

</div>

</div>

<!-- RIGHT: ORDER SUMMARY -->
<div class="col-md-6">

<div class="card p-4 shadow-sm">

<h5>Order Summary</h5>

<ul class="list-group mb-3">

@php $total = 0; @endphp

@foreach($cart as $item)
@php $total += $item['price'] * $item['quantity']; @endphp

<li class="list-group-item d-flex justify-content-between">
{{ $item['name'] }} x {{ $item['quantity'] }}
<span>₹{{ $item['price'] * $item['quantity'] }}</span>
</li>
@endforeach

<li class="list-group-item d-flex justify-content-between fw-bold">
Total
<span>₹{{ $total }}</span>
</li>

</ul>

<!-- PLACE ORDER BUTTON -->
<button type="submit" class="btn btn-primary w-100 mb-2">
Place Order (COD)
</button>

<!-- UPI BUTTON -->
 <a href="upi://pay?pa=9617371417@ylb&pn=ADVANCE3D&am={{ $total }}&cu=INR"
    class="btn btn-success w-100 mb-2"
    onclick="alert('Open this on your mobile to complete UPI payment')">
    Pay via UPI
</a>

<!-- RAZORPAY BUTTON -->
<button type="button" id="rzp-button" class="btn btn-dark w-100">
Pay with Razorpay
</button>

<p class="text-muted text-center mt-2">
Scan QR if button doesn't work on desktop
</p>

<div class="text-center">
<img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=upi://pay?pa=9617371417@ylb&pn=ADVANCE3D&am={{ $total }}&cu=INR">
</div>

</div>

</div>

</div>

</form>

</div>

<!-- RAZORPAY SCRIPT -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
document.getElementById('rzp-button').onclick = function(e){

    e.preventDefault();

    var options = {
        "key": "{{ env('RAZORPAY_KEY') }}",
        "amount": "{{ $total * 100 }}",
        "currency": "INR",
        "name": "AD-VANCE 3D",
        "description": "Order Payment",

        "handler": function (response){

            fetch("{{ route('payment.verify') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    payment_id: response.razorpay_payment_id
                })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success){
                    alert("Payment Successful!");
                    window.location.href = "/";
                }
            });
        }
    };

    var rzp = new Razorpay(options);
    rzp.open();
};
</script>

@endsection