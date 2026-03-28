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

<h1 class="fw-bold mb-3">{{ $product->name }}</h1>

<h3 class="text-primary fw-bold mb-3">₹{{ $product->price }}</h3>

<p class="text-muted">{{ $product->description }}</p>

<div class="d-flex align-items-center mb-3">
<label class="me-3 fw-bold">Quantity:</label>
<input type="number" name="quantity" value="1" min="1"
class="form-control" style="width:100px;">
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
                <span class="text-primary">₹{{ $item->price }}</span><br>

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
                <span class="text-primary">₹{{ $item->price }}</span><br>

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

/* RELATED PRODUCTS */

.related-title{
    font-size: 22px;
    margin-bottom: 20px;
}

.related-card{
    border: 1px solid #eee;
    border-radius: 10px;
    overflow: hidden;
    transition: 0.3s;
    background: #fff;
}

.related-card:hover{
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    transform: translateY(-5px);
}

.related-img{
    width: 100%;
    aspect-ratio: 1 / 1;
    overflow: hidden;
    background: #f8f9fa;
}

.related-img img{
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.related-name{
    font-size: 14px;
    font-weight: 500;
    padding: 10px;
    text-align: center;
    margin: 0;
}

/* MAIN IMAGE */

.main-image-box{
    width:100%;
    height:400px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#f8f9fa;
    border-radius:10px;
}

.main-image{
    max-height:100%;
    max-width:100%;
    object-fit:contain;
    cursor:pointer;
}

/* THUMBNAILS */

.thumb-img{
    width:70px;
    height:70px;
    object-fit:contain;
    border-radius:8px;
    cursor:pointer;
    border:2px solid transparent;
    background:#f8f9fa;
    padding:5px;
}

.thumb-img.active{
    border:2px solid black;
}

/* MODAL */

.image-modal{
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:black;
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
    top:20px;
    right:30px;
    font-size:40px;
    color:white;
    cursor:pointer;
}

.nav-btn{
    position:absolute;
    top:50%;
    transform:translateY(-50%);
    font-size:40px;
    color:white;
    background:none;
    border:none;
    cursor:pointer;
}

.prev{ left:20px; }
.next{ right:20px; }

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