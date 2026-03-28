@extends('layouts.app')

@section('content')

<style>
body{
    background:linear-gradient(135deg,#f8f9fa,#eef1f5);
}

.wishlist-list{
    display:flex;
    flex-direction:column;
    gap:20px;
}

.wishlist-item{
    display:flex;
    align-items:center;
    gap:18px;
    padding:16px;
    border-radius:16px;
    cursor:pointer;
    background:#fff;
    border:1px solid #eee;
    transition:0.3s;
}

.wishlist-item:hover{
    transform:translateY(-3px);
    box-shadow:0 15px 30px rgba(0,0,0,0.08);
}

.wishlist-item.removing{
    transform:translateX(120%);
    opacity:0;
}

.wishlist-img{
    width:90px;
    height:90px;
    background:#f1f3f5;
    border-radius:10px;
    display:flex;
    align-items:center;
    justify-content:center;
}

.wishlist-img img{
    max-width:100%;
    max-height:100%;
    object-fit:contain;
}

.wishlist-info{
    flex:1;
}

.name{
    font-weight:600;
}

.price{
    font-size:18px;
    font-weight:bold;
    color:#0d6efd;
}

.actions{
    display:flex;
    gap:10px;
}

.heart{
    font-size:20px;
    cursor:pointer;
}

.cart-btn{
    border:none;
    background:#28a745;
    color:#fff;
    padding:8px 12px;
    border-radius:8px;
    cursor:pointer;
}

.toast-msg{
    position:fixed;
    bottom:20px;
    right:20px;
    background:#111;
    color:#fff;
    padding:12px 18px;
    border-radius:10px;
    display:flex;
    gap:10px;
    align-items:center;
    opacity:0;
    transform:translateY(20px);
    transition:0.3s;
}

.toast-msg.show{
    opacity:1;
    transform:translateY(0);
}

.toast-btn{
    background:#fff;
    border:none;
    padding:4px 10px;
    border-radius:6px;
    cursor:pointer;
}
</style>

<div class="container py-5">

<h2 class="fw-bold mb-4">❤️ My Wishlist</h2>

@if($products->count())

<div class="wishlist-list">

@foreach($products as $product)

<div class="wishlist-item" data-id="{{ $product->id }}">

    <div class="wishlist-img">
        <img src="/product_images/{{ $product->image }}">
    </div>

    <div class="wishlist-info">
        <div class="name">{{ $product->name }}</div>
        <div class="price">₹{{ $product->price }}</div>
    </div>

    <div class="actions">

        <span class="heart wishlistBtn" data-id="{{ $product->id }}">❤️</span>

        <button class="cart-btn moveToCart addToCart" data-id="{{ $product->id }}">
            <i class="bi bi-cart"></i>
             <!-- Add to Cart -->
        </button>        

    </div>

</div>

@endforeach

</div>

@else

<div class="text-center py-5">
    <!-- <h4>Empty Wishlist </h4> -->
    <h3>Your wishlist is empty</h3>
    <p class="text-muted">
        Browse our products and add items to your wishlist.
    </p>
    <a href="/products" class="btn btn-dark mt-3">Browse Product</a>
</div>

@endif

</div>

<!-- TOAST -->
<div id="toast" class="toast-msg">
    <span id="toastText"></span>
    <button class="toast-btn" onclick="undo()">Undo</button>
</div>

<script>

let lastAction = null;
let timer = null;

// NAVIGATION
document.addEventListener('click', function(e){

    let card = e.target.closest('.wishlist-item');

    if(card && !e.target.closest('.actions')){
        let id = card.dataset.id;
        window.location = '/product/' + id;
    }

});

// GLOBAL HANDLER
document.addEventListener('click', function(e){

    // REMOVE
    let removeBtn = e.target.closest('.wishlistBtn');
    if(removeBtn){

        let id = removeBtn.dataset.id;
        let item = removeBtn.closest('.wishlist-item');

        lastAction = { type:'remove', id, html:item.outerHTML };

        removeItem(item);

        fetch('/wishlist/toggle/' + id, {
            method:'POST',
            headers:{
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type':'application/json'
            }
        });

        showToast("Removed ❌");
    }

    // MOVE TO CART
    let cartBtn = e.target.closest('.moveToCart');
    if(cartBtn){

        let id = cartBtn.dataset.id;
        let item = cartBtn.closest('.wishlist-item');

        lastAction = { type:'move', id, html:item.outerHTML };

        fetch('/cart/add/' + id, {
            method:'POST',
            headers:{
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        fetch('/wishlist/toggle/' + id, {
            method:'POST',
            headers:{
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        removeItem(item);

        showToast("Moved to cart 🛒");
    }

});

// REMOVE ANIMATION
function removeItem(item){
    item.classList.add('removing');
    setTimeout(()=> item.remove(), 400);
}

// TOAST
function showToast(msg){
    let toast = document.getElementById('toast');
    document.getElementById('toastText').innerText = msg;

    toast.classList.add('show');

    if(timer) clearTimeout(timer);

    timer = setTimeout(()=>{
        toast.classList.remove('show');
        lastAction = null;
    },3000);
}

// UNDO
function undo(){

    if(!lastAction) return;

    let wrapper = document.querySelector('.wishlist-list');

    wrapper.insertAdjacentHTML('afterbegin', lastAction.html);

    if(lastAction.type === 'remove'){
        fetch('/wishlist/toggle/' + lastAction.id, {
            method:'POST',
            headers:{
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
    }

    if(lastAction.type === 'move'){
        fetch('/cart/remove/' + lastAction.id, {
            method:'POST',
            headers:{
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        fetch('/wishlist/toggle/' + lastAction.id, {
            method:'POST',
            headers:{
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
    }

    showToast("Restored ❤️");
    lastAction = null;
}

</script>

@endsection