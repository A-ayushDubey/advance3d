@extends('layouts.app') @section('content')

<style>
    /* =====================================================
       AD-VANCE 3D — HOMEPAGE
       modern / minimal restyle
       Tokens reused from layout.blade.php (--bg, --ink, --accent,
       --hairline, --font-display, --font-body, --font-mono).
       Fallback values included so this still works standalone.
    ===================================================== */

    /* ---- HERO VIDEO ---- */

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

    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            to bottom,
            rgba(15, 15, 15, 0.45),
            rgba(15, 15, 15, 0.82)
        );
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: #fff;
    }

    .hero-overlay h1 {
        font-family: var(--font-display, sans-serif);
        font-weight: 600;
        letter-spacing: -0.02em;
    }

    .hero-overlay p.lead {
        font-size: 1.05rem;
        color: #D8D6CF;
        font-weight: 400;
    }

    /* Buttons — shared ink / outline system */

    .btn {
        transition: 0.2s ease;
        border-radius: 3px;
        font-weight: 600;
        font-size: 14.5px;
        border: 1px solid transparent;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .btn-primary {
        background: var(--ink, #1A1A1A) !important;
        border-color: var(--ink, #1A1A1A) !important;
        color: var(--bg, #FAFAF8) !important;
    }
    .btn-primary:hover {
        background: var(--accent, #FF5A1F) !important;
        border-color: var(--accent, #FF5A1F) !important;
    }

    .btn-warning,
    .btn-outline-light {
        background: transparent !important;
        border: 1px solid rgba(255,255,255,0.6) !important;
        color: #fff !important;
    }
    .btn-warning:hover,
    .btn-outline-light:hover {
        background: #fff !important;
        color: var(--ink, #1A1A1A) !important;
        border-color: #fff !important;
    }

    .btn-success {
        background: var(--ink, #1A1A1A) !important;
        border-color: var(--ink, #1A1A1A) !important;
        color: #fff !important;
    }
    .btn-success:hover {
        background: var(--accent, #FF5A1F) !important;
        border-color: var(--accent, #FF5A1F) !important;
    }

    .btn-outline-primary {
        background: transparent !important;
        border: 1px solid var(--hairline, #E8E6E0) !important;
        color: var(--ink, #1A1A1A) !important;
    }
    .btn-outline-primary:hover {
        border-color: var(--accent, #FF5A1F) !important;
        color: var(--accent, #FF5A1F) !important;
    }

    /* Scroll animation — unchanged */

    .fade-in {
        opacity: 0;
        transform: translateY(40px);
        transition: 1s;
    }

    .fade-in.show {
        opacity: 1;
        transform: translateY(0);
    }

    section {
        margin-top: 0px;
    }

    .card p {
        font-style: italic;
        color: var(--ink-soft, #6B6B65);
    }
    .featured-img {
        width: 100%;
        aspect-ratio: 1/1;
        object-fit: cover;
    }

    /* =========================
       GLOBAL SECTION HEADINGS
    ========================= */

    section h2 {
        font-family: var(--font-display, sans-serif);
        font-weight: 600;
        font-size: 2rem;
        letter-spacing: -0.01em;
        position: relative;
        display: inline-block;
        color: var(--ink, #1A1A1A);
    }

    section h2::after {
        content: "";
        width: 40px;
        height: 2px;
        background: var(--accent, #FF5A1F);
        display: block;
        margin: 14px auto 0;
        border-radius: 2px;
    }

    section p.text-muted {
        color: var(--ink-soft, #6B6B65) !important;
        font-size: 14.5px;
    }

    /* =========================
       PRICING SECTION
    ========================= */

    .price-box {
        background: var(--bg-raised, #fff);
        border: 1px solid var(--hairline, #E8E6E0);
        padding: 30px;
        border-radius: 4px;
        font-size: 1rem;
        font-weight: 500;
        color: var(--ink, #1A1A1A);
        transition: 0.25s ease;
        box-shadow: none;
        display: flex;
        align-items: center;
        gap: 10px;
        justify-content: center;
    }

    .price-box i {
        font-size: 18px;
        color: var(--accent, #FF5A1F);
    }

    .price-box:hover {
        transform: translateY(-4px);
        border-color: var(--accent, #FF5A1F);
        box-shadow: 0 16px 36px rgba(0,0,0,0.06);
    }

    .price-box span {
        font-family: var(--font-mono, monospace);
        font-weight: 500;
        font-size: 1.15rem;
        color: var(--ink, #1A1A1A);
        margin: 0;
    }

    /* =========================
       WHY CHOOSE US
    ========================= */

    .feature-box {
        background: var(--bg-raised, #fff);
        border: 1px solid var(--hairline, #E8E6E0);
        padding: 26px 20px;
        border-radius: 4px;
        transition: 0.25s ease;
        font-size: 14.5px;
        font-weight: 500;
        color: var(--ink, #1A1A1A);
        box-shadow: none;
    }

    .feature-box:hover {
        transform: translateY(-6px);
        background: var(--bg-raised, #fff);
        color: var(--ink, #1A1A1A);
        border-color: var(--accent, #FF5A1F);
        box-shadow: 0 16px 36px rgba(0,0,0,0.06);
    }

    .feature-box i {
        font-size: 26px;
        margin-bottom: 12px;
        display: block;
        color: var(--accent, #FF5A1F);
        transition: transform 0.25s ease;
    }
    .feature-box:hover i {
        transform: scale(1.1);
    }

    /* =========================
       GALLERY (legacy, kept for compat)
    ========================= */

    .gallery-img {
        border-radius: 4px;
        border: 1px solid var(--hairline, #E8E6E0);
        overflow: hidden;
        transition: 0.4s;
        cursor: pointer;
        width: 100%;
        aspect-ratio: 1 / 1;
    }

    .gallery-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: 0.4s;
    }

    .gallery-img:hover img {
        transform: scale(1.06);
    }
    .gallery-img:hover {
        box-shadow: 0 16px 36px rgba(0,0,0,0.1);
    }

    /* =========================
       RESPONSIVE — PRESERVED FROM ORIGINAL
    ========================= */

    @media (max-width: 768px) {
        .feature-box {
            padding: 15px;
            font-size: 13.5px;
            border-radius: 4px;
        }
    }
    @media (max-width: 768px) {
        .price-box {
            padding: 18px;
            font-size: 13.5px;
            border-radius: 4px;
            max-width: 280px;
            margin: 0 auto;
        }
        .price-box span {
            font-size: 17px;
        }
    }
    @media (max-width: 992px) {
        .gallery-img { aspect-ratio: 1 / 1; }
    }
    @media (max-width: 576px) {
        .gallery-img { aspect-ratio: 1 / 1; }
    }
    @media (max-width: 768px) {
        section h2 { font-size: 19px; }
    }
    @media (max-width: 768px) {
        .gallery-img { margin-bottom: 10px; }
    }
    @media (max-width: 768px) {
        .btn { margin-bottom: 5px; }
    }
    @media (max-width: 768px) {
        .container {
            padding-left: 12px;
            padding-right: 12px;
        }
    }
    @media (max-width: 768px) {
        .carousel-item img { height: 250px !important; }
        .carousel-caption h1 { font-size: 18px; }
        .carousel-caption p { font-size: 13px; }
    }
    @media (max-width: 768px) {
        .hero-video { height: 65vh; }
        .hero-overlay h1 { font-size: 24px; }
        .hero-overlay p { font-size: 14px; }
        .hero-overlay .btn {
            font-size: 13.5px;
            padding: 9px 16px;
            margin-top: 10px;
        }
    }

    /* =========================
       DARK MODE — TOKEN-BASED
    ========================= */

    body.dark-mode {
        background: var(--bg-dark, #0F0F0F);
        color: var(--ink-dark, #F2F1ED);
    }

    body.dark-mode .bg-light {
        background: var(--bg-dark, #0F0F0F) !important;
        color: var(--ink-dark, #F2F1ED);
    }

    body.dark-mode .card,
    body.dark-mode .price-box,
    body.dark-mode .feature-box {
        background: var(--bg-raised-dark, #1A1A19) !important;
        border-color: var(--hairline-dark, #2C2C29) !important;
        color: var(--ink-dark, #F2F1ED);
        box-shadow: none;
    }

    body.dark-mode .feature-box:hover,
    body.dark-mode .price-box:hover {
        border-color: var(--accent, #FF5A1F) !important;
    }

    body.dark-mode p,
    body.dark-mode span,
    body.dark-mode h1,
    body.dark-mode h2,
    body.dark-mode h3,
    body.dark-mode h4,
    body.dark-mode h5 {
        color: var(--ink-dark, #F2F1ED);
    }

    body.dark-mode section h2::after {
        background: var(--accent, #FF5A1F);
    }

    body.dark-mode .text-muted {
        color: var(--ink-soft-dark, #9B9A92) !important;
    }

    body.dark-mode .accordion-button {
        background: var(--bg-raised-dark, #1A1A19);
        color: var(--ink-dark, #F2F1ED);
    }
    body.dark-mode .accordion-button:not(.collapsed) {
        background: var(--ink, #1A1A1A);
        color: var(--bg, #FAFAF8);
    }
    body.dark-mode .accordion-body {
        background: var(--bg-raised-dark, #1A1A19);
        color: var(--ink-soft-dark, #9B9A92);
    }

    body.dark-mode .gallery-img {
        border-color: var(--hairline-dark, #2C2C29);
    }

    body.dark-mode .carousel-caption {
        color: #fff;
    }

    body.dark-mode .bg-dark {
        background: #000 !important;
    }

    body.dark-mode .btn-outline-primary {
        color: var(--ink-dark, #F2F1ED) !important;
        border-color: var(--hairline-dark, #2C2C29) !important;
    }
    body.dark-mode .btn-outline-primary:hover {
        border-color: var(--accent, #FF5A1F) !important;
        color: var(--accent, #FF5A1F) !important;
    }

    /* =========================
       FAQ SECTION
    ========================= */

    .accordion-item {
        border: 1px solid var(--hairline, #E8E6E0);
        margin-bottom: 12px;
        border-radius: 4px !important;
        overflow: hidden;
        box-shadow: none;
    }

    .accordion-button {
        font-family: var(--font-body, sans-serif);
        font-weight: 600;
        font-size: 1rem;
        background: var(--bg-raised, #fff);
        color: var(--ink, #1A1A1A);
        transition: 0.25s ease;
    }

    .accordion-button:not(.collapsed) {
        background: var(--ink, #1A1A1A);
        color: var(--bg, #FAFAF8);
        box-shadow: none;
    }

    .accordion-button:focus {
        box-shadow: none;
    }

    .accordion-body {
        font-size: 0.92rem;
        color: var(--ink-soft, #6B6B65);
    }

    .bg-dark h2::after {
        background: var(--accent, #FF5A1F);
    }

    /* =========================
       PROCESS / HOW IT WORKS
    ========================= */

    .process-section {}

    .process-line {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        margin-top: 50px;
    }

    .process-line::before {
        content: "";
        position: absolute;
        top: 25px;
        left: 5%;
        width: 90%;
        height: 1px;
        background: var(--hairline, #E8E6E0);
        z-index: 0;
    }

    .process-step {
        position: relative;
        z-index: 2;
        text-align: center;
        width: 25%;
    }

    .circle {
        width: 50px;
        height: 50px;
        background: var(--bg, #FAFAF8);
        border: 1.5px solid var(--ink, #1A1A1A);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 14px;
        font-family: var(--font-mono, monospace);
        font-weight: 500;
        transition: 0.3s ease;
        color: var(--ink, #1A1A1A);
    }

    body.dark-mode .circle {
        background: var(--bg-dark, #0F0F0F);
        border-color: var(--ink-dark, #F2F1ED);
        color: var(--ink-dark, #F2F1ED);
    }

    .process-step h6 {
        font-size: 14.5px;
        font-weight: 500;
        color: var(--ink, #1A1A1A);
        margin: 0;
    }
    body.dark-mode .process-step h6 {
        color: var(--ink-dark, #F2F1ED);
    }

    .process-step:hover .circle {
        background: var(--ink, #1A1A1A);
        border-color: var(--ink, #1A1A1A);
        color: var(--bg, #FAFAF8);
        transform: scale(1.12);
        box-shadow: 0 0 0 4px var(--accent-50, #FFF1EA);
    }

    .process-line::after {
        content: "";
        position: absolute;
        top: 25px;
        left: 5%;
        width: 0%;
        height: 1px;
        background: var(--accent, #FF5A1F);
        animation: flow 3s linear infinite;
    }

    @keyframes flow {
        0% { width: 0%; }
        100% { width: 90%; }
    }

    @media (max-width: 768px) {
        .process-line {
            flex-direction: column;
            gap: 36px;
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
       FEATURED PRODUCT CARD
    ========================= */

    .premium-card {
        background: var(--bg-raised, #fff);
        border: 1px solid var(--hairline, #E8E6E0);
        border-radius: 6px;
        overflow: hidden;
        transition: 0.3s ease;
        color: var(--ink, #1A1A1A);
        position: relative;
    }

    .premium-card:hover {
        transform: translateY(-6px);
        border-color: var(--accent, #FF5A1F);
        box-shadow: 0 20px 44px rgba(0,0,0,0.08);
    }

    .premium-img {
        position: relative;
        background: var(--accent-50, #FFF1EA);
        padding: 0;
    }

    .premium-img img {
        width: 100%;
        height: 220px;
        border-radius: 0;
        object-fit: cover;
        transition: 0.5s;
    }

    .premium-card:hover img {
        transform: scale(1.05);
    }

    .badge-sale {
        position: absolute;
        bottom: 10px;
        left: 12px;
        background: var(--ink, #1A1A1A);
        border: none;
        color: var(--bg, #FAFAF8);
        padding: 4px 11px;
        border-radius: 2px;
        font-family: var(--font-mono, monospace);
        font-size: 10.5px;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }

    .premium-content {
        padding: 16px 16px 18px;
    }

    .product-title {
        font-size: 14px;
        font-weight: 500;
        line-height: 1.4;
        margin-bottom: 8px;
        color: var(--ink, #1A1A1A);
    }

    .rating {
        font-size: 12.5px;
        color: var(--accent, #FF5A1F);
        margin-bottom: 10px;
    }
    .rating span {
        color: var(--ink-soft, #6B6B65);
        font-size: 12px;
    }

    .price {
        display: flex;
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
        font-size: 16.5px;
        font-weight: 500;
        color: var(--ink, #1A1A1A);
    }

    body.dark-mode .premium-card {
        background: var(--bg-raised-dark, #1A1A19);
        border-color: var(--hairline-dark, #2C2C29);
    }
    body.dark-mode .product-title,
    body.dark-mode .price .new {
        color: var(--ink-dark, #F2F1ED);
    }
    body.dark-mode .badge-sale {
        background: var(--ink-dark, #F2F1ED);
        color: var(--bg-dark, #0F0F0F);
    }

    /* =========================
       3D PRINT SHOWCASE (lab grid)
    ========================= */

    .lab-section {
        position: relative;
        overflow: hidden;
    }

    .lab-section::before {
        content: "";
        position: absolute;
        width: 100%;
        height: 100%;
        background:
            linear-gradient(120deg, transparent 95%, rgba(255,90,31,0.10)),
            linear-gradient(-120deg, transparent 95%, rgba(255,90,31,0.10));
        pointer-events: none;
    }

    .lab-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-auto-rows: 160px;
        gap: 14px;
    }

    .lab-item {
        position: relative;
        overflow: hidden;
        border-radius: 6px;
        background: var(--bg-raised, #fff);
        border: 1px solid var(--hairline, #E8E6E0);
        cursor: pointer;
        transition: 0.35s ease;
    }

    .lab-item.big {
        grid-column: span 2;
        grid-row: span 2;
    }

    .lab-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: 0.6s ease;
    }

    .lab-item:hover {
        transform: translateY(-8px);
        border-color: var(--accent, #FF5A1F);
        box-shadow: 0 20px 48px rgba(0,0,0,0.12);
    }

    .lab-item:hover img {
        transform: scale(1.08);
    }

    .lab-overlay {
        position: absolute;
        bottom: 0;
        width: 100%;
        padding: 18px;
        background: linear-gradient(to top, rgba(15,15,15,0.88), transparent);
        opacity: 0;
        transition: 0.3s;
    }

    .lab-item:hover .lab-overlay {
        opacity: 1;
    }

    .lab-overlay h5 {
        margin: 0;
        font-family: var(--font-display, sans-serif);
        font-size: 15px;
        font-weight: 600;
        color: #fff;
    }

    .lab-overlay p {
        font-size: 12px;
        color: #D8D6CF;
        margin: 0;
    }

    @media (max-width: 992px) {
        .lab-grid {
            grid-template-columns: repeat(3, 1fr);
            grid-auto-rows: 140px;
            gap: 12px;
        }
        .lab-item.big {
            grid-column: span 2;
            grid-row: span 2;
        }
    }

    @media (max-width: 768px) {
        .lab-grid {
            grid-template-columns: repeat(2, 1fr);
            grid-auto-rows: 130px;
            gap: 10px;
        }
        .lab-item.big {
            grid-column: span 2;
            grid-row: span 2;
        }
        .lab-overlay {
            opacity: 1;
            padding: 12px;
        }
        .lab-overlay h5 {
            font-size: 13px;
        }
    }

    @media (max-width: 480px) {
        .lab-grid {
            grid-template-columns: 1fr;
            grid-auto-rows: 220px;
        }
        .lab-item.big {
            grid-column: span 1;
            grid-row: span 1;
        }
        .lab-overlay h5 {
            font-size: 13px;
        }
    }

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
       SERVICES + TESTIMONIALS CARDS
    ========================= */

    .card.shadow-sm {
        border: 1px solid var(--hairline, #E8E6E0) !important;
        border-radius: 4px !important;
        box-shadow: none !important;
        transition: 0.25s ease;
    }
    .card.shadow-sm:hover {
        border-color: var(--accent, #FF5A1F) !important;
        transform: translateY(-4px);
    }
    .card.shadow-sm h4 {
        font-family: var(--font-display, sans-serif);
        font-size: 1.05rem;
        font-weight: 600;
        color: var(--ink, #1A1A1A);
    }
    .card.shadow-sm h4 i {
        color: var(--accent, #FF5A1F);
        margin-right: 6px;
    }
    .card.shadow-sm p {
        font-style: normal;
        font-size: 14px;
    }

    .card.shadow-sm strong {
        color: var(--ink, #1A1A1A);
        font-weight: 600;
    }

    .card.shadow-sm .text-warning,
    .card.shadow-sm .rating-stars {
        color: var(--accent, #FF5A1F) !important;
    }

    body.dark-mode .card.shadow-sm {
        background: var(--bg-raised-dark, #1A1A19) !important;
        border-color: var(--hairline-dark, #2C2C29) !important;
    }

    /* =========================
       CAROUSEL CAPTION
    ========================= */

    .carousel-caption h1 {
        font-family: var(--font-display, sans-serif);
        font-weight: 600;
        letter-spacing: -0.01em;
    }
    .carousel-caption {
        background: linear-gradient(to top, rgba(15,15,15,0.55), transparent);
        border-radius: 6px;
        padding-bottom: 24px;
    }

    /* =========================
       SMOOTH ANIMATION (kept)
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
                    <i class="bi bi-box-seam"></i> Small Prints
                    <span>₹99+</span>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="price-box">
                    <i class="bi bi-box-seam"></i> Medium Prints
                    <span>₹299+</span>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="price-box">
                    <i class="bi bi-box-seam"></i> Custom Projects
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
                    <i class="bi bi-lightning-charge"></i>
                    Fast Turnaround
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="feature-box">
                    <i class="bi bi-bullseye"></i>
                    Precision Printing
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="feature-box">
                    <i class="bi bi-lightbulb"></i>
                    Design Support
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="feature-box">
                    <i class="bi bi-headset"></i>
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
                    <h4><i class="bi bi-bricks"></i> Custom 3D Printing</h4>
                    <p>
                        Create personalized models, tools and parts with
                        advanced 3D printers.
                    </p>
                </div>
            </div>

            <div class="col-6 col-md-4 mb-3">
                <div class="card shadow-sm p-4 h-100">
                    <h4><i class="bi bi-gear"></i> Prototype Development</h4>
                    <p>Fast prototyping for engineers and startups.</p>
                </div>
            </div>

            <div class="col-6 col-md-4 mb-3">
                <div class="card shadow-sm p-4 h-100">
                    <h4><i class="bi bi-palette"></i> 3D Design Services</h4>
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
                    <strong class="rating-stars">⭐⭐⭐⭐⭐</strong><br />
                    <strong>Rahul Sharma</strong>
                </div>
            </div>

            <div class="col-12 col-md-4 mb-3">
                <div class="card p-4 shadow-sm text-center">
                    <p>"Great service for custom prototypes."</p>
                    <strong class="rating-stars">⭐⭐⭐⭐⭐</strong><br />
                    <strong>Priya Patel</strong>
                </div>
            </div>

            <div class="col-12 col-md-4 mb-3">
                <div class="card p-4 shadow-sm text-center">
                    <p>"Best 3D printing service I have used."</p>
                    <strong class="rating-stars">⭐⭐⭐⭐⭐</strong><br />
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