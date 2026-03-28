@extends('layouts.app') @section('content')

<style>
    /* HERO VIDEO */

    .hero-video {
        position: relative;
        height: 90vh;
        overflow: hidden;
    }

    .hero-video video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* 🔥 Better overlay */
    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            to bottom,
            rgba(0, 0, 0, 0.5),
            rgba(0, 0, 0, 0.8)
        );
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
    }

    /* Buttons */

    .btn {
        transition: 0.3s;
        border-radius: 8px;
    }

    .btn:hover {
        transform: scale(1.05);
    }

   
    /* Scroll animation */

    .fade-in {
        opacity: 0;
        transform: translateY(40px);
        transition: 1s;
    }

    .fade-in.show {
        opacity: 1;
        transform: translateY(0);
    }

    /* Section spacing */

    section {
        margin-top: 0px;
    }

    /* Testimonials */

    .card p {
        font-style: italic;
    }
    .featured-img {
        width: 100%;
        aspect-ratio: 1/1;
        object-fit: cover;
    }

    /* =========================
 GLOBAL SECTION IMPROVEMENTS
========================= */

    section h2 {
        font-size: 2.2rem;
        letter-spacing: 1px;
        position: relative;
        display: inline-block;
    }

    section h2::after {
        content: "";
        width: 60px;
        height: 3px;
        background: #0d6efd;
        display: block;
        margin: 10px auto 0;
        border-radius: 10px;
    }

    /* =========================
 PRICING SECTION
========================= */

    .price-box {
        background: white;
        padding: 30px;
        border-radius: 15px;
        font-size: 1.2rem;
        font-weight: 600;
        transition: 0.4s;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .price-box:hover {
        transform: translateY(-10px) scale(1.03);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    }

    .price-box span {
        display: block;
        font-size: 1.5rem;
        color: #28a745;
        margin-top: 10px;
    }

    /* =========================
 WHY CHOOSE US
========================= */

    .feature-box {
        background: #fff;
        padding: 25px;
        border-radius: 15px;
        transition: 0.3s;
        font-size: 1.1rem;
        font-weight: 500;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }

    .feature-box:hover {
        transform: translateY(-8px);
        background: #0d6efd;
        color: white;
    }

    .feature-box i {
        font-size: 30px;
        margin-bottom: 10px;
        display: block;
    }

    /* =========================
 GALLERY (OUR WORK)
========================= */

    .gallery-img {
        border-radius: 15px;
        border: 2px solid #fff;
        overflow: hidden;
        transition: 0.4s;
        cursor: pointer;
        width: 100%;
        aspect-ratio: 1 / 1; /* keeps square shape */
    }

    .gallery-img img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* important */
        transition: 0.4s;
    }
    @media (max-width: 768px) {
        .feature-box {
            padding: 15px;
            font-size: 14px;
            border-radius: 12px;
        }
    }
    @media (max-width: 768px) {
        .price-box {
            padding: 18px;
            font-size: 14px;
            border-radius: 12px;
            max-width: 280px;
            margin: 0 auto;
        }

        .price-box span {
            font-size: 18px;
        }
    }

    /* Hover effect */
    .gallery-img:hover img {
        transform: scale(1.1);
    }

    /* =========================
 RESPONSIVE TWEAKS
========================= */

    /* Tablet */
    @media (max-width: 992px) {
        .gallery-img {
            aspect-ratio: 1 / 1;
        }
    }

    /* Mobile */
    @media (max-width: 576px) {
        .gallery-img {
            aspect-ratio: 1 / 1;
        }
    }
    @media (max-width: 768px) {
        section h2 {
            font-size: 20px;
        }
    }

    @media (max-width: 768px) {
        .price-box {
            padding: 20px;
            font-size: 14px;
        }

        .price-box span {
            font-size: 18px;
        }
    }

    @media (max-width: 768px) {
        .feature-box {
            padding: 15px;
            font-size: 14px;
        }
    }

    @media (max-width: 768px) {
        .gallery-img {
            margin-bottom: 10px;
        }
    }
    @media (max-width: 768px) {
        .btn {
            margin-bottom: 5px;
        }
    }

    @media (max-width: 768px) {
        .container {
            padding-left: 12px;
            padding-right: 12px;
        }
    }
    @media (max-width: 768px) {
        .carousel-item img {
            height: 250px !important;
        }

        .carousel-caption h1 {
            font-size: 18px;
        }

        .carousel-caption p {
            font-size: 13px;
        }
    }

    .gallery-img:hover img {
        transform: scale(1.1);
    }

    .gallery-img:hover {
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
    }
    @media (max-width: 768px) {
        .hero-video {
            height: 65vh;
        }

        .hero-overlay h1 {
            font-size: 24px;
        }

        .hero-overlay p {
            font-size: 14px;
        }

        .hero-overlay .btn {
            font-size: 14px;
            padding: 8px 12px;
            margin-top: 10px;
        }
    }
/* =========================
 DARK MODE FULL FIX
========================= */

body.dark-mode {
    background: #121212;
    color: #e4e4e4;
}

/* Light sections → dark */
body.dark-mode .bg-light {
    background: #1a1a1a !important;
    color: #fff;
}

/* Cards */
body.dark-mode .card,
body.dark-mode .price-box,
body.dark-mode .feature-box {
    background: #1e1e1e !important;
    color: #fff;
    box-shadow: 0 10px 30px rgba(0,0,0,0.6);
}

/* Feature hover fix */
body.dark-mode .feature-box:hover {
    background: #0d6efd;
    color: white;
}

/* Text fixes */
body.dark-mode p,
body.dark-mode span,
body.dark-mode h1,
body.dark-mode h2,
body.dark-mode h3,
body.dark-mode h4,
body.dark-mode h5 {
    color: #fff;
}

/* Muted text */
body.dark-mode .text-muted {
    color: #aaa !important;
}

/* Accordion */
body.dark-mode .accordion-button {
    background: #2a2a2a;
    color: #fff;
}

body.dark-mode .accordion-button:not(.collapsed) {
    background: #0d6efd;
    color: #fff;
}

body.dark-mode .accordion-body {
    background: #1e1e1e;
    color: #ccc;
}

/* Gallery border fix */
body.dark-mode .gallery-img {
    border-color: #333;
}

/* Carousel caption */
body.dark-mode .carousel-caption {
    color: #fff;
}

/* CTA section already dark - safe */
body.dark-mode .bg-dark {
    background: #000 !important;
}

/* Buttons */
body.dark-mode .btn-outline-primary {
    color: #fff;
    border-color: #555;
}

body.dark-mode .btn-outline-primary:hover {
    background: #fff;
    color: #000;
}
    /* =========================
 FAQ SECTION
========================= */

    .accordion-item {
        border: none;
        margin-bottom: 15px;
        border-radius: 10px !important;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }

    .accordion-button {
        font-weight: 600;
        font-size: 1.1rem;
        background: #f8f9fa;
        transition: 0.3s;
    }

    .accordion-button:not(.collapsed) {
        background: #0d6efd;
        color: white;
    }

    .accordion-button:focus {
        box-shadow: none;
    }

    .accordion-body {
        font-size: 0.95rem;
        color: #555;
    }

    /* =========================
 DARK SECTION FIX (Gallery)
========================= */

    .bg-dark h2::after {
        background: #ffc107;
    }

/* =========================
 PROCESS GRAPH SECTION
========================= */

.process-section {
    /* background: radial-gradient(circle, #0a0a0a, #000); */
    /* color: #fff; */
}

/* LINE CONTAINER */
.process-line {
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    margin-top: 60px;
}

/* CONNECTING LINE */
.process-line::before {
    content: "";
    position: absolute;
    top: 25px;
    left: 5%;
    width: 90%;
    height: 3px;
    background: linear-gradient(to right, #0d6efd, #00d4ff);
    z-index: 0;
}

/* STEP */
.process-step {
    position: relative;
    z-index: 2;
    text-align: center;
    width: 25%;
}

/* CIRCLE NODE */
.circle {
    width: 50px;
    height: 50px;
    background: #000;
    border: 2px solid #0d6efd;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 10px;
    font-weight: bold;
    transition: 0.4s;
    color:#fff;
}

/* TEXT */
.process-step h6 {
    font-size: 16px;
    /* color: #ccc; */
}

/* HOVER EFFECT */
.process-step:hover .circle {
    /* background: #0d6efd; */
    color: #fff;
    transform: scale(1.2);
    box-shadow: 0 0 20px rgba(13,110,253,0.7);
}

/* =========================
 ANIMATION FLOW EFFECT
========================= */

.process-line::after {
    content: "";
    position: absolute;
    top: 25px;
    left: 5%;
    width: 0%;
    height: 3px;
    background: #626060;
    animation: flow 3s linear infinite;
}

@keyframes flow {
    0% { width: 0%; }
    100% { width: 90%; }
}

/* =========================
 RESPONSIVE
========================= */

@media (max-width: 768px) {

    .process-line {
        flex-direction: column;
        gap: 40px;
    }

    .process-line::before,
    .process-line::after {
        display: none;
    }

    .process-step {
        width: 100%;
    }
}
/* =========================
 PREMIUM DARK PRODUCT CARD
========================= */

.premium-card {
    background: #0d0d0d;
    border-radius: 16px;
    overflow: hidden;
    transition: 0.4s ease;
    color: #fff;
    position: relative;
}

.premium-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 25px 60px rgba(0,0,0,0.7);
}

/* IMAGE */
.premium-img {
    position: relative;
    background: radial-gradient(circle at center, #1a1a1a, #000);
    padding: 4px;
    object-fit: cover;
}

.premium-img img {
    width: 100%;
    height: 260px;
    border-radius: 10px;
    /* object-fit: contain; */
    object-fit: cover;
    transition: 0.5s;
}

.premium-card:hover img {
    transform: scale(1.08);
}

/* SALE BADGE */
.badge-sale {
    position: absolute;
    bottom: 10px;
    left: 15px;
    background: transparent;
    border: 1px solid #555;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
}

/* CONTENT */
.premium-content {
    padding: 18px;
}

/* TITLE */
.product-title {
    font-size: 14px;
    font-weight: 500;
    line-height: 1.4;
    margin-bottom: 8px;
    color: #ddd;
}

/* RATING */
.rating {
    font-size: 13px;
    color: #fff;
    margin-bottom: 10px;
}

.rating span {
    color: #aaa;
    font-size: 12px;
}

/* PRICE */
.price {
    display: flex;
    gap: 10px;
    align-items: center;
}

.price .old {
    text-decoration: line-through;
    color: #888;
    font-size: 14px;
}

.price .new {
    font-size: 18px;
    font-weight: bold;
    color: #fff;
}

/* =========================
 DARK MODE SAFE (already dark)
========================= */
body.dark-mode .premium-card {
    background: #000;
}

/* =========================
 3D LAB SECTION (PREMIUM)
========================= */

.lab-section {
    /* background: radial-gradient(circle at center, #0a0a0a, #000); */
    /* color: #fff; */
    position: relative;
    overflow: hidden;
}

/* Optional tech lines effect */
.lab-section::before {
    content: "";
    position: absolute;
    width: 100%;
    height: 100%;
    background:
        linear-gradient(120deg, transparent 95%, rgba(0,150,255,0.15)),
        linear-gradient(-120deg, transparent 95%, rgba(0,150,255,0.15));
    pointer-events: none;
}

/* =========================
 GRID LAYOUT
========================= */

.lab-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-auto-rows: 160px;
    gap: 20px;
}

/* =========================
 GRID ITEMS
========================= */

.lab-item {
    position: relative;
    overflow: hidden;
    border-radius: 18px;
    background: #111;
    cursor: pointer;
    transition: 0.4s ease;
}

/* BIG FEATURE ITEM */
.lab-item.big {
    grid-column: span 2;
    grid-row: span 2;
}

/* =========================
 IMAGE
========================= */

.lab-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: 0.6s ease;
}

/* =========================
 HOVER EFFECTS (DESKTOP)
========================= */

.lab-item:hover {
    transform: translateY(-15px) scale(1.03);
    box-shadow:
        0 30px 60px rgba(0,0,0,0.9),
        0 0 25px rgba(0,150,255,0.25);
}

.lab-item:hover img {
    transform: scale(1.15);
}

/* =========================
 OVERLAY TEXT
========================= */

.lab-overlay {
    position: absolute;
    bottom: 0;
    width: 100%;
    padding: 20px;
    background: linear-gradient(to top, rgba(0,0,0,0.9), transparent);
    opacity: 0;
    transition: 0.4s;
}

.lab-item:hover .lab-overlay {
    opacity: 1;
}

.lab-overlay h5 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
}

.lab-overlay p {
    font-size: 12px;
    color: #ccc;
    margin: 0;
}

/* =========================
 RESPONSIVE DESIGN
========================= */

/* TABLET */
@media (max-width: 992px) {

    .lab-grid {
        grid-template-columns: repeat(3, 1fr);
        grid-auto-rows: 140px;
        gap: 15px;
    }

    .lab-item.big {
        grid-column: span 2;
        grid-row: span 2;
    }
}

/* MOBILE */
@media (max-width: 768px) {

    .lab-grid {
        grid-template-columns: repeat(2, 1fr);
        grid-auto-rows: 130px;
        gap: 12px;
    }

    /* Big item stays impactful */
    .lab-item.big {
        grid-column: span 2;
        grid-row: span 2;
    }

    .lab-overlay {
        opacity: 1; /* always visible on mobile */
        padding: 12px;
    }

    .lab-overlay h5 {
        font-size: 14px;
    }
}

/* SMALL MOBILE */
@media (max-width: 480px) {

    .lab-grid {
        grid-template-columns: 1fr;
        grid-auto-rows: 220px;
    }

    .lab-item.big {
        grid-column: span 1;
        grid-row: span 1;
    }

    .lab-item {
        border-radius: 14px;
    }

    .lab-overlay h5 {
        font-size: 13px;
    }
}

/* =========================
 MOBILE HOVER FIX
========================= */

@media (hover: none) {

    .lab-item:hover {
        transform: none;
        box-shadow: none;
    }

    .lab-item:hover img {
        transform: none;
    }
}

/* =========================
 SMOOTH ANIMATION
========================= */

.fade-in {
    opacity: 0;
    transform: translateY(40px);
    transition: 1s;
}

.fade-in.show {
    opacity: 1;
    transform: translateY(0);
}
</style>

<!-- =========================
 VIDEO HERO
========================= -->

<section class="hero-video">
    <video autoplay muted loop>
        <source
            src="https://www.pexels.com/download/video/26621066/"
            type="video/mp4"
        />
    </video>

    <div class="hero-overlay">
        <div>
            <h1 class="display-3 fw-bold">AD-VANCE 3D Printing</h1>

            <p class="lead">Turn your imagination into real objects</p>

            <a href="/products" class="btn btn-primary btn-lg mt-3 me-2">
                Browse Products
            </a>

            <a href="#" class="btn btn-warning btn-lg mt-3"> Custom Order </a>
        </div>
    </div>
</section>

<section class="py-5 bg-light text-center fade-in">
    <div class="container">
        <h2 class="fw-bold mb-4">Starting Prices</h2>

        <div class="row g-3">
            <div class="col-12 col-md-4">
                <div class="price-box">
                    🔹 Small Prints
                    <span>₹99+</span>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="price-box">
                    🔹 Medium Prints
                    <span>₹299+</span>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="price-box">
                    🔹 Custom Projects
                    <span>₹499+</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 fade-in">
    <div class="container text-center">
        <h2 class="fw-bold mb-5">Why Choose AD-VANCE 3D?</h2>

        <div class="row g-3">
            <div class="col-6 col-md-3">
                <div class="feature-box">
                    <div>⚡</div>
                    Fast Turnaround
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="feature-box">
                    <div>🎯</div>
                    Precision Printing
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="feature-box">
                    <div>💡</div>
                    Design Support
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="feature-box">
                    <div>📞</div>
                    24/7 Support
                </div>
            </div>
        </div>
    </div>
</section>


<section class="lab-section py-5 fade-in">

    <div class="container text-center">
        <h2 class="fw-bold mb-2">3D Print Showcase</h2>
        <p class="text-muted mb-5">
            Precision-crafted models brought to life
        </p>

        <div class="lab-grid">

            <!-- BIG CENTER ITEM -->
            <div class="lab-item big">
                <img src="https://makerworld.bblmw.com/makerworld/model/US785629d640df37/design/2025-11-18_fc807149f6f17.webp?x-oss-process=image/resize,w_1000/format,webp">
                <div class="lab-overlay">
                    <h5>Dragon Masterpiece</h5>
                </div>
            </div>

            <!-- SMALL ITEMS -->
            <div class="lab-item">
                <img src="https://makerworld.bblmw.com/makerworld/model/US2bcdfcd556d945/design/2024-01-08_e7cb2c5edc4fa8.jpeg?x-oss-process=image/resize,w_1000/format,webp">
            </div>

            <div class="lab-item">
                <img src="https://makerworld.bblmw.com/makerworld/model/USe1c9fcb2ca73e1/design/2024-08-13_e879dacdf6e89.jpg">
            </div>

            <div class="lab-item">
                <img src="https://makerworld.bblmw.com/makerworld/model/1212806/comment/317cb100-03d8-11f0-b06e-975637e7b92e.jpg">
            </div>

            <div class="lab-item">
                <img src="https://makerworld.bblmw.com/makerworld/model/USe1c9fcb2ca73e1/design/2024-08-13_e879dacdf6e89.jpg">
            </div>

        </div>
    </div>

</section>

<!-- =========================
 FEATURED PRODUCTS
========================= -->

<section class="bg-light py-5 fade-in">

<div class="container">
        
    <h2 class="text-center fw-bold mb-5">Featured Products</h2>

    <div class="row">
        @foreach(\App\Models\Product::latest()->take(6)->get() as $product)

        <div class="col-6 col-md-4 mb-4">
            
            <a href="/product/{{ $product->id }}" class="text-decoration-none">

            <div class="premium-card">

                <!-- IMAGE -->
                <div class="premium-img">
                    <img src="/product_images/{{ $product->image }}" />
                    
                    <!-- Sale Badge -->
                    <span class="badge-sale">Sale</span>
                </div>

                <!-- CONTENT -->
                <div class="premium-content">

                    <!-- Product Name -->
                    <h6 class="product-title">
                        {{ $product->name }}
                    </h6>

                    <!-- Rating -->
                    <div class="rating">
                        ⭐⭐⭐⭐⭐ <span>(2)</span>
                    </div>

                    <!-- Price -->
                    <div class="price">
                        <span class="old">₹{{ $product->price + 200 }}</span>
                        <span class="new">₹{{ $product->price }}</span>
                    </div>

                </div>

            </div>
            </a>

        </div>

        @endforeach
    </div>
    
</div>



    <!-- <div class="container">
        
        <h2 class="text-center fw-bold mb-5">Featured Products</h2>

        <div class="row">
            @foreach(\App\Models\Product::latest()->take(6)->get() as $product)

            <div class="col-6 col-md-4 mb-3">
                
                <a href="/product/{{ $product->id }}">

                <div class="card product-card h-100 shadow-sm">
                    <img
                        src="/product_images/{{ $product->image }}"
                        class="card-img-top featured-img"
                    />

                    <div class="card-body text-center d-flex flex-column">
                        <p class="text-warning mb-1">
                            ⭐⭐⭐⭐☆ (4.5)
                        </p>
                        <h5 class="fw-bold">{{ $product->name }}</h5>

                        <p class="fw-bold text-success">
                            ₹{{ $product->price }}
                        </p>

                        <div class="mt-auto">
                            View Product
                        </div>
                    </div>
                </div></a>
            </div>
            @endforeach
        </div>
        
    </div> -->
    
</section>

<!-- =========================
 SERVICES
========================= -->

<section class="py-5 fade-in">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Our 3D Printing Services</h2>

        <div class="row text-center">
            <div class="col-6 col-md-4 mb-3">
                <div class="card shadow-sm p-4 h-100">
                    <h4>🧊 Custom 3D Printing</h4>
                    <p>
                        Create personalized models, tools and parts with
                        advanced 3D printers.
                    </p>
                </div>
            </div>

            <div class="col-6 col-md-4 mb-3">
                <div class="card shadow-sm p-4 h-100">
                    <h4>⚙️ Prototype Development</h4>
                    <p>Fast prototyping for engineers and startups.</p>
                </div>
            </div>

            <div class="col-6 col-md-4 mb-3">
                <div class="card shadow-sm p-4 h-100">
                    <h4>🎨 3D Design Services</h4>
                    <p>
                        We help optimize your models for high quality printing.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- =========================
 HERO SLIDER
========================= -->

<div
    id="heroCarousel"
    class="carousel slide mt-5 fade-in"
    data-bs-ride="carousel"
>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img
                src="https://images.unsplash.com/photo-1650288619836-ae092ba88d31?q=80&w=1170&auto=format&fit=crop"
                class="d-block w-100"
                style="height: 500px; object-fit: cover"
            />
            <div class="carousel-caption">
                <h1 class="fw-bold">Bring Your Ideas to Life</h1>
                <p>High quality custom 3D printing solutions</p>
            </div>
        </div>

        <div class="carousel-item">
            <img
                src="https://images.unsplash.com/photo-1728724569841-05305ee197df?q=80&w=1332&auto=format&fit=crop"
                class="d-block w-100"
                style="height: 500px; object-fit: cover"
            />
            <div class="carousel-caption">
                <h1 class="fw-bold">Precision 3D Printing</h1>
                <p>Professional prototypes and products</p>
            </div>
        </div>

        <div class="carousel-item">
            <img
                src="https://images.unsplash.com/photo-1707735325033-af8b8ad6a01f?q=80&w=1333&auto=format&fit=crop"
                class="d-block w-100"
                style="height: 500px; object-fit: cover"
            />
            <div class="carousel-caption">
                <h1 class="fw-bold">Custom 3D Designs</h1>
                <p>Create anything you imagine</p>
            </div>
        </div>
    </div>

    <button
        class="carousel-control-prev"
        type="button"
        data-bs-target="#heroCarousel"
        data-bs-slide="prev"
    >
        <span class="carousel-control-prev-icon"></span>
    </button>

    <button
        class="carousel-control-next"
        type="button"
        data-bs-target="#heroCarousel"
        data-bs-slide="next"
    >
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<!-- =========================
 HOW IT WORKS
========================= -->

<section class="process-section py-5 fade-in">
    <div class="container text-center">

        <h2 class="fw-bold mb-2">How 3D Printing Works</h2>
        <p class="text-muted mb-5">From idea to real-world object</p>

        <div class="process-line">

            <!-- STEP 1 -->
            <div class="process-step">
                <div class="circle">1</div>
                <h6>Create Design</h6>
            </div>

            <!-- STEP 2 -->
            <div class="process-step">
                <div class="circle">2</div>
                <h6>Upload Model</h6>
            </div>

            <!-- STEP 3 -->
            <div class="process-step">
                <div class="circle">3</div>
                <h6>3D Printing</h6>
            </div>

            <!-- STEP 4 -->
            <div class="process-step">
                <div class="circle">4</div>
                <h6>Delivery</h6>
            </div>

        </div>

    </div>
</section>

<!-- =========================
 TESTIMONIALS
========================= -->

<section class="py-5 fade-in">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Customer Reviews</h2>

        <div class="row">
            <div class="col-12 col-md-4 mb-3">
                <div class="card p-4 shadow-sm text-center">
                    <p>"Amazing quality prints and fast delivery."</p>
                    <strong>⭐⭐⭐⭐⭐</strong><br />
                    <strong>Rahul Sharma</strong>
                </div>
            </div>

            <div class="col-12 col-md-4 mb-3">
                <div class="card p-4 shadow-sm text-center">
                    <p>"Great service for custom prototypes."</p>
                    <strong>⭐⭐⭐⭐⭐</strong><br />
                    <strong>Priya Patel</strong>
                </div>
            </div>

            <div class="col-12 col-md-4 mb-3">
                <div class="card p-4 shadow-sm text-center">
                    <p>"Best 3D printing service I have used."</p>
                    <strong>⭐⭐⭐⭐⭐</strong><br />
                    <strong>Amit Verma</strong>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 fade-in">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">FAQs</h2>

        <div class="accordion" id="faq">
            <div class="accordion-item">
                <button
                    class="accordion-button"
                    data-bs-toggle="collapse"
                    data-bs-target="#q1"
                >
                    How long does printing take?
                </button>
                <div id="q1" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        Usually 1–3 days depending on size.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <button
                    class="accordion-button collapsed"
                    data-bs-toggle="collapse"
                    data-bs-target="#q2"
                >
                    What file formats do you accept?
                </button>
                <div id="q2" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        STL, OBJ, STEP files supported.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- CTA -->

<section class="py-5 text-center bg-dark text-white">
    <div class="container">
        <h2 class="fw-bold">Ready to Print Your Idea?</h2>

        <p class="mb-4">
            Upload your model or explore ready-made designs crafted for you.
        </p>

        <a href="/products" class="btn btn-primary btn-lg me-2">
            Browse Products
        </a>

        <a href="https://wa.me/your-number" class="btn btn-success btn-lg">
            Chat on WhatsApp
        </a>
    </div>
</section>

<script>
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add("show");
            }
        });
    });

    document.querySelectorAll(".fade-in").forEach((el) => {
        observer.observe(el);
    });
</script>

@endsection
