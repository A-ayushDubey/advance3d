@extends('layouts.app')

@section('content')

<div class="container py-5">

<div class="row g-5">

<!-- ================= IMAGE SECTION ================= -->
<div class="col-md-6 text-center">

    <!-- MAIN IMAGE -->
    <div class="main-image-box">
        <img id="mainImage"
             src="/product_images/{{ $product->image }}"
             class="img-fluid rounded shadow main-image">
    </div>

    <!-- THUMBNAILS -->
    <div class="d-flex justify-content-center gap-2 mt-3 flex-wrap">

        @php
            $allImages = collect([$product->image]);
            if($product->images){
                foreach($product->images as $img){
                    if($img->image != $product->image){
                        $allImages->push($img->image);
                    }
                }
            }
        @endphp

        @foreach($allImages as $index => $img)
            <img src="/product_images/{{ $img }}"
                 class="thumb-img {{ $index == 0 ? 'active' : '' }}"
                 onclick="changeImage({{ $index }})">
        @endforeach

    </div>

</div>


<!-- ================= PRODUCT DETAILS ================= -->
<div class="col-md-6">

<h1 class="fw-bold mb-3 product-name">{{ $product->name }}</h1>

<h3 class="fw-bold mb-3 product-price-main">₹{{ $product->price }}</h3>

<p class="text-muted product-desc">{{ $product->description }}</p>

<div class="d-flex align-items-center mb-3">
<label class="me-3 fw-bold qty-label">Quantity:</label>
<input type="number" name="quantity" value="1" min="1"
class="form-control qty-input" style="width:100px;">
</div>

<button class="btn btn-dark btn-lg w-100 mb-3 addToCart" data-id="{{ $product->id }}">
    Add to Cart
</button>

<a href="https://wa.me/918827502969?text=I want to order this product:%0A%0AName: {{ $product->name }}%0APrice: ₹{{ $product->price }}"
target="_blank"
class="btn btn-success btn-lg w-100">
<i class="bi bi-whatsapp"></i> Order via WhatsApp
</a>

</div>


<!-- ================= RELATED PRODUCTS ================= -->

@php
$relatedProducts = \App\Models\Product::where('category', $product->category)
    ->where('id', '!=', $product->id)
    ->inRandomOrder()
    ->take(4)
    ->get();
@endphp

<h3 class="fw-bold mt-5 related-title">You may also like</h3>

<div class="row g-3">

@if($relatedProducts->count() > 0)

    @foreach($relatedProducts as $item)
    <div class="col-6 col-md-3">
        <a href="/product/{{ $item->id }}">
        <div class="related-card">

            <div class="related-img">
                <img src="/product_images/{{ $item->image }}">
            </div>

            <p class="related-name text-dark">
                {{ $item->name }} <br>
                <span class="related-price">₹{{ $item->price }}</span><br>

                <!-- FIXED LINK -->
                <a href="/product/{{ $item->id }}" class="btn btn-dark w-100">
                    View Details
                </a>
            </p>

        </div>
    </a>
    </div>

    @endforeach

@else

    <!-- FALLBACK IF NO RELATED PRODUCTS -->
    @php
    $fallbackProducts = \App\Models\Product::where('id','!=',$product->id)
        ->inRandomOrder()
        ->take(4)
        ->get();
    @endphp

    @foreach($fallbackProducts as $item)

    <div class="col-6 col-md-3">
        <div class="related-card">

            <div class="related-img">
                <img src="/product_images/{{ $item->image }}">
            </div>

            <p class="related-name text-dark">
                {{ $item->name }} <br>
                <span class="related-price">₹{{ $item->price }}</span><br>

                <a href="/product/{{ $item->id }}" class="btn btn-dark w-100">
                    View Details
                </a>
            </p>

        </div>
    </div>

    @endforeach

@endif

</div>

<!-- ================= END RELATED ================= -->

</div>

</div>


<!-- ================= FULLSCREEN MODAL ================= -->

<div id="imageModal" class="image-modal">

    <span class="close-btn" onclick="closeModal()">×</span>

    <button class="nav-btn prev" onclick="changeSlide(-1)">❮</button>

    <img id="modalImage">

    <button class="nav-btn next" onclick="changeSlide(1)">❯</button>

</div>


<!-- ================= STYLES ================= -->

<style>

/* =====================================================
   AD-VANCE 3D — PRODUCT DETAIL PAGE
   modern / minimal restyle
   Tokens reused from layout.blade.php; fallbacks included.
===================================================== */

/* PRODUCT NAME / PRICE / DESC */

.product-name{
    font-family: var(--font-display, sans-serif);
    font-weight: 600;
    letter-spacing: -0.01em;
    color: var(--ink, #1A1A1A);
}
body.dark-mode .product-name{
    color: var(--ink-dark, #F2F1ED);
}

.product-price-main{
    font-family: var(--font-mono, monospace);
    font-weight: 500;
    color: var(--ink, #1A1A1A);
    font-size: 1.6rem;
}
body.dark-mode .product-price-main{
    color: var(--ink-dark, #F2F1ED);
}

.product-desc{
    color: var(--ink-soft, #6B6B65) !important;
    font-size: 14.5px;
    line-height: 1.7;
}
body.dark-mode .product-desc{
    color: var(--ink-soft-dark, #9B9A92) !important;
}

.qty-label{
    color: var(--ink, #1A1A1A);
    font-size: 14px;
}
body.dark-mode .qty-label{
    color: var(--ink-dark, #F2F1ED);
}

.qty-input{
    border: 1px solid var(--hairline, #E8E6E0) !important;
    border-radius: 3px !important;
    font-family: var(--font-mono, monospace);
}
.qty-input:focus{
    border-color: var(--accent, #FF5A1F) !important;
    box-shadow: 0 0 0 3px var(--accent-50, #FFF1EA) !important;
}
body.dark-mode .qty-input{
    background: var(--bg-raised-dark, #1A1A19);
    border-color: var(--hairline-dark, #2C2C29) !important;
    color: var(--ink-dark, #F2F1ED);
}

/* BUTTONS */

.btn-dark{
    background: var(--ink, #1A1A1A) !important;
    border-color: var(--ink, #1A1A1A) !important;
    border-radius: 3px !important;
    font-weight: 600;
    transition: 0.2s ease;
}
.btn-dark:hover{
    background: var(--accent, #FF5A1F) !important;
    border-color: var(--accent, #FF5A1F) !important;
    transform: translateY(-1px);
}
body.dark-mode .btn-dark{
    background: var(--ink-dark, #F2F1ED) !important;
    border-color: var(--ink-dark, #F2F1ED) !important;
    color: var(--bg-dark, #0F0F0F) !important;
}

.btn-success{
    background: var(--ink, #1A1A1A) !important;
    border-color: var(--ink, #1A1A1A) !important;
    border-radius: 3px !important;
    transition: 0.2s ease;
}
.btn-success:hover{
    background: var(--accent, #FF5A1F) !important;
    border-color: var(--accent, #FF5A1F) !important;
    transform: translateY(-1px);
}
body.dark-mode .btn-success{
    background: var(--ink-dark, #F2F1ED) !important;
    border-color: var(--ink-dark, #F2F1ED) !important;
    color: var(--bg-dark, #0F0F0F) !important;
}

/* RELATED PRODUCTS */

.related-title{
    font-family: var(--font-display, sans-serif);
    font-weight: 600;
    font-size: 1.3rem;
    margin-bottom: 20px;
    color: var(--ink, #1A1A1A);
}
body.dark-mode .related-title{
    color: var(--ink-dark, #F2F1ED);
}

.related-card{
    border: 1px solid var(--hairline, #E8E6E0);
    border-radius: 6px;
    overflow: hidden;
    transition: 0.25s ease;
    background: var(--bg-raised, #fff);
}

.related-card:hover{
    border-color: var(--accent, #FF5A1F);
    box-shadow: 0 16px 36px rgba(0,0,0,0.08);
    transform: translateY(-5px);
}

body.dark-mode .related-card{
    background: var(--bg-raised-dark, #1A1A19);
    border-color: var(--hairline-dark, #2C2C29);
}

.related-img{
    width: 100%;
    aspect-ratio: 1 / 1;
    overflow: hidden;
    background: var(--accent-50, #FFF1EA);
}
body.dark-mode .related-img{
    background: var(--accent-50-dark, #2A1A12);
}

.related-img img{
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.related-name{
    font-size: 13.5px;
    font-weight: 500;
    padding: 12px;
    text-align: center;
    margin: 0;
    color: var(--ink, #1A1A1A);
}
body.dark-mode .related-name{
    color: var(--ink-dark, #F2F1ED) !important;
}

.related-price{
    font-family: var(--font-mono, monospace);
    font-weight: 500;
    color: var(--ink, #1A1A1A);
    font-size: 13px;
}
body.dark-mode .related-price{
    color: var(--ink-dark, #F2F1ED);
}

/* MAIN IMAGE */

.main-image-box{
    width:100%;
    height:400px;
    display:flex;
    align-items:center;
    justify-content:center;
    background: var(--accent-50, #FFF1EA);
    border-radius:8px;
}
body.dark-mode .main-image-box{
    background: var(--accent-50-dark, #2A1A12);
}

.main-image{
    max-height:100%;
    max-width:100%;
    object-fit:contain;
    cursor:pointer;
    box-shadow: none !important;
}

/* THUMBNAILS */

.thumb-img{
    width:68px;
    height:68px;
    object-fit:contain;
    border-radius:4px;
    cursor:pointer;
    border:1px solid var(--hairline, #E8E6E0);
    background: var(--accent-50, #FFF1EA);
    padding:5px;
    transition: 0.2s ease;
}
.thumb-img:hover{
    border-color: var(--accent, #FF5A1F);
    transform: scale(1.04);
}

.thumb-img.active{
    border:1.5px solid var(--ink, #1A1A1A);
}
body.dark-mode .thumb-img{
    background: var(--accent-50-dark, #2A1A12);
    border-color: var(--hairline-dark, #2C2C29);
}
body.dark-mode .thumb-img.active{
    border-color: var(--ink-dark, #F2F1ED);
}

/* MODAL */

.image-modal{
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background: rgba(15,15,15,0.97);
    justify-content:center;
    align-items:center;
    z-index:9999;
}

.image-modal img{
    max-width:90%;
    max-height:90%;
    object-fit:contain;
}

.close-btn{
    position:absolute;
    top:24px;
    right:32px;
    font-size:28px;
    color:white;
    cursor:pointer;
    width:38px;
    height:38px;
    border:1px solid rgba(255,255,255,0.25);
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    line-height:1;
    transition: 0.2s ease;
}
.close-btn:hover{
    border-color: var(--accent, #FF5A1F);
    color: var(--accent, #FF5A1F);
}

.nav-btn{
    position:absolute;
    top:50%;
    transform:translateY(-50%);
    font-size:20px;
    color:white;
    background:none;
    border:1px solid rgba(255,255,255,0.25);
    width:44px;
    height:44px;
    border-radius:50%;
    cursor:pointer;
    transition: 0.2s ease;
}
.nav-btn:hover{
    border-color: var(--accent, #FF5A1F);
    color: var(--accent, #FF5A1F);
}

.prev{ left:24px; }
.next{ right:24px; }

@media (max-width: 576px){
    .main-image-box{ height:300px; }
    .thumb-img{ width:56px; height:56px; }
}

</style>


<!-- ================= SCRIPT ================= -->

<script>

let images = [
    @php
        foreach($allImages as $img){
            echo "'/product_images/".$img."',";
        }
    @endphp
];

let currentIndex = 0;

function changeImage(index){
    currentIndex = index;

    document.getElementById("mainImage").src = images[index];

    document.querySelectorAll('.thumb-img').forEach((img,i)=>{
        img.classList.toggle('active', i === index);
    });
}

document.getElementById("mainImage").addEventListener("click", function(){
    document.getElementById("imageModal").style.display = "flex";
    document.getElementById("modalImage").src = images[currentIndex];
});

function closeModal(){
    document.getElementById("imageModal").style.display = "none";
}

function changeSlide(direction){
    currentIndex += direction;

    if(currentIndex < 0) currentIndex = images.length - 1;
    if(currentIndex >= images.length) currentIndex = 0;

    document.getElementById("modalImage").src = images[currentIndex];
}

</script>

@endsection