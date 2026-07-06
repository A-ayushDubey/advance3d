@extends('layouts.app') @section('content')

<style>
    /* =====================================================
       AD-VANCE 3D — PRODUCTS PAGE
       modern / minimal restyle — mobile-first rebuild
       Tokens reused from layout.blade.php; fallbacks included.
    ===================================================== */

    /* =========================
       HERO
    ========================= */

    .products-hero {
        position: relative;
        background:
            linear-gradient(180deg, rgba(15,15,15,0.35) 0%, rgba(15,15,15,0.72) 65%, rgba(15,15,15,0.88) 100%),
            url("https://images.pexels.com/photos/30415869/pexels-photo-30415869.jpeg");
        background-size: cover;
        background-position: center;
        min-height: 320px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        text-align: center;
        padding: 56px 20px;
        overflow: hidden;
    }

    .products-hero-inner {
        position: relative;
        z-index: 2;
        max-width: 680px;
        margin: 0 auto;
    }

    .products-hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-family: var(--font-mono, monospace);
        font-size: 11.5px;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #FFD9C4;
        background: rgba(255,90,31,0.16);
        border: 1px solid rgba(255,90,31,0.4);
        padding: 6px 14px;
        border-radius: 20px;
        margin-bottom: 18px;
    }

    .products-hero-eyebrow::before {
        content: "";
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--accent, #FF5A1F);
        display: inline-block;
    }

    .products-hero h1 {
        font-family: var(--font-display, sans-serif);
        font-weight: 600;
        font-size: clamp(24px, 5vw, 40px);
        letter-spacing: -0.02em;
        line-height: 1.15;
        margin-bottom: 12px;
    }

    .products-hero p {
        opacity: 0.88;
        font-size: clamp(13px, 2.2vw, 15.5px);
        color: #E4E2DC;
        max-width: 480px;
        margin: 0 auto;
        line-height: 1.6;
    }

    .products-hero-stats {
        display: flex;
        justify-content: center;
        gap: 28px;
        margin-top: 28px;
        flex-wrap: wrap;
    }

    .products-hero-stat {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 2px;
    }

    .products-hero-stat b {
        font-family: var(--font-mono, monospace);
        font-size: 18px;
        font-weight: 600;
        color: #fff;
    }

    .products-hero-stat span {
        font-size: 10.5px;
        color: #C9C7C0;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    @media (max-width: 768px) {
        .products-hero { min-height: 260px; padding: 44px 18px; }
        .products-hero-stats { gap: 20px; margin-top: 20px; }
        .products-hero-stat b { font-size: 15px; }
    }
    @media (max-width: 480px) {
        .products-hero { min-height: 220px; padding: 36px 14px; }
        .products-hero-eyebrow { font-size: 10px; padding: 5px 11px; margin-bottom: 12px; }
    }

    /* =========================
       PRODUCT GRID WIDTHS
       (CSS grid replaces the old bootstrap row/col percentages
       for reliable, gap-consistent 2-up mobile / 4-up desktop)
    ========================= */

    #productGrid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
    }

    @media (max-width: 991px) {
        #productGrid { grid-template-columns: repeat(3, 1fr); gap: 14px; }
    }
    @media (max-width: 640px) {
        #productGrid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
    }

    .product-item { width: 100%; }

    /* =========================
       FILTER BAR
    ========================= */

    .filter-top {
        border-bottom: 1px solid var(--hairline, #E8E6E0);
        padding-bottom: 14px;
        gap: 14px;
    }

    .filter-label {
        color: var(--ink-soft, #6B6B65);
        font-size: 13.5px;
        font-weight: 500;
        flex-shrink: 0;
    }

    .filter-scroll {
        display: flex;
        align-items: center;
        gap: 10px;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
        padding-bottom: 2px;
    }
    .filter-scroll::-webkit-scrollbar { display: none; }

    .filter-btn {
        background: transparent;
        border: 1px solid var(--hairline, #E8E6E0);
        color: var(--ink, #1A1A1A);
        padding: 8px 14px;
        border-radius: 20px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 500;
        white-space: nowrap;
        transition: border-color 0.2s ease, transform 0.15s ease, background 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .filter-btn:hover {
        border-color: var(--accent, #FF5A1F);
    }
    .filter-btn i { font-size: 11px; opacity: 0.6; }

    .filter-dropdown.active .filter-btn {
        border-color: var(--ink, #1A1A1A);
        background: var(--ink, #1A1A1A);
        color: var(--bg, #FAFAF8);
    }
    .filter-dropdown.active .filter-btn i { opacity: 1; color: var(--accent, #FF5A1F); }

    .filter-dropdown {
        position: relative;
        flex-shrink: 0;
    }

  .dropdown-menu{
    display: none;
    position: absolute;   /* fallback; JS overrides to fixed on open */
    top: calc(100% + 8px);
    left: 0;
    background: var(--bg-raised, #fff);
    border: 1px solid var(--hairline, #E8E6E0);
    border-radius: 8px;
    min-width: 180px;
    z-index: 2000;         /* was 100 — raise above nav (1000) */
    box-shadow: 0 16px 36px rgba(0,0,0,0.1);
    overflow: hidden;
}

    .dropdown-menu div {
        padding: 10px 14px;
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

    /* PRICE RANGE PANEL */

    .price-panel {
        padding: 16px;
        min-width: 240px;
    }
    .price-panel .price-heading {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        margin-bottom: 10px;
        font-size: 12.5px;
        color: var(--ink-soft, #6B6B65);
    }
    .price-panel .price-heading b {
        font-family: var(--font-mono, monospace);
        color: var(--ink, #1A1A1A);
        font-size: 14px;
        font-weight: 600;
    }
    .price-panel input[type="range"] {
        width: 100%;
        accent-color: var(--accent, #FF5A1F);
        margin-bottom: 12px;
    }
    .price-panel .price-apply-row {
        display: flex;
        gap: 8px;
    }
    .price-apply-btn,
    .price-reset-btn {
        flex: 1;
        border-radius: 6px;
        font-size: 12.5px;
        font-weight: 600;
        padding: 8px 10px;
        cursor: pointer;
        transition: 0.2s ease;
        border: 1px solid var(--hairline, #E8E6E0);
    }
    .price-apply-btn {
        background: var(--ink, #1A1A1A);
        color: var(--bg, #FAFAF8);
        border-color: var(--ink, #1A1A1A);
    }
    .price-apply-btn:hover { background: var(--accent, #FF5A1F); border-color: var(--accent, #FF5A1F); }
    .price-reset-btn {
        background: transparent;
        color: var(--ink, #1A1A1A);
    }
    .price-reset-btn:hover { border-color: var(--accent, #FF5A1F); color: var(--accent, #FF5A1F); }

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
        font-size: 13px;
        font-weight: 500;
        transition: color 0.15s ease;
        flex-shrink: 0;
        white-space: nowrap;
    }
    .clear-btn:hover {
        color: var(--accent, #FF5A1F);
    }

    .product-count {
        color: var(--ink-soft, #6B6B65);
        font-family: var(--font-mono, monospace);
        font-size: 12px;
        white-space: nowrap;
    }

    .sort-box { position: relative; }
    .sort-box .dropdown-menu { right: 0; left: auto; }

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
    body.dark-mode .price-panel .price-heading { color: var(--ink-soft-dark, #9B9A92); }
    body.dark-mode .price-panel .price-heading b { color: var(--ink-dark, #F2F1ED); }
    body.dark-mode .price-reset-btn { color: var(--ink-dark, #F2F1ED); border-color: var(--hairline-dark, #2C2C29); }

    /* ---- Mobile layout: two clean rows, filters scroll horizontally ---- */
    @media (max-width: 768px) {
        .filter-top {
            flex-direction: column;
            align-items: stretch !important;
            gap: 10px !important;
        }
        .filter-top > div {
            width: 100%;
        }
        .filter-top > div:first-child {
            flex-wrap: nowrap !important;
        }
        .filter-row-right {
            justify-content: space-between !important;
        }
        .filter-btn {
            min-height: 38px;
            padding: 8px 13px;
        }
        .dropdown-menu {
            min-width: 0;
            width: max-content;
            max-width: calc(100vw - 48px);
        }
        .sort-box .dropdown-menu {
            right: 0;
            left: auto;
        }
        .price-panel { min-width: 220px; }
    }

    /* =========================
       BADGES / WISHLIST
    ========================= */

    .badge-new {
        position: absolute;
        top: 10px;
        left: 10px;
        background: var(--ink, #1A1A1A);
        color: var(--bg, #FAFAF8);
        font-family: var(--font-mono, monospace);
        font-size: 9.5px;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        padding: 4px 8px;
        border-radius: 2px;
        z-index: 2;
    }

    .wishlist {
        position: absolute;
        top: 10px;
        right: 10px;
        background: var(--bg-raised, #fff);
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: 1px solid var(--hairline, #E8E6E0);
        color: var(--ink, #1A1A1A);
        transition: 0.2s ease;
        z-index: 2;
        font-size: 14px;
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
        border-radius: 4px;
    }

    /* =========================
       PRODUCT CARD
    ========================= */

    .premium-card {
        width: 100%;
        height: 100%;
        background: var(--bg-raised, #fff);
        border-radius: 8px;
        overflow: hidden;
        transition: 0.3s ease;
        border: 1px solid var(--hairline, #E8E6E0);
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .premium-card:hover {
        transform: translateY(-4px);
        border-color: var(--accent, #FF5A1F);
        box-shadow: 0 20px 44px rgba(0,0,0,0.08);
    }

    .premium-img {
        position: relative;
        aspect-ratio: 1 / 1;
        height: auto;
        overflow: hidden;
        background: var(--accent-50, #FFF1EA);
        flex-shrink: 0;
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
        padding: 12px 12px 14px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex: 1;
        min-width: 0;
    }

    .product-title {
        font-weight: 600;
        font-size: 14px;
        margin-top: 2px;
        color: var(--ink, #1A1A1A);
        font-family: var(--font-body, sans-serif);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        min-height: calc(1.3em * 2);
        line-height: 1.3;
    }
    body.dark-mode .product-title {
        color: var(--ink-dark, #F2F1ED);
    }

    .price {
        display: flex;
        flex-wrap: wrap;
        gap: 4px 8px;
        align-items: center;
        font-family: var(--font-mono, monospace);
        max-width: 100%;
        margin-top: 6px;
    }

    .price .old,
    .price .new {
        white-space: nowrap;
    }

    .price .old {
        text-decoration: line-through;
        color: var(--ink-soft, #6B6B65);
        font-size: 12px;
    }

    .price .new {
        font-size: 16px;
        font-weight: 500;
        color: var(--ink, #1A1A1A);
    }
    body.dark-mode .price .new {
        color: var(--ink-dark, #F2F1ED);
    }

    .discount-badge {
        font-size: 10px;
        font-weight: 700;
        background: var(--accent, #FF5A1F);
        color: #fff;
        padding: 2px 6px;
        border-radius: 2px;
        letter-spacing: 0.03em;
        white-space: nowrap;
    }

    /* RATING — gold kept deliberately (stars read better in their
       conventional color; swapping to ink/accent reduces legibility
       of "this is a rating" at a glance) */
    .rating {
        color: #D9A441;
        font-size: 13px;
        margin: 2px 0 0;
    }

    /* QUICK VIEW BUTTON */
    .quick-view-btn {
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
        background: var(--ink, #1A1A1A);
        color: var(--bg, #FAFAF8);
        border: none;
        padding: 6px 14px;
        font-size: 11.5px;
        font-weight: 600;
        border-radius: 20px;
        opacity: 0;
        transition: 0.25s ease;
        white-space: nowrap;
    }
    .premium-card:hover .quick-view-btn {
        opacity: 1;
    }
    body.dark-mode .quick-view-btn {
        background: var(--ink-dark, #F2F1ED);
        color: var(--bg-dark, #0F0F0F);
    }
    /* Touch devices can't hover — always show it, smaller, out of the way */
    @media (hover: none) {
        .quick-view-btn { opacity: 1; bottom: 8px; font-size: 10.5px; padding: 5px 11px; }
    }

    /* ACTION BUTTONS */
    .btn-dark {
        background: var(--ink, #1A1A1A) !important;
        border-color: var(--ink, #1A1A1A) !important;
        border-radius: 6px !important;
        font-weight: 600;
        font-size: 12.5px;
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
        border-radius: 6px !important;
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
        border-radius: 6px !important;
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
        border-radius: 6px !important;
        font-weight: 600;
        transition: 0.2s ease;
    }
    .btn-primary:hover {
        background: var(--accent, #FF5A1F) !important;
        border-color: var(--accent, #FF5A1F) !important;
    }

    .gap-2.d-flex {
        flex-wrap: nowrap;
        gap: 6px !important;
        margin-top: 10px;
    }
    .gap-2.d-flex .btn-dark {
        flex: 1 1 auto;
        width: auto !important;
        min-width: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        padding: 8px 6px;
    }
    .gap-2.d-flex .btn-success {
        flex: 0 0 auto;
        min-width: 40px;
        padding: 8px 10px;
    }

    @media (max-width: 480px) {
        .product-title { font-size: 12.5px; min-height: calc(1.3em * 2); }
        .price .new { font-size: 14px; }
        .price .old { font-size: 10.5px; }
        .discount-badge { font-size: 9px; padding: 1px 5px; }
        .card-body { padding: 9px 9px 11px; }
        .gap-2.d-flex .btn-dark { font-size: 11px; }
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
        flex-wrap: wrap;
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

    @media (max-width: 576px) {
        .modal-dialog { margin: 10px; }
        .modal-body .row.g-2 > .col-3 {
            flex: 0 0 50%;
            max-width: 50%;
        }
        .related-md img {
            height: 90px;
        }
        .main-img-md { height: 200px; }
        .quick-modal-md .row.g-4 > div { width: 100%; }
    }

    /* =========================
       CUSTOM PRINT SECTION
    ========================= */

    .custom-print {
        padding: 48px 0;
        margin-top: 40px;
        background: var(--accent-50, #FFF1EA);
        border-top: 1px solid var(--hairline, #E8E6E0);
        border-bottom: 1px solid var(--hairline, #E8E6E0);
        text-align: center;
    }

    .custom-print h2 {
        font-family: var(--font-display, sans-serif);
        font-weight: 600;
        font-size: clamp(1.3rem, 4vw, 1.8rem);
        color: var(--ink, #1A1A1A);
        letter-spacing: -0.01em;
    }

    .custom-print p {
        color: var(--ink-soft, #6B6B65);
        font-size: 14px;
    }

    .custom-print .form-control {
        border: 1px solid var(--hairline, #E8E6E0);
        border-radius: 6px;
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

    @media (max-width: 576px) {
        .custom-print .row.justify-content-center { gap: 10px; }
        .custom-print .col-md-4,
        .custom-print .col-md-2 { width: 100%; max-width: 100%; flex: 0 0 100%; }
    }

    /* =========================
       PAGINATION
    ========================= */

    .pagination { flex-wrap: wrap; }
    .pagination .page-link {
        border: 1px solid var(--hairline, #E8E6E0);
        color: var(--ink, #1A1A1A);
        font-size: 13.5px;
        margin: 0 2px;
        border-radius: 6px;
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
    <div class="products-hero-inner">
        <span class="products-hero-eyebrow">FDM &amp; Resin Printing</span>
        <h1>Our 3D Printed Products</h1>
        <p>Explore unique creations made with advanced 3D printing — precision parts, décor, keychains, gifts and more.</p>

        <div class="products-hero-stats">
            <div class="products-hero-stat">
                <b>{{ count($products ?? []) }}+</b>
                <span>Products</span>
            </div>
            <div class="products-hero-stat">
                <b>2–4</b>
                <span>Days delivery</span>
            </div>
            <div class="products-hero-stat">
                <b>4.8★</b>
                <span>Avg. rating</span>
            </div>
        </div>
    </div>
</section>

<!-- FILTERS -->
<div class="container my-4">
    <!-- FILTER BAR -->
    <div
        class="filter-top d-flex justify-content-between align-items-center flex-wrap gap-3"
    >
        <!-- LEFT: scrollable filter chips -->
        <div class="filter-scroll">

            <span class="filter-label d-none d-md-inline">Filter:</span>

            <!-- CATEGORY -->
            <div class="filter-dropdown" data-name="Category">
                <button class="filter-btn">Category <i class="bi bi-chevron-down"></i></button>
                <div class="dropdown-menu">
                    <div data-value="all">All</div>
                    <div data-value="tools">3D Tools</div>
                    <div data-value="decor">Home Decor</div>
                    <div data-value="keychain">Keychains</div>
                    <div data-value="gifting">Gifting</div>
                    <div data-value="action figure">Action figure</div>
                </div>
            </div>

            <!-- PRICE RANGE -->
            <div class="filter-dropdown" data-name="priceRange">
                <button class="filter-btn">Price <i class="bi bi-chevron-down"></i></button>
                <div class="dropdown-menu">
                    <div class="price-panel">
                        <div class="price-heading">
                            <span>Up to</span>
                            <b>₹<span id="priceValue">10000</span></b>
                        </div>
                        <input type="range" min="0" max="10000" step="50" value="10000" id="priceRange">
                        <div class="price-apply-row">
                            <button type="button" class="price-reset-btn" id="priceResetBtn">Reset</button>
                            <button type="button" class="price-apply-btn" id="priceApplyBtn">Apply</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SORT -->
            <div class="sort-box filter-dropdown" data-name="sort">
                <button class="filter-btn">Sort by <i class="bi bi-chevron-down"></i></button>
                <div class="dropdown-menu">
                    <div data-value="az">A-Z</div>
                    <div data-value="za">Z-A</div>
                    <div data-value="low">Price: Low → High</div>
                    <div data-value="high">Price: High → Low</div>
                </div>
            </div>

            <!-- CLEAR -->
            <button id="clearFilters" class="clear-btn">Clear</button>
        </div>

        <!-- RIGHT -->
        <div class="d-flex align-items-center gap-3 filter-row-right">
            <span class="product-count" id="productCount">
                {{ count($products ?? []) }} products
            </span>
        </div>
    </div>

    <!-- ACTIVE FILTER CHIPS -->
    <div class="active-filters mt-2" id="activeFilters"></div>
</div>

<!-- PRODUCTS -->

<div class="container mt-4">
    <div id="productGrid">
        @foreach($products as $product)

        <div
            class="product-item"
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
                        <img loading="lazy" decoding="async" src="/product_images/{{ $product->image }}" />
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
                                @if(isset($product->discount) && $product->discount > 0)
                                @php $finalPrice = round($product->price - ($product->price * $product->discount / 100)); @endphp
                                <span class="old">₹{{ $product->price }}</span>
                                <span class="new">₹{{ $finalPrice }}</span>
                                <span class="discount-badge">{{ $product->discount }}% OFF</span>
                                @else
                                <span class="new">₹{{ $product->price }}</span>
                                @endif
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
                            @if(isset($product->discount) && $product->discount > 0)
                            @php $finalMd = round($product->price - ($product->price * $product->discount / 100)); @endphp
                            <span style="text-decoration:line-through;color:var(--ink-soft,#6B6B65);font-size:13px;font-family:var(--font-mono,monospace);">₹{{ $product->price }}</span>
                            ₹{{ $finalMd }}
                            <span style="font-size:11px;font-weight:700;background:var(--accent,#FF5A1F);color:#fff;padding:2px 7px;border-radius:2px;">{{ $product->discount }}% OFF</span>
                            @else
                            ₹{{ $product->price }}
                            @endif
                        </div>

                        <p class="desc-md">
                            {{ Str::limit($product->description, 100) }}
                        </p>

                        <div class="delivery-md mb-3">
                            <i class="bi bi-truck"></i> Delivery in 2–4 days
                        </div>

                        <!-- BUTTONS -->
                        <div class="d-flex gap-2 flex-wrap">
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
        price: null,      // "low" | "high" (kept for sort compatibility)
        maxPrice: null,    // numeric cap from the price-range panel
        sort: null,
    };

    // TOGGLE DROPDOWN (closes any other open one first)
document.querySelectorAll(".filter-btn").forEach((btn) => {
    btn.addEventListener("click", function (e) {
        e.stopPropagation();
        let parent = this.parentElement;
        let menu = parent.querySelector(".dropdown-menu");
        let willOpen = !parent.classList.contains("open");

        // close everything + reset any inline positioning first
        document.querySelectorAll(".filter-dropdown").forEach((d) => {
            d.classList.remove("open");
            let m = d.querySelector(".dropdown-menu");
            if (m) {
                m.style.position = "";
                m.style.top = "";
                m.style.left = "";
                m.style.right = "";
            }
        });

        if (willOpen) {
            parent.classList.add("open");

            // reposition as fixed so the horizontally-scrolling
            // filter bar can never clip it
            let rect = btn.getBoundingClientRect();
            menu.style.position = "fixed";
            menu.style.top = (rect.bottom + 8) + "px";

            if (parent.classList.contains("sort-box")) {
                // align dropdown's right edge to the button's right edge
                menu.style.left = "auto";
                menu.style.right = (window.innerWidth - rect.right) + "px";
            } else {
                menu.style.left = rect.left + "px";
                menu.style.right = "auto";
            }
        }
    });
});

    // SELECT VALUE (category / sort — price panel handled separately below)
    document.querySelectorAll(".dropdown-menu > div[data-value]").forEach((item) => {
        item.addEventListener("click", function () {
            let parent = this.closest(".filter-dropdown");
            let type = parent.dataset.name.toLowerCase();
            let value = this.dataset.value;

            filters[type] = value;

            parent.classList.add("active");
            parent.querySelector(".filter-btn").innerHTML =
                this.innerText + ' <i class="bi bi-chevron-down"></i>';

            parent.classList.remove("open");

            updateChips();
            applyFilters();
        });
    });

    // PRICE RANGE PANEL
    const priceRangeInput = document.getElementById("priceRange");
    const priceValueLabel = document.getElementById("priceValue");
    const priceDropdown = document.querySelector('.filter-dropdown[data-name="priceRange"]');

    priceRangeInput.addEventListener("input", function () {
        priceValueLabel.innerText = this.value;
    });

    document.getElementById("priceApplyBtn").addEventListener("click", function () {
        filters.maxPrice = parseInt(priceRangeInput.value, 10);

        priceDropdown.classList.add("active");
        priceDropdown.querySelector(".filter-btn").innerHTML =
            "Up to ₹" + filters.maxPrice + ' <i class="bi bi-chevron-down"></i>';

        priceDropdown.classList.remove("open");

        updateChips();
        applyFilters();
    });

    document.getElementById("priceResetBtn").addEventListener("click", function () {
        filters.maxPrice = null;
        priceRangeInput.value = 10000;
        priceValueLabel.innerText = "10000";

        priceDropdown.classList.remove("active");
        priceDropdown.querySelector(".filter-btn").innerHTML =
            'Price <i class="bi bi-chevron-down"></i>';

        priceDropdown.classList.remove("open");

        updateChips();
        applyFilters();
    });

    // APPLY FILTER LOGIC
    function applyFilters() {
    let products = document.querySelectorAll(".product-item");
    let visibleCount = 0;

    products.forEach((product) => {
        let category = product.dataset.category;
        let price = parseFloat(product.dataset.price);

        let show = true;

        // CATEGORY FILTER — use "includes" so "tools" matches "3d tools",
        // "decor" matches "home decor", "keychain" matches "keychains", etc.
        if (filters.category && filters.category !== "all") {
            if (!category.includes(filters.category)) {
                show = false;
            }
        }

        // PRICE RANGE FILTER
        if (filters.maxPrice !== null && price > filters.maxPrice) {
            show = false;
        }

        product.style.display = show ? "" : "none";

        if (show) visibleCount++;
    });

    // ...rest unchanged
        // SORTING
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

        let chipLabels = {
            category: (v) => "Category: " + v,
            maxPrice: (v) => "Up to ₹" + v,
            sort: (v) => "Sort: " + v,
        };

        ["category", "maxPrice", "sort"].forEach((key) => {
            if (filters[key]) {
                let chip = document.createElement("div");
                chip.className = "filter-chip";
                chip.innerText = chipLabels[key](filters[key]) + " ✕";

                chip.onclick = () => {
                    filters[key] = null;

                    if (key === "maxPrice") {
                        priceRangeInput.value = 10000;
                        priceValueLabel.innerText = "10000";
                        priceDropdown.classList.remove("active");
                        priceDropdown.querySelector(".filter-btn").innerHTML =
                            'Price <i class="bi bi-chevron-down"></i>';
                    } else {
                        let dd = document.querySelector(
                            `.filter-dropdown[data-name="${key === 'category' ? 'Category' : key}"]`
                        );
                        if (dd) {
                            dd.classList.remove("active");
                            let label = key === "category" ? "Category" : "Sort by";
                            dd.querySelector(".filter-btn").innerHTML =
                                label + ' <i class="bi bi-chevron-down"></i>';
                        }
                    }

                    updateChips();
                    applyFilters();
                };

                container.appendChild(chip);
            }
        });
    }

    // CLEAR FILTERS
    document.getElementById("clearFilters").addEventListener("click", () => {
        filters = { category: null, price: null, maxPrice: null, sort: null };

        priceRangeInput.value = 10000;
        priceValueLabel.innerText = "10000";

        document.querySelectorAll(".filter-dropdown").forEach((d) => {
            d.classList.remove("active");
            d.classList.remove("open");
            let name = d.dataset.name;
            let label = name === "Category" ? "Category" : (name === "priceRange" ? "Price" : "Sort by");
            d.querySelector(".filter-btn").innerHTML = label + ' <i class="bi bi-chevron-down"></i>';
        });

        updateChips();
        applyFilters();
    });

    document.querySelectorAll(".addToCart").forEach((btn) => {
        btn.addEventListener("click", function (e) {
            let card = this.closest(".product-card");
            let img = card.querySelector("img");
            let cartIcon = document.querySelector(".bi-cart3, .bi-cart");
            let cart = cartIcon ? cartIcon.getBoundingClientRect() : { top: 20, left: 20 };

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

            this.classList.toggle('active', data.status === 'added');
            this.innerHTML = data.status === 'added'
                ? '<i class="bi bi-heart-fill"></i>'
                : '<i class="bi bi-heart"></i>';

        });

    });

});
</script>

@endsection