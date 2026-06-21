@extends('layouts.app')

@section('content')

<style>

/* =====================================================
   AD-VANCE 3D — WISHLIST PAGE
   modern / minimal restyle
   Tokens reused from layout.blade.php; fallbacks included.
   NOTE: removed the page-level `body{ background: gradient }`
   override from the original — it was painting over the
   site's actual --bg / dark-mode background on every page
   that includes this view. The page now inherits the normal
   site background instead.
===================================================== */

.wishlist-header{
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 28px;
}

.wishlist-mark{
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: 1.5px solid var(--ink, #1A1A1A);
    position: relative;
    flex-shrink: 0;
}
.wishlist-mark::before{
    content: "";
    position: absolute;
    inset: 8px;
    border: 1.5px solid var(--accent, #FF5A1F);
    border-radius: 50%;
}
body.dark-mode .wishlist-mark{ border-color: var(--ink-dark, #F2F1ED); }

.wishlist-title{
    font-family: var(--font-display, sans-serif);
    font-weight: 600;
    letter-spacing: -0.01em;
    color: var(--ink, #1A1A1A);
    margin: 0;
}
body.dark-mode .wishlist-title{ color: var(--ink-dark, #F2F1ED); }

.wishlist-count{
    color: var(--ink-soft, #6B6B65);
    font-size: 13.5px;
}
body.dark-mode .wishlist-count{ color: var(--ink-soft-dark, #9B9A92); }

.wishlist-list{
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.wishlist-item{
    display: flex;
    align-items: center;
    gap: 18px;
    padding: 14px 16px;
    border-radius: 6px;
    cursor: pointer;
    background: var(--bg-raised, #fff);
    border: 1px solid var(--hairline, #E8E6E0);
    transition: 0.25s ease;
}

.wishlist-item:hover{
    border-color: var(--accent, #FF5A1F);
    box-shadow: 0 16px 36px rgba(0,0,0,0.06);
}

.wishlist-item.removing{
    transform: translateX(120%);
    opacity: 0;
}

body.dark-mode .wishlist-item{
    background: var(--bg-raised-dark, #1A1A19);
    border-color: var(--hairline-dark, #2C2C29);
}

.wishlist-img{
    width: 80px;
    height: 80px;
    background: var(--accent-50, #FFF1EA);
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
body.dark-mode .wishlist-img{
    background: var(--accent-50-dark, #2A1A12);
}

.wishlist-img img{
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.wishlist-info{
    flex: 1;
    min-width: 0;
}

.wishlist-info .name{
    font-weight: 500;
    font-size: 14.5px;
    color: var(--ink, #1A1A1A);
    margin-bottom: 4px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
body.dark-mode .wishlist-info .name{ color: var(--ink-dark, #F2F1ED); }

.wishlist-info .price{
    font-family: var(--font-mono, monospace);
    font-size: 15px;
    font-weight: 500;
    color: var(--ink, #1A1A1A);
}
body.dark-mode .wishlist-info .price{ color: var(--ink-dark, #F2F1ED); }

.actions{
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
}

.heart{
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: 1px solid var(--hairline, #E8E6E0);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    color: var(--accent, #FF5A1F);
    cursor: pointer;
    transition: 0.2s ease;
    background: transparent;
}
.heart:hover{
    border-color: #B3261E;
    background: rgba(179,38,30,0.06);
}
body.dark-mode .heart{
    border-color: var(--hairline-dark, #2C2C29);
}

.cart-btn{
    border: 1px solid var(--ink, #1A1A1A);
    background: var(--ink, #1A1A1A);
    color: var(--bg, #FAFAF8);
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 14px;
    transition: 0.2s ease;
}
.cart-btn:hover{
    background: var(--accent, #FF5A1F);
    border-color: var(--accent, #FF5A1F);
}
body.dark-mode .cart-btn{
    background: var(--ink-dark, #F2F1ED);
    border-color: var(--ink-dark, #F2F1ED);
    color: var(--bg-dark, #0F0F0F);
}

/* EMPTY STATE */

.wishlist-empty{
    text-align: center;
    padding: 80px 20px;
}
.wishlist-empty i{
    font-size: 38px;
    color: var(--hairline, #E8E6E0);
    margin-bottom: 14px;
    display: block;
}
.wishlist-empty h3{
    font-family: var(--font-display, sans-serif);
    font-weight: 600;
    font-size: 1.4rem;
    color: var(--ink, #1A1A1A);
}
body.dark-mode .wishlist-empty h3{ color: var(--ink-dark, #F2F1ED); }
.wishlist-empty p{
    color: var(--ink-soft, #6B6B65);
    font-size: 14px;
}
body.dark-mode .wishlist-empty p{ color: var(--ink-soft-dark, #9B9A92); }
body.dark-mode .wishlist-empty i{ color: var(--hairline-dark, #2C2C29); }

.btn-wishlist-browse{
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: var(--ink, #1A1A1A);
    color: var(--bg, #FAFAF8);
    border: 1px solid var(--ink, #1A1A1A);
    border-radius: 3px;
    font-weight: 600;
    font-size: 13.5px;
    padding: 11px 22px;
    margin-top: 14px;
    transition: 0.2s ease;
}
.btn-wishlist-browse:hover{
    background: var(--accent, #FF5A1F);
    border-color: var(--accent, #FF5A1F);
    color: #fff;
}
body.dark-mode .btn-wishlist-browse{
    background: var(--ink-dark, #F2F1ED);
    border-color: var(--ink-dark, #F2F1ED);
    color: var(--bg-dark, #0F0F0F);
}

/* TOAST */

.toast-msg{
    position: fixed;
    bottom: 28px;
    right: 28px;
    background: var(--ink, #1A1A1A);
    color: var(--bg, #FAFAF8);
    padding: 12px 16px;
    border-radius: 4px;
    display: flex;
    gap: 14px;
    align-items: center;
    font-size: 13.5px;
    opacity: 0;
    transform: translateY(16px);
    transition: 0.25s ease;
    z-index: 9999;
}

.toast-msg.show{
    opacity: 1;
    transform: translateY(0);
}

body.dark-mode .toast-msg{
    background: var(--ink-dark, #F2F1ED);
    color: var(--bg-dark, #0F0F0F);
}

.toast-btn{
    background: transparent;
    border: 1px solid rgba(255,255,255,0.4);
    color: inherit;
    padding: 4px 12px;
    border-radius: 3px;
    cursor: pointer;
    font-size: 12.5px;
    font-weight: 600;
    transition: 0.2s ease;
}
.toast-btn:hover{
    border-color: var(--accent, #FF5A1F);
    color: var(--accent, #FF5A1F);
}
body.dark-mode .toast-btn{
    border-color: rgba(0,0,0,0.25);
}

@media (max-width: 576px){
    .wishlist-img{ width: 64px; height: 64px; }
    .wishlist-item{ padding: 12px; gap: 12px; }
}

</style>

<div class="container py-5">

<div class="wishlist-header">
    <span class="wishlist-mark"></span>
    <div>
        <h2 class="wishlist-title">My Wishlist</h2>
        @if($products->count())
        <span class="wishlist-count">{{ $products->count() }} item{{ $products->count() == 1 ? '' : 's' }} saved</span>
        @endif
    </div>
</div>

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

        <span class="heart wishlistBtn" data-id="{{ $product->id }}" aria-label="Remove from wishlist">
            <i class="bi bi-heart-fill"></i>
        </span>

        <button class="cart-btn moveToCart addToCart" data-id="{{ $product->id }}" aria-label="Move to cart">
            <i class="bi bi-cart"></i>
        </button>

    </div>

</div>

@endforeach

</div>

@else

<div class="wishlist-empty">
    <i class="bi bi-heart"></i>
    <h3>Your wishlist is empty</h3>
    <p>Browse our products and add items to your wishlist.</p>
    <a href="/products" class="btn-wishlist-browse">
        <i class="bi bi-box-seam"></i> Browse Products
    </a>
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

        showToast("Removed");
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

        showToast("Moved to cart");
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

    showToast("Restored");
    lastAction = null;
}

</script>

@endsection