@extends('layouts.app') @section('content')

<style>
    /* =========================
 HERO SECTION (RESTORED STRONG LOOK)
========================= */

    .products-hero {
        background:
            linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
            url("https://images.pexels.com/photos/30415869/pexels-photo-30415869.jpeg");
        background-size: cover;
        background-position: center;
        height: 420px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-align: center;
    }

    .products-hero h1 {
        font-size: 40px;
    }

    .products-hero p {
        opacity: 0.9;
    }

    /* =========================

/* =========================
 PRODUCT GRID
========================= */

    /* Desktop */
    @media (min-width: 992px) {
        /* .product-item{ width: 33.33%; } */
        .product-item {
            width: 25%;
        }
    }

    /* Tablet */
    @media (max-width: 991px) {
        .product-item {
            width: 50%;
        }
    }

    /* Mobile */
    @media (max-width: 576px) {
        .product-item {
            width: 100%;
        }
    }

    /* =========================
 BADGES
========================= */

    .badge-new {
        position: absolute;
        top: 12px;
        left: 12px;
        background: #ff3b3b;
        color: white;
        font-size: 11px;
        padding: 4px 8px;
        border-radius: 5px;
    }

    .wishlist {
        position: absolute;
        top: 12px;
        right: 12px;
        background: white;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    .wishlist.active {
        background: #ff3b3b;
        color: white;
    }
    /* =========================
FLY TO CART ANIMATION
========================= */

    .fly-img {
        position: fixed;
        z-index: 9999;
        width: 80px;
        height: 80px;
        object-fit: contain;
        pointer-events: none;
        transition: all 0.8s ease-in-out;
    }



    /* =========================
 HERO RESPONSIVE
========================= */

    @media (max-width: 768px) {
        .products-hero {
            height: 300px;
            padding: 20px;
        }

        .products-hero h1 {
            font-size: 26px;
        }
    }

    /* =========================
 MOBILE FINAL POLISH
========================= */

    @media (max-width: 576px) {
        .product-img {
            height: 200px;
        }

        .product-title {
            font-size: 14px;
        }

        .product-price {
            font-size: 16px;
        }
    }
    /* ---------------------- */
    /* ---------------------- */
    /* Dark minimal bar */
    /* BAR */
    .filter-top {
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
    }

    /* LABEL */
    .filter-label {
        color: #888;
        font-size: 14px;
    }

    /* BUTTON */
    .filter-btn {
        background: transparent;
        border: 1px solid transparent;
        padding: 6px 12px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
    }

    /* ACTIVE */
    .filter-dropdown.active .filter-btn {
        border: 1px solid #888;
    }

    /* DROPDOWN */
    .filter-dropdown {
        position: relative;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        top: 110%;
        left: 0;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 6px;
        min-width: 150px;
        z-index: 100;
    }

    .dropdown-menu div {
        padding: 8px 12px;
        cursor: pointer;
    }

    .dropdown-menu div:hover {
        background: #f5f5f5;
    }

    /* SHOW */
    .filter-dropdown.open .dropdown-menu {
        display: block;
    }

    /* CHIPS */
    .active-filters {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .filter-chip {
        background: #eee;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        cursor: pointer;
    }

    /* CLEAR BUTTON */
    .clear-btn {
        background: none;
        border: none;
        color: #888;
        cursor: pointer;
    }

    .clear-btn:hover {
        color: #000;
    }

    /* RIGHT SIDE */
    .product-count {
        color: #888;
    }

    /* HOVER ANIMATION */
    .filter-btn:hover {
        transform: translateY(-1px);
    }
    .sort-box {
        position: relative;
    }

    .sort-box .dropdown-menu {
        right: 0;
        left: auto;
    }
    /* ---------------------- */
    /* ---------------------- */
    /* CARD */
    .premium-card {
        width: 100%;
        /* background: #111; */
        border-radius: 15px;
        overflow: hidden;
        transition: 0.4s;
        border: 1px solid #222;
        flex-direction: column;
        /* border:5px solid red; */
    }

    .premium-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6);
    }

    /* IMAGE */
    .premium-img {
        /* border:5px solid green; */
        position: relative;
        /* width: 400px; */
        height: 280px;
        overflow: hidden;
    }
        /* =========================
 CARD BODY FIX
========================= */

    .card-body {
        /* width: 100; */
        /* height: 00px; */
        padding: 10px;
        /* display: flex; */
        flex-direction: column;
        justify-content: space-between;
        /* border:4px solid red; */
    }

    .premium-img img {
        width: 100%;
        height: 100%;
        object-fit:cover;
        /* object-position:  center; */
        transition: 0.4s;
    }

    .premium-card:hover img {
        transform: scale(1.07);
    }


    /* TITLE */
    .product-title {
        font-weight: 600;
        font-size: 18px;
        margin-top: 5px;
    }
    /* PRICE */
    .price {
        /* display: flex; */
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
        /* color: #fff; */
    }
    .name-rateing {
        /* border:5px solid red; */
        /* display: flex; */
        /* justify-content: space-between; */
    }

    /* PRICE */
    .product-price {
        font-weight: bold;
        font-size: 20px;
        /* color: #0d6efd; */
        margin-top: 0px;
    }

    /* RATING */
    .rating {
        color: gold;
        font-size: 18px;
        margin: 0;
    }

    /* BADGE */
    .badge-new {
        position: absolute;
        top: 10px;
        left: 10px;
        background: red;
        color: #fff;
        padding: 3px 7px;
        font-size: 11px;
        border-radius: 5px;
        z-index: 2;
    }

    /* WISHLIST */
    .wishlist {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #fff;
        border-radius: 50%;
        padding: 5px 8px;
        cursor: pointer;
    }

    /* QUICK VIEW BUTTON */
    .quick-view-btn {
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
        background: #000;
        color: #fff;
        border: none;
        padding: 6px 12px;
        font-size: 12px;
        border-radius: 6px;
        opacity: 0;
        transition: 0.3s;
    }
    .thumb-small{
    width:60px;
    height:60px;
    object-fit:contain;
    border-radius:6px;
    cursor:pointer;
    border:2px solid transparent;
    background:#f8f9fa;
    padding:4px;
    transition:0.2s;
}

.thumb-small:hover{
    border-color:black;
    transform:scale(1.05);
}
/* MODAL */
.quick-modal-md{
    border-radius:14px;
    box-shadow:0 15px 40px rgba(0,0,0,0.2);
}

/* CLOSE */
.custom-close{
    position:absolute;
    top:12px;
    right:15px;
    z-index:10;
}

/* IMAGE */
.main-img-md{
    height:260px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#f8f9fa;
    border-radius:10px;
}

.main-img-md img{
    max-height:100%;
    max-width:100%;
    object-fit:contain;
}

/* THUMB */
.thumb-row-md{
    display:flex;
    gap:8px;
    justify-content:center;
}

.thumb-row-md img{
    width:55px;
    height:55px;
    object-fit:contain;
    background:#f8f9fa;
    border-radius:6px;
    padding:4px;
    cursor:pointer;
    transition:0.2s;
}

.thumb-row-md img:hover{
    transform:scale(1.08);
}

/* TEXT */
.price-md{
    font-size:20px;
    font-weight:bold;
    color:#0d6efd;
}

.desc-md{
    font-size:14px;
    color:#555;
}

.delivery-md{
    background:#f1f3f5;
    padding:8px;
    border-radius:6px;
    font-size:13px;
}

/* RELATED */
.related-md{
    border:1px solid #eee;
    border-radius:8px;
    padding:5px;
    cursor:pointer;
    transition:0.2s;
}

.related-md img{
    width:100%;
    height:80px;
    object-fit:cover;
    border-radius:6px;
}

.related-md:hover{
    transform:translateY(-3px);
    box-shadow:0 8px 15px rgba(0,0,0,0.1);
}
    .premium-card:hover .quick-view-btn {
        opacity: 1;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .premium-img {
            height: 170px;
        }
    }
    /* ---------------------- */
    /* ---------------------- */
</style>

<!-- HERO -->

<section class="products-hero">
    <div>
        <h1 class="display-5 fw-bold">Our 3D Printed Products</h1>
        <p class="lead">
            Explore unique creations made with advanced 3D printing
        </p>
    </div>
</section>

<!-- FILTERS -->
<div class="container my-4">
    <!-- FILTER BAR -->
    <div
        class="filter-top d-flex justify-content-between align-items-center flex-wrap gap-3"
    >
        <!-- LEFT -->
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <span class="filter-label">Filter:</span>

            <!-- CATEGORY -->
            <div class="filter-dropdown" data-name="Category">
                <button class="filter-btn">Category ▾</button>
                <div class="dropdown-menu">
                    <div data-value="all">All</div>
                    <div data-value="tools">3D Tools</div>
                    <div data-value="decor">Home Decor</div>
                    <div data-value="keychain">Keychains</div>
                    <div data-value="gifting">Gifting</div>
                    <div data-value="action figure">Action figure</div>
                </div>
            </div>

            <!-- PRICE SORT -->
            <div class="filter-dropdown" data-name="priceRange">
                <button class="filter-btn">Price Range ▾</button>
                <div class="dropdown-menu p-3">
                    <input type="range" min="0" max="10000" id="priceRange" />
                    <div>₹0 - ₹<span id="priceValue">10000</span></div>
                </div>
            </div>

            <!-- CLEAR -->
            <button id="clearFilters" class="clear-btn">Clear</button>
        </div>

        <!-- RIGHT -->
        <div class="d-flex align-items-center gap-4">
            <div class="sort-box filter-dropdown" data-name="sort">
                <button class="filter-btn">Sort by ▾</button>
                <div class="dropdown-menu">
                    <div data-value="az">A-Z</div>
                    <div data-value="za">Z-A</div>
                    <div data-value="low">Price: Low → High</div>
                    <div data-value="high">Price: High → Low</div>
                </div>
            </div>

            <span class="product-count" id="productCount">
                {{ count($products ?? []) }} products
            </span>
        </div>
    </div>

    <!-- ACTIVE FILTER CHIPS -->
    <div class="active-filters mt-2" id="activeFilters"></div>
</div>

<!-- FILTERS -->

<!-- PRODUCTS -->
<!-- PRODUCTS -->
<!-- PRODUCTS -->
<!-- PRODUCTS -->

<div class="container  mt-5">
    <div class="row" id="productGrid">
        @foreach($products as $product)

        <div
            class="col-6 col-md-4 col-lg-4 mb-4 product-item"
            data-name="{{ strtolower($product->name) }}"
            data-category="{{ strtolower($product->category ?? 'general') }}"
            data-price="{{ $product->price }}"
        >
            <div class="premium-card product-card h-100">
                <!-- BADGE -->
                <span class="badge-new">NEW</span>

                <!-- IMAGE -->
                <div class="premium-img">
                    <a href="/product/{{ $product->id }}">
                        <img src="/product_images/{{ $product->image }}" />
                    </a>

                    <!-- WISHLIST -->
                    <div class="wishlist wishlistBtn" data-id="{{ $product->id }}">
                        <i class="bi bi-heart"></i>
                    </div>

                    <!-- QUICK VIEW BUTTON -->
                    <button
                        class="quick-view-btn"
                        data-bs-toggle="modal"
                        data-bs-target="#productModal{{ $product->id }}"
                    >
                        Quick View
                    </button>
                </div>

                <!-- BODY -->
                <div class="card-body text d-flex flex-column">
                    <div class="name-rateing">
                        <div class="product-title">{{ $product->name }}</div>

                        <!-- RATING -->
                        <div class="rating">
                            @for($i=1;$i<=5;$i++) @if($i <= ($product->rating ??
                            4)) ★ @else ☆ @endif @endfor
                        </div>
                    </div>

                    <div class="mt-auto">
                        <div class="product-price">
                            <div class="price">
                                <span class="old"
                                    >₹{{ $product->price + 200 }}</span
                                >
                                <span class="new">₹{{ $product->price }}</span>
                            </div>
                        </div>

                        <!-- STOCK -->
                        @if(isset($product->stock))
                        <p class="text-danger small mb-1">
                            Only {{ $product->stock }} left!
                        </p>
                        @endif

                        <!-- BUTTONS -->
                        <div class="gap-2 d-flex">
                            <a
                                href="/product/{{ $product->id }}"
                                class="btn btn-dark w-100"
                            >
                                View Details
                            </a>
                            <button
                                class="btn btn-success addToCart"
                                data-id="{{ $product->id }}"
                            >
                            <i class="bi bi-cart"></i>
                                <!-- Add to Cart -->
                            </button>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- QUICK VIEW MODAL -->

        <div class="modal fade" id="productModal{{ $product->id }}">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content quick-modal-md">

            <!-- CLOSE -->
            <button type="button" class="btn-close custom-close" data-bs-dismiss="modal"></button>

            <div class="modal-body p-4">

                <div class="row g-4">

                    <!-- ================= IMAGE ================= -->
                    <div class="col-md-5">

                        @php
                            $images = collect([$product->image]);
                            if($product->images){
                                foreach($product->images as $img){
                                    if($img->image != $product->image){
                                        $images->push($img->image);
                                    }
                                }
                            }
                        @endphp

                        <!-- MAIN -->
                        <div class="main-img-md">
                            <img id="modalMainImg{{ $product->id }}"
                                 src="/product_images/{{ $product->image }}">
                        </div>

                        <!-- THUMB -->
                        <div class="thumb-row-md mt-3">
                            @foreach($images->take(4) as $img)
                                <img src="/product_images/{{ $img }}"
                                     onclick="changeModalImage('{{ $product->id }}', '/product_images/{{ $img }}')">
                            @endforeach
                        </div>

                    </div>


                    <!-- ================= DETAILS ================= -->
                    <div class="col-md-7">

                        <h4 class="fw-bold mb-2">
                            {{ $product->name }}
                        </h4>

                        <span class="badge bg-light text-dark border mb-2 px-2 py-1">
                            {{ $product->category ?? 'General' }}
                        </span>

                        <div class="price-md mb-2">
                            ₹{{ $product->price }}
                        </div>

                        <p class="desc-md">
                            {{ Str::limit($product->description, 100) }}
                        </p>

                        <div class="delivery-md mb-3">
                            🚚 Delivery in 2–4 days
                        </div>

                        <!-- BUTTONS -->
                        <div class="d-flex gap-2">
                            <button class="btn btn-success flex-fill addToCart"
                                    data-id="{{ $product->id }}">
                                🛒 Add to Cart
                            </button>

                            <a href="/product/{{ $product->id }}"
                               class="btn btn-outline-dark flex-fill">
                                View
                            </a>
                        </div>

                    </div>

                </div>

                <!-- ================= RELATED ================= -->
                @php
                    $related = \App\Models\Product::where('category', $product->category)
                        ->where('id', '!=', $product->id)
                        ->take(4)
                        ->get();
                @endphp

                @if($related->count())
                <div class="mt-4">

                    <h6 class="fw-bold mb-3">Similar Products</h6>

                    <div class="row g-2">

                        @foreach($related as $item)
                        <div class="col-3">
                            <div class="related-md"
                                 onclick="window.location='/product/{{ $item->id }}'">

                                <img src="/product_images/{{ $item->image }}">

                                <small class="d-block text-center">
                                    ₹{{ $item->price }}
                                </small>

                            </div>
                        </div>
                        @endforeach

                    </div>

                </div>
                @endif

            </div>
        </div>
    </div>
</div>

        @endforeach
    </div>

    <!-- PAGINATION -->
    <div class="d-flex justify-content-center mt-4">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- CUSTOM PRINT SECTION -->

<section class="custom-print">
    <div class="container text-center">
        <h2 class="fw-bold mb-3">Need a Custom 3D Print?</h2>

        <p class="mb-4">Upload your STL model and we will print it for you.</p>

        <form
            action="/upload-model"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            <div class="row justify-content-center">
                <div class="col-md-4">
                    <input type="file" name="model" class="form-control" />
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary w-100">Upload</button>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
    /* FILTER SYSTEM */

    let filters = {
        category: null,
        price: null,
        sort: null,
    };

    // TOGGLE DROPDOWN
    document.querySelectorAll(".filter-btn").forEach((btn) => {
        btn.addEventListener("click", function () {
            this.parentElement.classList.toggle("open");
        });
    });

    // SELECT VALUE
    document.querySelectorAll(".dropdown-menu div").forEach((item) => {
        item.addEventListener("click", function () {
            let parent = this.closest(".filter-dropdown");
            let type = parent.dataset.name.toLowerCase();
            let value = this.dataset.value;

            filters[type] = value;

            parent.classList.add("active");
            parent.querySelector(".filter-btn").innerText =
                this.innerText + " ▾";

            parent.classList.remove("open");

            updateChips();
            applyFilters(); // 🔥 IMPORTANT
        });
    });

    // APPLY FILTER LOGIC
    function applyFilters() {
        let products = document.querySelectorAll(".product-item");
        let visibleCount = 0;

        products.forEach((product) => {
            let category = product.dataset.category;
            let price = parseFloat(product.dataset.price);

            let show = true;

            // CATEGORY FILTER
            if (filters.category && filters.category !== "all") {
                if (category !== filters.category) {
                    show = false;
                }
            }

            // SHOW / HIDE
            product.style.display = show ? "block" : "none";

            if (show) visibleCount++;
        });

        // PRICE SORT
        if (filters.price) {
            let grid = document.getElementById("productGrid");
            let items = Array.from(products).filter(
                (p) => p.style.display !== "none",
            );

            items.sort((a, b) => {
                let priceA = parseFloat(a.dataset.price);
                let priceB = parseFloat(b.dataset.price);

                return filters.price === "low"
                    ? priceA - priceB
                    : priceB - priceA;
            });

            items.forEach((p) => grid.appendChild(p));
        }
        // SORTING (CATEGORY + SORT COMBINED)
        let grid = document.getElementById("productGrid");
        let items = Array.from(
            document.querySelectorAll(".product-item"),
        ).filter((p) => p.style.display !== "none");

        if (filters.sort) {
            if (filters.sort === "az") {
                items.sort((a, b) =>
                    a.dataset.name.localeCompare(b.dataset.name),
                );
            }

            if (filters.sort === "za") {
                items.sort((a, b) =>
                    b.dataset.name.localeCompare(a.dataset.name),
                );
            }

            if (filters.sort === "low") {
                items.sort(
                    (a, b) =>
                        parseFloat(a.dataset.price) -
                        parseFloat(b.dataset.price),
                );
            }

            if (filters.sort === "high") {
                items.sort(
                    (a, b) =>
                        parseFloat(b.dataset.price) -
                        parseFloat(a.dataset.price),
                );
            }

            items.forEach((p) => grid.appendChild(p));
        }

        // UPDATE COUNT
        document.getElementById("productCount").innerText =
            visibleCount + " products";
    }
    function changeModalImage(productId, src){
    document.getElementById('modalMainImg' + productId).src = src;
}

    // UPDATE CHIPS
    function updateChips() {
        let container = document.getElementById("activeFilters");
        container.innerHTML = "";

        for (let key in filters) {
            if (filters[key]) {
                let chip = document.createElement("div");
                chip.className = "filter-chip";
                chip.innerText = key + ": " + filters[key] + " ✕";

                chip.onclick = () => {
                    filters[key] = null;
                    updateChips();
                    applyFilters(); // 🔥 IMPORTANT
                };

                container.appendChild(chip);
            }
        }
    }

    // CLEAR FILTERS
    document.getElementById("clearFilters").addEventListener("click", () => {
        filters = { category: null, price: null };

        document.querySelectorAll(".filter-btn").forEach((btn) => {
            btn.innerText = btn.parentElement.dataset.name + " ▾";
        });

        document.querySelectorAll(".filter-dropdown").forEach((d) => {
            d.classList.remove("active");
        });

        updateChips();
        applyFilters(); // 🔥 IMPORTANT
    });

    document.querySelectorAll(".addToCart").forEach((btn) => {
        btn.addEventListener("click", function (e) {
            let card = this.closest(".product-card");
            let img = card.querySelector("img");
            let cart = document
                .querySelector(".bi-cart")
                .getBoundingClientRect();

            let imgRect = img.getBoundingClientRect();

            let flyingImg = img.cloneNode();
            flyingImg.classList.add("fly-img");

            flyingImg.style.top = imgRect.top + "px";
            flyingImg.style.left = imgRect.left + "px";

            document.body.appendChild(flyingImg);

            setTimeout(() => {
                flyingImg.style.top = cart.top + "px";
                flyingImg.style.left = cart.left + "px";
                flyingImg.style.width = "20px";
                flyingImg.style.opacity = "0.5";
            }, 10);

            setTimeout(() => {
                flyingImg.remove();
            }, 800);
        });
    });

    document.querySelectorAll('.wishlistBtn').forEach(btn => {

    btn.addEventListener('click', function(){

        let id = this.dataset.id;

        fetch('/wishlist/toggle/' + id, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(res => res.json())
        .then(data => {

            if(data.status === 'added'){
                this.innerHTML = '💖';
            } 
        });

    });

});
</script>

@endsection
