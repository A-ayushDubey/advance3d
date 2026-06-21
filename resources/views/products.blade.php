@extends('layouts.app') @section('content')

<style>
    /* =====================================================
       AD-VANCE 3D — PRODUCTS PAGE
       modern / minimal restyle
       Tokens reused from layout.blade.php; fallbacks included.
    ===================================================== */

    /* =========================
       HERO
    ========================= */

    .products-hero {
        background:
            linear-gradient(rgba(15, 15, 15, 0.55), rgba(15, 15, 15, 0.78)),
            url("https://images.pexels.com/photos/30415869/pexels-photo-30415869.jpeg");
        background-size: cover;
        background-position: center;
        height: 360px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        text-align: center;
    }

    .products-hero h1 {
        font-family: var(--font-display, sans-serif);
        font-weight: 600;
        font-size: 36px;
        letter-spacing: -0.01em;
    }

    .products-hero p {
        opacity: 0.85;
        font-size: 15px;
        color: #D8D6CF;
    }

    @media (max-width: 768px) {
        .products-hero {
            height: 280px;
            padding: 20px;
        }
        .products-hero h1 {
            font-size: 24px;
        }
    }

    /* =========================
       PRODUCT GRID WIDTHS (unchanged logic)
    ========================= */

    @media (min-width: 992px) {
        .product-item { width: 25%; }
    }
    @media (max-width: 991px) {
        .product-item { width: 50%; }
    }
    @media (max-width: 576px) {
        .product-item { width: 100%; }
    }

    /* =========================
       FILTER BAR
    ========================= */

    .filter-top {
        border-bottom: 1px solid var(--hairline, #E8E6E0);
        padding-bottom: 14px;
    }

    .filter-label {
        color: var(--ink-soft, #6B6B65);
        font-size: 13.5px;
        font-weight: 500;
    }

    .filter-btn {
        background: transparent;
        border: 1px solid var(--hairline, #E8E6E0);
        color: var(--ink, #1A1A1A);
        padding: 7px 14px;
        border-radius: 3px;
        cursor: pointer;
        font-size: 13.5px;
        font-weight: 500;
        transition: border-color 0.2s ease, transform 0.15s ease;
    }
    .filter-btn:hover {
        border-color: var(--accent, #FF5A1F);
        transform: translateY(-1px);
    }

    .filter-dropdown.active .filter-btn {
        border-color: var(--ink, #1A1A1A);
        background: var(--ink, #1A1A1A);
        color: var(--bg, #FAFAF8);
    }

    .filter-dropdown {
        position: relative;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        top: 110%;
        left: 0;
        background: var(--bg-raised, #fff);
        border: 1px solid var(--hairline, #E8E6E0);
        border-radius: 3px;
        min-width: 160px;
        z-index: 100;
        box-shadow: 0 16px 36px rgba(0,0,0,0.08);
    }

    .dropdown-menu div {
        padding: 9px 14px;
        cursor: pointer;
        font-size: 13.5px;
        color: var(--ink, #1A1A1A);
        transition: background 0.15s ease;
    }

    .dropdown-menu div:hover {
        background: var(--accent-50, #FFF1EA);
    }

    .filter-dropdown.open .dropdown-menu {
        display: block;
    }

    .active-filters {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .filter-chip {
        background: var(--accent-50, #FFF1EA);
        color: var(--accent-ink, #7A2B0E);
        border: 1px solid transparent;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        transition: 0.15s ease;
    }
    .filter-chip:hover {
        border-color: var(--accent, #FF5A1F);
    }

    .clear-btn {
        background: none;
        border: none;
        color: var(--ink-soft, #6B6B65);
        cursor: pointer;
        font-size: 13.5px;
        font-weight: 500;
        transition: color 0.15s ease;
    }
    .clear-btn:hover {
        color: var(--accent, #FF5A1F);
    }

    .product-count {
        color: var(--ink-soft, #6B6B65);
        font-family: var(--font-mono, monospace);
        font-size: 12.5px;
    }

    .sort-box {
        position: relative;
    }
    .sort-box .dropdown-menu {
        right: 0;
        left: auto;
    }

    /* dark mode for filter bar */
    body.dark-mode .filter-top { border-bottom-color: var(--hairline-dark, #2C2C29); }
    body.dark-mode .filter-label { color: var(--ink-soft-dark, #9B9A92); }
    body.dark-mode .filter-btn { border-color: var(--hairline-dark, #2C2C29); color: var(--ink-dark, #F2F1ED); }
    body.dark-mode .filter-dropdown.active .filter-btn { background: var(--ink-dark, #F2F1ED); color: var(--bg-dark, #0F0F0F); border-color: var(--ink-dark, #F2F1ED); }
    body.dark-mode .dropdown-menu { background: var(--bg-raised-dark, #1A1A19); border-color: var(--hairline-dark, #2C2C29); }
    body.dark-mode .dropdown-menu div { color: var(--ink-dark, #F2F1ED); }
    body.dark-mode .dropdown-menu div:hover { background: var(--accent-50-dark, #2A1A12); }
    body.dark-mode .product-count { color: var(--ink-soft-dark, #9B9A92); }
    body.dark-mode .clear-btn { color: var(--ink-soft-dark, #9B9A92); }

    /* =========================
       BADGES / WISHLIST
    ========================= */

    .badge-new {
        position: absolute;
        top: 12px;
        left: 12px;
        background: var(--ink, #1A1A1A);
        color: var(--bg, #FAFAF8);
        font-family: var(--font-mono, monospace);
        font-size: 10px;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        padding: 4px 9px;
        border-radius: 2px;
        z-index: 2;
    }

    .wishlist {
        position: absolute;
        top: 12px;
        right: 12px;
        background: var(--bg-raised, #fff);
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: 1px solid var(--hairline, #E8E6E0);
        color: var(--ink, #1A1A1A);
        transition: 0.2s ease;
        z-index: 2;
    }
    .wishlist:hover {
        border-color: var(--accent, #FF5A1F);
        color: var(--accent, #FF5A1F);
    }
    .wishlist.active {
        background: var(--accent, #FF5A1F);
        border-color: var(--accent, #FF5A1F);
        color: white;
    }

    /* =========================
       FLY TO CART ANIMATION (unchanged logic)
    ========================= */

    .fly-img {
        position: fixed;
        z-index: 9999;
        width: 80px;
        height: 80px;
        object-fit: contain;
        pointer-events: none;
        transition: all 0.8s ease-in-out;
        border-radius: 4px;
    }

    /* =========================
       PRODUCT CARD
    ========================= */

    .premium-card {
        width: 100%;
        background: var(--bg-raised, #fff);
        border-radius: 6px;
        overflow: hidden;
        transition: 0.3s ease;
        border: 1px solid var(--hairline, #E8E6E0);
        flex-direction: column;
        position: relative;
    }

    .premium-card:hover {
        transform: translateY(-6px);
        border-color: var(--accent, #FF5A1F);
        box-shadow: 0 20px 44px rgba(0,0,0,0.08);
    }

    .premium-img {
        position: relative;
        height: 240px;
        overflow: hidden;
        background: var(--accent-50, #FFF1EA);
    }

    .premium-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: 0.4s;
    }

    .premium-card:hover img {
        transform: scale(1.06);
    }

    body.dark-mode .premium-card {
        background: var(--bg-raised-dark, #1A1A19);
        border-color: var(--hairline-dark, #2C2C29);
    }
    body.dark-mode .premium-img {
        background: var(--accent-50-dark, #2A1A12);
    }
    body.dark-mode .badge-new {
        background: var(--ink-dark, #F2F1ED);
        color: var(--bg-dark, #0F0F0F);
    }
    body.dark-mode .wishlist {
        background: var(--bg-raised-dark, #1A1A19);
        border-color: var(--hairline-dark, #2C2C29);
        color: var(--ink-dark, #F2F1ED);
    }

    /* =========================
       CARD BODY
    ========================= */

    .card-body {
        padding: 16px;
        flex-direction: column;
        justify-content: space-between;
    }

    .product-title {
        font-weight: 600;
        font-size: 15px;
        margin-top: 2px;
        color: var(--ink, #1A1A1A);
        font-family: var(--font-body, sans-serif);
    }
    body.dark-mode .product-title {
        color: var(--ink-dark, #F2F1ED);
    }

    .price {
        gap: 10px;
        align-items: center;
        font-family: var(--font-mono, monospace);
    }

    .price .old {
        text-decoration: line-through;
        color: var(--ink-soft, #6B6B65);
        font-size: 13px;
    }

    .price .new {
        font-size: 17px;
        font-weight: 500;
        color: var(--ink, #1A1A1A);
    }
    body.dark-mode .price .new {
        color: var(--ink-dark, #F2F1ED);
    }

    .product-price {
        font-weight: 500;
        font-size: 17px;
        margin-top: 6px;
    }

    /* RATING — gold kept deliberately (stars read better in their
       conventional color; swapping to ink/accent reduces legibility
       of "this is a rating" at a glance) */
    .rating {
        color: #D9A441;
        font-size: 15px;
        margin: 4px 0 0;
    }

    /* QUICK VIEW BUTTON */
    .quick-view-btn {
        position: absolute;
        bottom: 12px;
        left: 50%;
        transform: translateX(-50%);
        background: var(--ink, #1A1A1A);
        color: var(--bg, #FAFAF8);
        border: none;
        padding: 7px 16px;
        font-size: 12px;
        font-weight: 600;
        border-radius: 3px;
        opacity: 0;
        transition: 0.25s ease;
    }
    .premium-card:hover .quick-view-btn {
        opacity: 1;
    }
    body.dark-mode .quick-view-btn {
        background: var(--ink-dark, #F2F1ED);
        color: var(--bg-dark, #0F0F0F);
    }

    /* ACTION BUTTONS */
    .btn-dark {
        background: var(--ink, #1A1A1A) !important;
        border-color: var(--ink, #1A1A1A) !important;
        border-radius: 3px !important;
        font-weight: 600;
        font-size: 13.5px;
        transition: 0.2s ease;
    }
    .btn-dark:hover {
        background: var(--accent, #FF5A1F) !important;
        border-color: var(--accent, #FF5A1F) !important;
    }
    body.dark-mode .btn-dark {
        background: var(--ink-dark, #F2F1ED) !important;
        border-color: var(--ink-dark, #F2F1ED) !important;
        color: var(--bg-dark, #0F0F0F) !important;
    }

    .btn-success {
        background: var(--ink, #1A1A1A) !important;
        border-color: var(--ink, #1A1A1A) !important;
        border-radius: 3px !important;
        transition: 0.2s ease;
    }
    .btn-success:hover {
        background: var(--accent, #FF5A1F) !important;
        border-color: var(--accent, #FF5A1F) !important;
    }
    body.dark-mode .btn-success {
        background: var(--ink-dark, #F2F1ED) !important;
        border-color: var(--ink-dark, #F2F1ED) !important;
        color: var(--bg-dark, #0F0F0F) !important;
    }

    .btn-outline-dark {
        border: 1px solid var(--hairline, #E8E6E0) !important;
        color: var(--ink, #1A1A1A) !important;
        border-radius: 3px !important;
        transition: 0.2s ease;
    }
    .btn-outline-dark:hover {
        border-color: var(--accent, #FF5A1F) !important;
        color: var(--accent, #FF5A1F) !important;
        background: transparent !important;
    }
    body.dark-mode .btn-outline-dark {
        border-color: var(--hairline-dark, #2C2C29) !important;
        color: var(--ink-dark, #F2F1ED) !important;
    }

    .btn-primary {
        background: var(--ink, #1A1A1A) !important;
        border-color: var(--ink, #1A1A1A) !important;
        border-radius: 3px !important;
        font-weight: 600;
        transition: 0.2s ease;
    }
    .btn-primary:hover {
        background: var(--accent, #FF5A1F) !important;
        border-color: var(--accent, #FF5A1F) !important;
    }

    @media (max-width: 576px) {
        .premium-img { height: 200px; }
        .product-title { font-size: 13.5px; }
        .product-price { font-size: 15px; }
    }
    @media (max-width: 768px) {
        .premium-img { height: 180px; }
    }

    /* =========================
       QUICK VIEW MODAL
    ========================= */

    .thumb-small {
        width: 56px;
        height: 56px;
        object-fit: contain;
        border-radius: 4px;
        cursor: pointer;
        border: 1px solid var(--hairline, #E8E6E0);
        background: var(--accent-50, #FFF1EA);
        padding: 4px;
        transition: 0.2s ease;
    }
    .thumb-small:hover {
        border-color: var(--accent, #FF5A1F);
        transform: scale(1.04);
    }

    .quick-modal-md {
        border-radius: 8px;
        border: 1px solid var(--hairline, #E8E6E0);
        box-shadow: 0 20px 50px rgba(0,0,0,0.18);
    }
    body.dark-mode .quick-modal-md {
        background: var(--bg-raised-dark, #1A1A19);
        border-color: var(--hairline-dark, #2C2C29);
    }

    .custom-close {
        position: absolute;
        top: 14px;
        right: 16px;
        z-index: 10;
    }
    body.dark-mode .custom-close {
        filter: invert(1);
    }

    .main-img-md {
        height: 250px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--accent-50, #FFF1EA);
        border-radius: 6px;
    }
    body.dark-mode .main-img-md {
        background: var(--accent-50-dark, #2A1A12);
    }

    .main-img-md img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
    }

    .thumb-row-md {
        display: flex;
        gap: 8px;
        justify-content: center;
    }

    .thumb-row-md img {
        width: 54px;
        height: 54px;
        object-fit: contain;
        background: var(--accent-50, #FFF1EA);
        border: 1px solid var(--hairline, #E8E6E0);
        border-radius: 4px;
        padding: 4px;
        cursor: pointer;
        transition: 0.2s ease;
    }
    .thumb-row-md img:hover {
        border-color: var(--accent, #FF5A1F);
        transform: scale(1.06);
    }
    body.dark-mode .thumb-row-md img {
        background: var(--accent-50-dark, #2A1A12);
        border-color: var(--hairline-dark, #2C2C29);
    }

    .price-md {
        font-family: var(--font-mono, monospace);
        font-size: 19px;
        font-weight: 500;
        color: var(--ink, #1A1A1A);
    }
    body.dark-mode .price-md {
        color: var(--ink-dark, #F2F1ED);
    }

    .desc-md {
        font-size: 13.5px;
        color: var(--ink-soft, #6B6B65);
        line-height: 1.6;
    }
    body.dark-mode .desc-md {
        color: var(--ink-soft-dark, #9B9A92);
    }

    .delivery-md {
        background: var(--accent-50, #FFF1EA);
        color: var(--accent-ink, #7A2B0E);
        padding: 9px 12px;
        border-radius: 4px;
        font-size: 12.5px;
        font-weight: 500;
    }
    body.dark-mode .delivery-md {
        background: var(--accent-50-dark, #2A1A12);
        color: var(--ink-dark, #F2F1ED);
    }

    .related-md {
        border: 1px solid var(--hairline, #E8E6E0);
        border-radius: 4px;
        padding: 6px;
        cursor: pointer;
        transition: 0.2s ease;
    }
    .related-md:hover {
        transform: translateY(-3px);
        border-color: var(--accent, #FF5A1F);
        box-shadow: 0 10px 24px rgba(0,0,0,0.08);
    }
    body.dark-mode .related-md {
        border-color: var(--hairline-dark, #2C2C29);
    }

    .related-md img {
        width: 100%;
        height: 78px;
        object-fit: cover;
        border-radius: 3px;
    }

    /* =========================
       CUSTOM PRINT SECTION
       (had no styling at all before — now matches the system)
    ========================= */

    .custom-print {
        padding: 64px 0;
        margin-top: 50px;
        background: var(--accent-50, #FFF1EA);
        border-top: 1px solid var(--hairline, #E8E6E0);
        border-bottom: 1px solid var(--hairline, #E8E6E0);
        text-align: center;
    }

    .custom-print h2 {
        font-family: var(--font-display, sans-serif);
        font-weight: 600;
        font-size: 1.8rem;
        color: var(--ink, #1A1A1A);
        letter-spacing: -0.01em;
    }

    .custom-print p {
        color: var(--ink-soft, #6B6B65);
        font-size: 14.5px;
    }

    .custom-print .form-control {
        border: 1px solid var(--hairline, #E8E6E0);
        border-radius: 3px;
        background: var(--bg-raised, #fff);
        font-size: 13.5px;
        padding: 9px 12px;
    }
    .custom-print .form-control:focus {
        border-color: var(--accent, #FF5A1F);
        box-shadow: 0 0 0 3px var(--accent-50, #FFF1EA);
    }

    body.dark-mode .custom-print {
        background: var(--bg-raised-dark, #1A1A19);
        border-top-color: var(--hairline-dark, #2C2C29);
        border-bottom-color: var(--hairline-dark, #2C2C29);
    }
    body.dark-mode .custom-print .form-control {
        background: var(--bg-dark, #0F0F0F);
        border-color: var(--hairline-dark, #2C2C29);
        color: var(--ink-dark, #F2F1ED);
    }

    /* =========================
       PAGINATION
    ========================= */

    .pagination .page-link {
        border: 1px solid var(--hairline, #E8E6E0);
        color: var(--ink, #1A1A1A);
        font-size: 13.5px;
        margin: 0 2px;
        border-radius: 3px;
    }
    .pagination .page-link:hover {
        border-color: var(--accent, #FF5A1F);
        color: var(--accent, #FF5A1F);
    }
    .pagination .active .page-link {
        background: var(--ink, #1A1A1A);
        border-color: var(--ink, #1A1A1A);
        color: var(--bg, #FAFAF8);
    }
    body.dark-mode .pagination .page-link {
        background: var(--bg-raised-dark, #1A1A19);
        border-color: var(--hairline-dark, #2C2C29);
        color: var(--ink-dark, #F2F1ED);
    }
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
                            <i class="bi bi-truck"></i> Delivery in 2–4 days
                        </div>

                        <!-- BUTTONS -->
                        <div class="d-flex gap-2">
                            <button class="btn btn-success flex-fill addToCart"
                                    data-id="{{ $product->id }}">
                                <i class="bi bi-cart"></i> Add to Cart
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