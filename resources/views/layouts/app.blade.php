<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <script src="https://cdn.jsdelivr.net/npm/three@0.152.2/build/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.152.2/examples/js/loaders/STLLoader.js"></script> -->
<!-- ----------192.168.29.143----------- -->
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

<title>AD-VANCE 3D</title>

<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- BOOTSTRAP -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- BOOTSTRAP ICONS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">


<style>

/* ================= GLOBAL ================= */

:root{
  /* ---- color ---- */
  --bg:        #FAFAF8;
  --bg-raised: #FFFFFF;
  --ink:       #1A1A1A;
  --ink-soft:  #6B6B65;
  --hairline:  #E8E6E0;
  --accent:    #FF5A1F;
  --accent-ink:#7A2B0E;   /* accent text on light accent fill */
  --accent-50: #FFF1EA;

  /* dark mode */
  --bg-dark:        #0F0F0F;
  --bg-raised-dark: #1A1A19;
  --ink-dark:        #F2F1ED;
  --ink-soft-dark:   #9B9A92;
  --hairline-dark:   #2C2C29;
  --accent-50-dark:  #2A1A12;

  /* ---- type ---- */
  --font-display: 'Space Grotesk', sans-serif;
  --font-body: 'Inter', sans-serif;
  --font-mono: 'JetBrains Mono', monospace;

  /* ---- layout ---- */
  --radius: 3px;
  --nav-h: 72px;
  --container: 1180px;
}

*{ box-sizing:border-box; }

html{ scroll-behavior:smooth; }

body{
  margin:0;
  background:var(--bg);
  color:var(--ink);
  font-family:var(--font-body);
  -webkit-font-smoothing:antialiased;
  transition:background .35s ease, color .35s ease;
}

body.dark-mode{
  background:var(--bg-dark);
  color:var(--ink-dark);
}

.wrap{ max-width:var(--container); margin:0 auto; padding:0 32px; }

img{ max-width:100%; display:block; }

a{ color:inherit; text-decoration:none; }

::selection{ background:var(--accent); color:#fff; }

/* =====================================================
   FOOTER
===================================================== */

.footer{
  border-top:1px solid var(--hairline);
  padding:72px 0 32px;
  margin-top:60px;
}
body.dark .footer{ border-top-color:var(--hairline-dark); }

.footer-grid{
  display:grid;
  grid-template-columns:1.6fr 1fr 1fr 1.3fr;
  gap:48px;
  padding-bottom:56px;
}

.footer-brand p{
  font-size:14px;
  color:var(--ink-soft);
  line-height:1.65;
  max-width:280px;
  margin:16px 0 24px;
}
body.dark .footer-brand p{ color:var(--ink-soft-dark); }

.footer h6{
  font-family:var(--font-mono);
  font-size:12px;
  text-transform:uppercase;
  letter-spacing:.05em;
  color:var(--ink-soft);
  margin:0 0 18px;
}
body.dark .footer h6{ color:var(--ink-soft-dark); }

.footer ul{ list-style:none; padding:0; margin:0; }
.footer li{ margin-bottom:11px; }
.footer ul a{
  font-size:14px; color:var(--ink-soft);
  transition:color .2s ease;
}
body.dark .footer ul a{ color:var(--ink-soft-dark); }
.footer ul a:hover{ color:var(--accent); }

.footer-social{ display:flex; gap:12px; }
.footer-social a{
  width:34px; height:34px;
  border:1px solid var(--hairline);
  border-radius:50%;
  display:flex; align-items:center; justify-content:center;
  font-size:14px;
  transition:border-color .2s ease, color .2s ease;
}
body.dark .footer-social a{ border-color:var(--hairline-dark); }
.footer-social a:hover{ border-color:var(--accent); color:var(--accent); }

.footer-newsletter{ display:flex; margin-top:6px; }
.footer-newsletter input{
  flex:1;
  border:1px solid var(--hairline);
  border-right:none;
  background:transparent;
  color:var(--ink);
  padding:11px 14px;
  font-size:13.5px;
  border-radius:var(--radius) 0 0 var(--radius);
  outline:none;
}
body.dark .footer-newsletter input{ border-color:var(--hairline-dark); color:var(--ink-dark); }
.footer-newsletter input::placeholder{ color:var(--ink-soft); }
.footer-newsletter button{
  border:1px solid var(--ink);
  background:var(--ink);
  color:var(--bg);
  padding:0 18px;
  border-radius:0 var(--radius) var(--radius) 0;
  font-size:13px; font-weight:600;
  cursor:pointer;
}
body.dark .footer-newsletter button{ border-color:var(--ink-dark); background:var(--ink-dark); color:var(--bg-dark); }

.footer-bottom{
  border-top:1px solid var(--hairline);
  padding-top:26px;
  display:flex;
  justify-content:space-between;
  align-items:center;
  font-size:13px;
  color:var(--ink-soft);
}
body.dark .footer-bottom{ border-top-color:var(--hairline-dark); color:var(--ink-soft-dark); }

@media (max-width:860px){
  .footer-grid{ grid-template-columns:1fr 1fr; gap:36px; }
  .footer-bottom{ flex-direction:column; gap:10px; text-align:center; }
  .grid{ grid-template-columns:repeat(2,1fr); }
}
@media (max-width:560px){
  .footer-grid{ grid-template-columns:1fr; }
  .grid{ grid-template-columns:1fr; }
  .cart-panel{ width:100%; right:-100%; }
}

/* whatsapp float — kept, restyled to match */
.whatsapp-float{
position:fixed;
bottom:20px;
left:28px;
right:auto;
background:#25D366;
color:white;
width:55px;
height:55px;
display:flex;
align-items:center;
justify-content:center;
border-radius:50%;
font-size:26px;
box-shadow:0 5px 15px rgba(0,0,0,0.2);
z-index:999;
transition:0.3s;
}

.whatsapp-float:hover{
transform:scale(1.1);
color:white;
}

/* ------ */
/* ------ */
 .advance-offcanvas {
        background: #161616;
        color: #F2F0EA;
        width: 290px;
    }
 
    .advance-header {
        border-bottom: none;
        padding: 1.25rem 1.25rem 0.5rem;
    }
 
    .advance-brand {
        color: #F2F0EA;
        text-decoration: none;
        font-size: 15px;
        font-weight: 500;
    }
 
    .text-orange { color: #FF6A2C !important; }
 
    .advance-close {
        filter: invert(1) grayscale(100%) brightness(200%);
        opacity: 0.6;
    }
 
    .advance-body {
        padding: 0.5rem 1.25rem 1.25rem;
    }
 
    .advance-nav {
        display: flex;
        flex-direction: column;
        margin-bottom: 20px;
    }
 
    .advance-link {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 12px 4px;
        color: #D8D6D0 !important;
        font-size: 15px;
        text-decoration: none;
    }
 
    .advance-link i { font-size: 18px; color: #807E78; width: 18px; text-align: center; }
 
    .advance-link.active,
    .advance-link:hover {
        color: #FF6A2C !important;
    }
 
    .advance-link.active i,
    .advance-link:hover i { color: #FF6A2C; }
 
    .advance-count { font-size: 12px; color: #807E78; }
 
    .advance-divider {
        height: 1px;
        background: #242424;
        margin-bottom: 20px;
    }
 
    .advance-account {
        display: flex;
        align-items: center;
        gap: 11px;
        margin-bottom: 22px;
    }
 
    .advance-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #242424;
        color: #D8D6D0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 500;
        flex-shrink: 0;
    }
 
    .advance-account-name { font-size: 13px; color: #F2F0EA; }
    .advance-account-email { font-size: 12px; color: #807E78; }
 
    .advance-action {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 10px 4px;
        color: #D8D6D0;
        font-size: 14px;
        text-decoration: none;
    }
 
    .advance-action:hover { color: #F2F0EA; }
    .advance-action i { font-size: 16px; color: #807E78; }
 
    .advance-action-danger,
    .advance-action-danger i { color: #c47a63; }
    .advance-action-danger:hover { color: #c47a63; }
 
    .advance-login-link {
        display: block;
        text-align: center;
        padding: 10px;
        color: #FF6A2C;
        text-decoration: none;
        font-size: 14px;
    }
 
    .advance-social {
        display: flex;
        justify-content: center;
        gap: 20px;
        padding-top: 16px;
    }
 
    .advance-social a { color: #807E78; text-decoration: none; font-size: 16px; }
    .advance-social a:hover { color: #FF6A2C; }
/* ------ */
/* ------ */
/* ------ */

.object-fit-cover{
object-fit: cover;
}

.table td, .table th{
vertical-align: middle;
}

/* ================= BUTTONS ================= */
@media (max-width: 576px){
    .whatsapp-float{
        width:50px;
        height:50px;
        font-size:22px;
        bottom:15px;
        right:15px;
    }
}
.btn{
transition:0.3s;
border-radius:8px;
position:relative;
overflow:hidden;
}

.btn:hover{
transform:scale(1.05);
}

/* Ripple */
.btn::after{
content:"";
position:absolute;
width:0;
height:0;
background:rgba(255,255,255,0.3);
border-radius:50%;
top:50%;
left:50%;
transform:translate(-50%,-50%);
transition:0.4s;
}

.btn:active::after{
width:200px;
height:200px;
}

/* DARK MODE FIX */
body.dark-mode .brand-text{
    color:white;
}

/* =========================
 NAVBAR RESPONSIVE
========================= */

/* Mobile Navbar */
@media (max-width: 992px){
    .navbar-nav{
        align-items: flex-start !important;
    }
}

@media (max-width:860px){
    .grid{ grid-template-columns:repeat(2,1fr); }
}
@media (max-width:560px){
    .grid{ grid-template-columns:1fr; }
}

</style>


<style>
/* =====================================================
   ADVANCE 3D — MOBILE FIX v2
   Clean bottom nav, no duplicates, no overlaps
===================================================== */

/* ---- GLOBAL ---- */
@media (max-width: 768px) {
    html, body { overflow-x: hidden; }
    .wrap { padding: 0 14px; }
    .container { padding-left: 12px !important; padding-right: 12px !important; }
}

/* ---- NAVBAR ON MOBILE ---- */
@media (max-width: 992px) {
    .nav .wrap { height: 56px; padding: 0 14px; }
    .nav .brand-text { font-size: 15px; }
    .nav .brand-mark { width: 22px; height: 22px; }

    /* Hide cart icon from top navbar on mobile — bottom nav has it */
    .nav .icon-btn[href*="cart"] { display: none !important; }

    /* Keep only: brand + theme toggle on mobile top bar */
    .nav .nav-actions { gap: 8px; }
    .nav .icon-btn { width: 32px; height: 32px; font-size: 14px; }
    .nav .theme-toggle { width: 32px; height: 32px; font-size: 13px; }
}

/* ---- HIDE FLOATING CART ON MOBILE ---- */
@media (max-width: 768px) {
    .floating-cart { display: none !important; }
}

/* ---- WHATSAPP BUTTON — above bottom nav ---- */
@media (max-width: 768px) {
    .whatsapp-float {
        bottom: 70px !important;
        left: 12px !important;
        width: 44px !important;
        height: 44px !important;
        font-size: 20px !important;
    }
}

/* ---- BOTTOM NAV ---- */
.bottom-nav {
    display: none;
}

@media (max-width: 768px) {
    .bottom-nav {
        display: flex;
        position: fixed;
        bottom: 0; left: 0; right: 0;
        height: 58px;
        background: var(--bg-raised, #fff);
        border-top: 1px solid var(--hairline, #E8E6E0);
        z-index: 999;
        align-items: stretch;
        box-shadow: 0 -4px 20px rgba(0,0,0,0.06);
    }
    body.dark-mode .bottom-nav {
        background: var(--bg-raised-dark, #1A1A19);
        border-top-color: var(--hairline-dark, #2C2C29);
    }

    .bottom-nav a {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 2px;
        font-size: 9.5px;
        font-weight: 500;
        color: var(--ink-soft, #9B9A92);
        text-decoration: none;
        transition: color 0.2s;
        position: relative;
        letter-spacing: 0.01em;
    }
    body.dark-mode .bottom-nav a { color: var(--ink-soft-dark, #9B9A92); }

    .bottom-nav a i { font-size: 19px; line-height: 1; }

    .bottom-nav a.active { color: var(--accent, #FF5A1F); }
    .bottom-nav a:hover { color: var(--accent, #FF5A1F); }

    .bottom-nav a.active i {
        transform: scale(1.1);
    }

    /* Active indicator dot */
    .bottom-nav a.active::before {
        content: "";
        position: absolute;
        top: 0; left: 50%;
        transform: translateX(-50%);
        width: 20px; height: 2px;
        background: var(--accent, #FF5A1F);
        border-radius: 0 0 3px 3px;
    }

    .bnav-badge {
        position: absolute;
        top: 5px;
        left: calc(50% + 6px);
        background: var(--accent, #FF5A1F);
        color: #fff;
        font-size: 8px;
        min-width: 14px; height: 14px;
        border-radius: 99px;
        display: flex; align-items: center; justify-content: center;
        padding: 0 3px;
        font-family: var(--font-mono, monospace);
        font-weight: 700;
        line-height: 1;
    }

    /* Push page content above bottom nav */
    main { padding-bottom: 66px !important; }
    .footer { margin-bottom: 58px !important; }
}

/* ---- HERO SECTION MOBILE ---- */
@media (max-width: 768px) {
    .hero-3d { min-height: calc(100svh - 56px); padding: 40px 16px 80px; }
    .hero-title { font-size: clamp(1.8rem, 9vw, 3rem) !important; letter-spacing: -0.02em !important; }
    .hero-sub { font-size: 13.5px !important; padding: 0 8px; }
    .hero-btns { flex-direction: column; align-items: stretch; gap: 10px; padding: 0 8px; }
    .btn-hero-primary, .btn-hero-outline { width: 100%; max-width: none; justify-content: center; }
    .hero-stats { gap: 16px; flex-wrap: wrap; justify-content: center; }
    .hero-stat-num { font-size: 1.3rem; }
    .hero-stat-label { font-size: 9px; }
    .hero-badge { font-size: 10px; padding: 4px 12px; }
    .scroll-hint { display: none; }
}

/* ---- PRODUCT GRID MOBILE ---- */
@media (max-width: 768px) {
    /* 2 columns */
    #productGrid .col-6 { padding-left: 6px !important; padding-right: 6px !important; }
    #productGrid .row { margin-left: -6px !important; margin-right: -6px !important; }
    .premium-img { height: 155px !important; }
    .product-title { font-size: 12px !important; line-height: 1.3; }
    .price .new { font-size: 13px !important; }
    .price .old { font-size: 10px !important; }
    .discount-badge { font-size: 9px !important; padding: 1px 5px !important; }
    .badge-new { font-size: 8px !important; padding: 2px 6px !important; top: 8px; left: 8px; }
    .wishlist { width: 28px !important; height: 28px !important; font-size: 12px !important; top: 8px; right: 8px; }
    .quick-view-btn { display: none !important; }
    .card-body { padding: 10px 10px 12px !important; }
    .rating { font-size: 12px !important; }
    .gap-2.d-flex .btn-dark { font-size: 11px !important; padding: 7px 6px !important; }
    .gap-2.d-flex .btn-success { padding: 7px 10px !important; }
}

/* ---- FILTER BAR MOBILE ---- */
@media (max-width: 768px) {
    .filter-top { gap: 10px !important; }
    .filter-top > div:first-child { flex-wrap: wrap; gap: 6px !important; }
    .filter-btn { font-size: 11.5px !important; padding: 6px 10px !important; }
    .product-count { font-size: 11px !important; }
}

/* ---- PRODUCTS HERO ---- */
@media (max-width: 768px) {
    .products-hero { height: 180px !important; }
    .products-hero h1 { font-size: 18px !important; }
    .products-hero p { font-size: 12px; }
}

/* ---- WHY / PROCESS / SERVICES ---- */
@media (max-width: 768px) {
    .why-grid,
    .services-grid { grid-template-columns: 1fr !important; gap: 10px !important; }
    .why-card, .svc-card { padding: 18px 14px !important; }
    .process-steps { grid-template-columns: 1fr 1fr !important; gap: 28px !important; }
    .process-steps::before { display: none !important; }
    .why-section, .products-section, .process-section,
    .gallery-section, .services-section,
    .testimonials-section, .faq-section { padding: 48px 0 !important; }
    .cta-section { padding: 56px 0 !important; }
}

/* ---- STATS ---- */
@media (max-width: 768px) {
    .stats-band { padding: 36px 0 !important; }
    .stats-row { grid-template-columns: 1fr 1fr !important; }
    .stat-num { font-size: 1.6rem !important; }
    .stat-item { padding: 12px !important; border-right-color: rgba(255,255,255,0.15) !important; }
}

/* ---- TESTIMONIALS / FAQ ---- */
@media (max-width: 768px) {
    .testi-grid { grid-template-columns: 1fr !important; }
    .faq-grid { grid-template-columns: 1fr !important; }
}

/* ---- LAB GALLERY ---- */
@media (max-width: 768px) {
    .lab-grid {
        grid-template-columns: 1fr 1fr !important;
        grid-auto-rows: 120px !important;
        gap: 8px !important;
    }
    .lab-item.big { grid-column: span 2 !important; }
}

/* ---- SECTION TITLE ---- */
@media (max-width: 768px) {
    .section-title { font-size: 1.35rem !important; }
    .section-sub { font-size: 13px !important; }
    .cta-content h2 { font-size: 1.6rem !important; }
    .cta-content p { font-size: 13px; }
}

/* ---- CART PAGE ---- */
@media (max-width: 768px) {
    .cart-table thead { display: none; }
    .cart-table tbody tr {
        display: block;
        border-bottom: 1px solid var(--hairline, #E8E6E0) !important;
        padding: 12px 0;
    }
    .cart-table tbody td {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 3px 12px !important;
        border: none !important;
        font-size: 13px;
    }
    .cart-thumb { width: 48px !important; height: 48px !important; }
    .cart-product-name { font-size: 13px !important; }
    .cart-actions { align-items: stretch !important; }
    .btn-cart-secondary,
    .btn-cart-primary,
    .btn-cart-whatsapp { max-width: none !important; font-size: 13px !important; }
    .cart-total-value { font-size: 1.3rem !important; }
    .qty-input-cart { width: 52px !important; }
}

/* ---- CART SIDEBAR MOBILE ---- */
@media (max-width: 768px) {
    .cart-sidebar {
        width: 100% !important;
        right: auto !important;
        left: 0 !important;
        top: auto !important;
        bottom: -100% !important;
        height: 80vh;
        border-radius: 20px 20px 0 0;
        border-left: none !important;
        border-top: 1px solid var(--hairline, #E8E6E0) !important;
        transition: bottom 0.35s cubic-bezier(.16,.84,.44,1) !important;
    }
    .cart-sidebar.open {
        bottom: 58px !important;
        right: auto !important;
    }
    body.dark-mode .cart-sidebar {
        border-top-color: var(--hairline-dark, #2C2C29) !important;
    }
}

/* ---- PRODUCT DETAIL ---- */
@media (max-width: 768px) {
    .main-image-box { height: 250px !important; }
    .thumb-img { width: 50px !important; height: 50px !important; }
    .product-name { font-size: 1.15rem !important; }
    .product-price-main { font-size: 1.25rem !important; }
    .col-md-6.text-center { margin-bottom: 8px; }
}

/* ---- FOOTER MOBILE ---- */
@media (max-width: 768px) {
    .footer { padding: 36px 0 16px; }
    .footer-grid { grid-template-columns: 1fr !important; gap: 20px !important; padding-bottom: 28px; }
    .footer-bottom { flex-direction: column; gap: 6px; text-align: center; font-size: 11px; }
    .footer h6 { margin-bottom: 10px; }
    .footer li { margin-bottom: 7px; }
    .footer-newsletter { flex-direction: column; gap: 8px; }
    .footer-newsletter input { border-radius: 3px !important; border-right: 1px solid var(--hairline, #E8E6E0) !important; }
    .footer-newsletter button { border-radius: 3px !important; padding: 10px; }
    .footer-social { gap: 10px; }
}

/* ---- AUTH PAGES ---- */
@media (max-width: 768px) {
    .auth-wrapper { padding: 0.8rem !important; align-items: flex-start; padding-top: 2rem !important; }
    .auth-card { padding: 1.4rem 1rem !important; border-radius: 12px !important; }
    .social-row { grid-template-columns: 1fr !important; }
    .row-2 { grid-template-columns: 1fr !important; }
}

/* ---- ADMIN FORMS ---- */
@media (max-width: 768px) {
    .field-row { grid-template-columns: 1fr !important; gap: 10px !important; }
    .admin-card.form-card { padding: 14px !important; }
    .product-box-body { padding: 14px !important; }
    .image-box .img-preview { height: 120px !important; }
}

/* ---- WISHLIST MOBILE ---- */
@media (max-width: 768px) {
    .wishlist-img { width: 58px !important; height: 58px !important; }
    .wishlist-info .name { font-size: 13px !important; }
    .wishlist-item { padding: 10px 12px !important; gap: 10px !important; }
}

/* ---- MODAL ---- */
@media (max-width: 768px) {
    .modal-dialog { margin: 6px !important; }
    .modal-body { padding: 14px !important; }
    .main-img-md { height: 160px !important; }
    .quick-modal-md .col-md-5,
    .quick-modal-md .col-md-7 { width: 100% !important; }
}

/* ---- TICKER ---- */
@media (max-width: 768px) {
    .ticker-item { font-size: 9.5px !important; padding: 0 14px !important; }
}

</style>

</head>


<body>

<!-- =====================================================
   AD-VANCE 3D — modern/minimal restyle
   Loader · Floating cart · Cart sidebar · Navbar · Mobile nav
   All Blade logic, route() calls, IDs, and JS hooks preserved.

   Paste the <style> block into your existing stylesheet.
   It reuses the --bg / --ink / --accent / --font-* tokens
   from layout.blade.php — make sure those :root vars exist
   on the page (they're defined once in layout.blade.php's
   main <style> block, so this works automatically there).
===================================================== -->

<style>

/* ---- LOADER ---- */
#pageLoader{
    position:fixed;
    inset:0;
    background:var(--bg-dark, #0F0F0F);
    z-index:9999;
    display:flex;
    align-items:center;
    justify-content:center;
    flex-direction:column;
    gap:18px;
}
#pageLoader .spinner{
    width:32px; height:32px;
    border:2px solid rgba(255,255,255,0.12);
    border-top:2px solid var(--accent, #FF5A1F);
    border-radius:50%;
    animation:pl-spin 0.85s linear infinite;
}
@keyframes pl-spin{ to{ transform:rotate(360deg); } }
#pageLoader h5{
    margin:0;
    font-family:var(--font-mono, monospace);
    font-size:11.5px;
    text-transform:uppercase;
    letter-spacing:.08em;
    color:#9B9A92;
    font-weight:500;
}

/* ---- FLOATING CART BUTTON ---- */
.floating-cart{
    position:fixed;
    bottom:28px; right:28px;
    width:52px; height:52px;
    border-radius:50%;
    background:var(--ink, #1A1A1A);
    color:var(--bg, #FAFAF8);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:19px;
    cursor:pointer;
    z-index:998;
    box-shadow:0 8px 24px rgba(0,0,0,0.16);
    transition:transform .2s ease, background .2s ease;
}
.floating-cart:hover{ transform:scale(1.06); background:var(--accent, #FF5A1F); color:#fff; }
body.dark-mode .floating-cart{ background:var(--ink-dark, #F2F1ED); color:var(--bg-dark, #0F0F0F); }
body.dark-mode .floating-cart:hover{ background:var(--accent, #FF5A1F); color:#fff; }

.floating-cart span{
    position:absolute;
    top:-4px; right:-4px;
    background:var(--accent, #FF5A1F);
    color:#fff;
    font-family:var(--font-mono, monospace);
    font-size:10px;
    min-width:18px; height:18px;
    display:flex; align-items:center; justify-content:center;
    padding:0 4px;
    border-radius:50%;
    line-height:1;
}

/* ---- CART SIDEBAR ---- */
.cart-sidebar{
    position:fixed;
    top:0; right:-360px;
    width:340px;
    height:100%;
    background:var(--bg-raised, #fff);
    border-left:1px solid var(--hairline, #E8E6E0);
    box-shadow:-10px 0 30px rgba(0,0,0,0.08);
    z-index:9999;
    transition:right .35s cubic-bezier(.16,.84,.44,1);
    display:flex;
    flex-direction:column;
    padding:0 !important; /* override Bootstrap .p-3 */
}
.cart-sidebar.open{ right:0; }
body.dark-mode .cart-sidebar{ background:var(--bg-raised-dark, #1A1A19); border-left-color:var(--hairline-dark, #2C2C29); }

.cart-sidebar .cart-head{
    padding:24px 24px 18px;
    border-bottom:1px solid var(--hairline, #E8E6E0);
    display:flex; align-items:center; justify-content:space-between;
}
body.dark-mode .cart-sidebar .cart-head{ border-bottom-color:var(--hairline-dark, #2C2C29); }

.cart-sidebar h5{
    margin:0;
    font-family:var(--font-display, sans-serif);
    font-weight:600;
    font-size:17px;
    color:var(--ink, #1A1A1A);
}
body.dark-mode .cart-sidebar h5{ color:var(--ink-dark, #F2F1ED); }

.cart-sidebar .cart-close{
    width:30px; height:30px;
    border-radius:50%;
    border:1px solid var(--hairline, #E8E6E0);
    background:transparent;
    color:var(--ink-soft, #6B6B65);
    font-size:13px;
    display:flex; align-items:center; justify-content:center;
    cursor:pointer;
    transition:border-color .2s ease, color .2s ease;
}
.cart-sidebar .cart-close:hover{ border-color:var(--accent, #FF5A1F); color:var(--accent, #FF5A1F); }
body.dark-mode .cart-sidebar .cart-close{ border-color:var(--hairline-dark, #2C2C29); color:var(--ink-soft-dark, #9B9A92); }

#cartItems{
    flex:1;
    overflow-y:auto;
    padding:8px 24px;
}
#cartItems p{
    font-size:13.5px;
    color:var(--ink-soft, #6B6B65);
    text-align:center;
    margin-top:24px;
}
#cartItems > div{
    padding:14px 0;
    border-bottom:1px solid var(--hairline, #E8E6E0);
    position:relative;
}
body.dark-mode #cartItems > div{ border-bottom-color:var(--hairline-dark, #2C2C29); }

/* layer-line texture on hover — one deliberate nod to FDM printing */
#cartItems > div:hover::before{
    content:"";
    position:absolute; inset:0;
    background-image:repeating-linear-gradient(to bottom, var(--accent,#FF5A1F) 0px, var(--accent,#FF5A1F) 1px, transparent 1px, transparent 6px);
    opacity:0.05;
    pointer-events:none;
}

#cartItems img{
    border-radius:3px;
    background:var(--accent-50, #FFF1EA);
    object-fit:cover;
}
body.dark-mode #cartItems img{ background:var(--accent-50-dark, #2A1A12); }

#cartItems small{
    font-family:var(--font-mono, monospace);
    color:var(--ink-soft, #6B6B65);
    font-size:12px;
}
body.dark-mode #cartItems small{ color:var(--ink-soft-dark, #9B9A92); }

.cart-sidebar .cart-foot{
    padding:20px 24px 24px;
    border-top:1px solid var(--hairline, #E8E6E0);
}
body.dark-mode .cart-sidebar .cart-foot{ border-top-color:var(--hairline-dark, #2C2C29); }

.cart-sidebar .btn-primary{
    display:flex; align-items:center; justify-content:center;
    width:100%;
    background:var(--ink, #1A1A1A);
    color:var(--bg, #FAFAF8);
    border:1px solid var(--ink, #1A1A1A);
    border-radius:3px;
    font-weight:600;
    font-size:14px;
    padding:13px;
    transition:background .2s ease, border-color .2s ease;
}
.cart-sidebar .btn-primary:hover{ background:var(--accent, #FF5A1F); border-color:var(--accent, #FF5A1F); }
body.dark-mode .cart-sidebar .btn-primary{ background:var(--ink-dark, #F2F1ED); color:var(--bg-dark, #0F0F0F); border-color:var(--ink-dark, #F2F1ED); }

.cart-scrim{
    position:fixed; inset:0;
    background:rgba(20,18,15,0.32);
    z-index:1099;
    opacity:0;
    pointer-events:none;
    transition:opacity .3s ease;
}
.cart-scrim.open{ opacity:1; pointer-events:auto; }

/* ---- NAVBAR ---- */
.nav{
    position:sticky;
    top:0;
    z-index:1000;
    background:rgba(250,250,248,0.82);
    backdrop-filter:blur(14px);
    -webkit-backdrop-filter:blur(14px);
    border-bottom:1px solid var(--hairline, #E8E6E0);
    transition:background .35s ease, border-color .35s ease;
    padding:0 15px;
}
body.dark-mode .nav{ background:rgba(15,15,15,0.78); border-bottom-color:var(--hairline-dark, #2C2C29); }

.nav .wrap{ width:100%; max-width:1180px; margin:0 auto; height:72px; display:flex; align-items:center; justify-content:space-between; gap:24px; box-sizing:border-box; }

.nav .brand{ display:flex; align-items:center; gap:10px; }
.nav .brand-mark{
    width:28px; height:28px;
    border:1.5px solid var(--ink, #1A1A1A);
    border-radius:50%;
    position:relative;
    flex-shrink:0;
}
body.dark-mode .nav .brand-mark{ border-color:var(--ink-dark, #F2F1ED); }
.nav .brand-mark::before{
    content:"";
    position:absolute; inset:5px;
    border:1.5px solid var(--accent, #FF5A1F);
    border-radius:50%;
}
.nav .brand-text{
    font-family:var(--font-display, sans-serif);
    font-weight:600;
    font-size:18px;
    letter-spacing:-0.01em;
    color:var(--ink, #1A1A1A);
}
body.dark-mode .nav .brand-text{ color:var(--ink-dark, #F2F1ED); }
.nav .text-orange{ color:var(--accent, #FF5A1F); }

.nav .nav-links{ display:flex; align-items:center; gap:30px; list-style:none; margin:0; padding:0; }
.nav .nav-links a{
    font-size:16px; font-weight:500;
    color:var(--ink-soft, #6B6B65);
    display:flex; align-items:center; gap:8px;
    transition:color .2s ease;
    position:relative; padding:6px 0;
}
.nav .nav-links a:hover{ color:var(--ink, #1A1A1A); }
body.dark-mode .nav .nav-links a{ color:var(--ink-soft-dark, #9B9A92); }
body.dark-mode .nav .nav-links a:hover{ color:var(--ink-dark, #F2F1ED); }
.nav .nav-links a::after{
    content:""; position:absolute; left:0; bottom:-3px; width:0; height:1px;
    background:var(--accent, #FF5A1F); transition:width .25s ease;
}
.nav .nav-links a:hover::after{ width:100%; }

.nav .nav-actions{ display:flex; align-items:center; gap:16px; }

.nav .icon-btn{
    position:relative;
    width:36px; height:36px;
    border-radius:50%;
    border:1px solid var(--hairline, #E8E6E0);
    display:flex; align-items:center; justify-content:center;
    font-size:15px;
    color:var(--ink, #1A1A1A);
    background:transparent;
    transition:border-color .2s ease, transform .15s ease;
}
.nav .icon-btn:hover{ border-color:var(--accent, #FF5A1F); transform:translateY(-1px); }
body.dark-mode .nav .icon-btn{ border-color:var(--hairline-dark, #2C2C29); color:var(--ink-dark, #F2F1ED); }

.nav .cart-badge{
    position:absolute; top:-5px; right:-8px;
    background:var(--accent, #FF5A1F); color:#fff;
    font-family:var(--font-mono, monospace); font-size:10px;
    min-width:16px; height:16px;
    border-radius:50%;
    display:flex; align-items:center; justify-content:center;
    line-height:1;
}

.nav .theme-toggle{
    width:36px; height:36px;
    border-radius:50%;
    border:1px solid var(--hairline, #E8E6E0);
    background:transparent;
    color:var(--ink, #1A1A1A);
    font-size:15px;
    display:flex; align-items:center; justify-content:center;
    transition:border-color .2s ease, transform .25s ease;
}
.nav .theme-toggle:hover{ border-color:var(--accent, #FF5A1F); transform:rotate(20deg); }
body.dark-mode .nav .theme-toggle{ border-color:var(--hairline-dark, #2C2C29); color:var(--ink-dark, #F2F1ED); }

.nav .btn-login{
    font-size:13.5px; font-weight:600;
    padding:9px 18px;
    border:1px solid var(--ink, #1A1A1A);
    border-radius:3px;
    color:var(--ink, #1A1A1A);
    transition:background .2s ease, color .2s ease;
}
.nav .btn-login:hover{ background:var(--ink, #1A1A1A); color:var(--bg, #FAFAF8); }
body.dark-mode .nav .btn-login{ border-color:var(--ink-dark, #F2F1ED); color:var(--ink-dark, #F2F1ED); }
body.dark-mode .nav .btn-login:hover{ background:var(--ink-dark, #F2F1ED); color:var(--bg-dark, #0F0F0F); }

.nav .user-trigger{
    font-size:14px; font-weight:500;
    color:var(--ink-soft, #6B6B65);
    display:flex; align-items:center; gap:6px;
    transition:color .2s ease;
}
.nav .user-trigger:hover{ color:var(--ink, #1A1A1A); }
body.dark-mode .nav .user-trigger{ color:var(--ink-soft-dark, #9B9A92); }

.nav .dropdown-menu{
    border:1px solid var(--hairline, #E8E6E0);
    border-radius:3px;
    box-shadow:0 12px 32px rgba(0,0,0,0.08);
    font-size:14px;
    padding:8px;
    margin-top:10px !important;
}
body.dark-mode .nav .dropdown-menu{ background:var(--bg-raised-dark, #1A1A19); border-color:var(--hairline-dark, #2C2C29); }
.nav .dropdown-item{ border-radius:3px; padding:9px 12px; transition:.15s ease; }
.nav .dropdown-item:hover{ background:var(--accent-50, #FFF1EA); }
body.dark-mode .nav .dropdown-item{ color:var(--ink-soft-dark, #9B9A92); }
body.dark-mode .nav .dropdown-item:hover{ background:var(--accent-50-dark, #2A1A12); color:var(--ink-dark, #F2F1ED); }

@media (max-width:992px){
    .nav .nav-links{ display:none !important; }
    .nav .btn-login{ display:none !important; }
    .nav .user-trigger{ display:none !important; }
}

/* ---- MOBILE OFFCANVAS (advance-offcanvas is the single source of truth
       for the mobile drawer's look — see head <style>. No overrides here.) ---- */

.social-bottom{ border-top:1px solid var(--hairline, #E8E6E0); padding-top:18px; }
body.dark-mode .social-bottom{ border-color:var(--hairline-dark, #2C2C29); }
.social-bottom a{
    width:34px; height:34px;
    border:1px solid var(--hairline, #E8E6E0);
    border-radius:50%;
    display:inline-flex; align-items:center; justify-content:center;
    color:var(--ink-soft, #6B6B65);
    transition:border-color .2s ease, color .2s ease;
}
.social-bottom a:hover{ border-color:var(--accent, #FF5A1F); color:var(--accent, #FF5A1F); }
body.dark-mode .social-bottom a{ border-color:var(--hairline-dark, #2C2C29); color:var(--ink-soft-dark, #9B9A92); }

/* =====================================================
   MOBILE UX PATCH
   Safe areas (notch / home-indicator), real tap targets,
   no blue tap-flash, tidier stacking of the fixed elements.
===================================================== */

/* Kill the grey tap-flash and make taps feel instant everywhere */
a, button, .btn, .icon-btn, .theme-toggle, .bottom-nav a, .whatsapp-float, .floating-cart{
    -webkit-tap-highlight-color: transparent;
    touch-action: manipulation;
}

@media (max-width: 768px){

    /* ---- Respect the iPhone home-indicator / Android gesture bar ---- */
    .bottom-nav{
        height: calc(58px + env(safe-area-inset-bottom));
        padding-bottom: env(safe-area-inset-bottom);
    }
    main{ padding-bottom: calc(66px + env(safe-area-inset-bottom)) !important; }
    .footer{ margin-bottom: calc(58px + env(safe-area-inset-bottom)) !important; }

    .whatsapp-float{
        bottom: calc(70px + env(safe-area-inset-bottom)) !important;
    }

    .cart-sidebar.open{
        bottom: calc(58px + env(safe-area-inset-bottom)) !important;
    }

    /* ---- Real 44px+ tap targets (Apple/Google minimum) ---- */
    .bottom-nav a{ min-height: 48px; }
    .nav .icon-btn, .nav .theme-toggle{ width: 40px !important; height: 40px !important; }
    .wishlist{ width: 34px !important; height: 34px !important; }
    .gap-2.d-flex .btn-dark,
    .gap-2.d-flex .btn-success{ min-height: 40px !important; }
    .filter-btn{ min-height: 36px; }

    /* ---- Bottom-nav polish: bounce on tap, clearer active state ---- */
    .bottom-nav a:active i{ transform: scale(0.88); }
    .bottom-nav a i{ transition: transform .15s ease; }

    /* ---- Prevent horizontal scroll from any stray wide element ---- */
    #productGrid, .why-grid, .services-grid, .testi-grid, .lab-grid{ max-width: 100%; }

    /* ---- Cart-sidebar sheet: add a drag-handle affordance ---- */
    .cart-sidebar::before{
        content:"";
        position:absolute;
        top:8px; left:50%;
        transform:translateX(-50%);
        width:36px; height:4px;
        border-radius:99px;
        background:var(--hairline, #E8E6E0);
    }
    body.dark-mode .cart-sidebar::before{ background:var(--hairline-dark, #2C2C29); }
    .cart-sidebar .cart-head{ padding-top:20px; }

    /* ---- Mobile drawer (advance-offcanvas): width + safe-area only ---- */
    .advance-offcanvas{
        width: min(290px, 82vw) !important;
        padding-bottom: env(safe-area-inset-bottom);
    }
}

</style>

<!-- ===========================
LOADER
=========================== -->
<div id="pageLoader">
    <div class="loader-content">
        <div class="spinner"></div>
        <h5>Loading AD-VANCE 3D...</h5>
    </div>
</div>

<!-- ===========================
FLOATING CART BUTTON
=========================== -->
<div class="floating-cart" onclick="toggleCart()">
    <i class="bi bi-cart"></i>
    <span id="floatingCartCount">
        {{ session('cart') ? count(session('cart')) : 0 }}
    </span>
</div>

<!-- ===========================
CART SIDEBAR
=========================== -->
<div id="cartSidebar" class="cart-sidebar">

    <div class="cart-head">
        <h5>My Cart</h5>
        <button onclick="toggleCart()" class="cart-close" aria-label="Close cart">✕</button>
    </div>

    <div id="cartItems"></div>

    <div class="cart-foot">
        <a href="/cart" class="btn-primary">View Full Cart</a>
    </div>

</div>

<!-- ===========================
NAVBAR
=========================== -->
<div class="cart-scrim" id="scrim" onclick="closeCart()"></div>

<nav class="nav" id="nav">

<div class="wrap">

<!-- BRAND -->
<a class="brand" href="{{ route('home') }}">
    <span class="brand-mark"></span>
    <span class="brand-text">
        AD-<span class="text-orange">vance</span> <span class="text-orange">3D</span>
    </span>
</a>

<!-- DESKTOP LINKS -->
<ul class="nav-links d-none d-lg-flex" id="navbarNav">
    <li><a href="{{ route('home') }}"><i class="bi bi-house"></i> Home</a></li>
    <li><a href="{{ route('products') }}"><i class="bi bi-box"></i> Products</a></li>
    <li><a href="{{ route('custom.order') }}"><i class="bi bi-palette"></i> Custom Print</a></li>
    <li><a href="{{ route('wishlist') }}"><i class="bi bi-heart"></i> Wishlist</a></li>
</ul>

<!-- ACTIONS -->
<div class="nav-actions">

    <!-- CART -->
    <a class="icon-btn" href="{{ route('cart') }}" aria-label="Cart">
        <i class="bi bi-cart3"></i>
        <span class="cart-badge" id="cartCount">
            {{ session()->has('cart') ? count(session('cart')) : 0 }}
        </span>
    </a>

    <!-- THEME -->
    <button class="theme-toggle" onclick="toggleTheme()" id="themeIcon" aria-label="Toggle theme">
        <i class="bi bi-moon-stars"></i>
    </button>

    <!-- AUTH -->
    @guest
        <a class="btn-login d-none d-lg-inline-flex" href="{{ route('login') }}">Log in</a>
    @endguest

    @auth
        <div class="dropdown d-none d-lg-block">

            <a class="user-trigger dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                👤 {{ auth()->user()->name }}
            </a>

            <ul class="dropdown-menu dropdown-menu-end">

                @if(auth()->user()->role === 'admin')
                    <li><a class="dropdown-item fw-bold" href="{{ route('admin.products') }}">⚡ Admin Panel</a></li>
                    <li><hr class="dropdown-divider"></li>
                @endif

                <li><a class="dropdown-item" href="{{ route('home') }}">Home</a></li>
                <li><a class="dropdown-item" href="{{ route('orders.my') }}">My Orders</a></li>

                <li>
                    <a class="dropdown-item text-danger" href="#"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                </li>

            </ul>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>

        </div>
    @endauth

</div>

</div>

</nav>

<!-- ===========================
MOBILE SIDE NAV
=========================== -->
<div class="offcanvas offcanvas-start d-flex flex-column advance-offcanvas" tabindex="-1" id="mobileMenu">
 
    <div class="offcanvas-header advance-header">
        <a class="brand advance-brand" href="{{ route('home') }}">
            <span class="brand-text">
                AD-<span class="text-orange">vance</span> <span class="text-orange">3D</span>
            </span>
        </a>
        <button type="button" class="btn-close advance-close" data-bs-dismiss="offcanvas" aria-label="Close menu"></button>
    </div>
 
    <div class="offcanvas-body d-flex flex-column advance-body">
 
        <ul class="navbar-nav advance-nav">
 
            <li class="nav-item">
                <a class="nav-link advance-link active" href="{{ route('home') }}">
                    <i class="bi bi-house" aria-hidden="true"></i> Home
                </a>
            </li>
 
            <li class="nav-item">
                <a class="nav-link advance-link" href="{{ route('products') }}">
                    <i class="bi bi-box" aria-hidden="true"></i> Products
                </a>
            </li>
 
            <li class="nav-item">
                <a class="nav-link advance-link" href="{{ route('custom.order') }}">
                    <i class="bi bi-palette" aria-hidden="true"></i> Custom print
                </a>
            </li>
 
            <li class="nav-item">
                <a class="nav-link advance-link" href="{{ route('wishlist') }}">
                    <i class="bi bi-heart" aria-hidden="true"></i> Wishlist
                </a>
            </li>
 
            <li class="nav-item">
                <a class="nav-link advance-link d-flex justify-content-between align-items-center" href="{{ route('cart') }}">
                    <span><i class="bi bi-cart" aria-hidden="true"></i> Cart</span>
                    <span class="advance-count" id="mobileCartCount">
                        {{ session('cart') ? count(session('cart')) : 0 }}
                    </span>
                </a>
            </li>
 
        </ul>
 
        <div class="advance-divider"></div>
 
        @auth
            <div class="advance-account">
                <div class="advance-avatar">
                    {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                </div>
                <div>
                    <div class="advance-account-name">{{ auth()->user()->name }}</div>
                    <small class="advance-account-email">{{ auth()->user()->email }}</small>
                </div>
            </div>
 
            <div class="mt-auto">
 
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.products') }}" class="advance-action">
                        <i class="bi bi-lightning-charge" aria-hidden="true"></i> Admin panel
                    </a>
                @endif
 
                <a href="{{ route('orders.my') }}" class="advance-action">
                    <i class="bi bi-bag-check" aria-hidden="true"></i> My orders
                </a>
 
                <a href="#" class="advance-action advance-action-danger"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right" aria-hidden="true"></i> Log out
                </a>
 
            </div>
        @endauth
 
        @guest
            <div class="mt-auto">
                <a href="{{ route('login') }}" class="advance-login-link">Log in</a>
            </div>
        @endguest
 
        <div class="advance-social">
            <a href="https://www.instagram.com/ad_vance_3d/?next=%2F_.ayush_dubey_%2F" aria-label="Instagram"><i class="bi bi-instagram" aria-hidden="true"></i></a>
            <a href="#" aria-label="Facebook"><i class="bi bi-facebook" aria-hidden="true"></i></a>
            <a href="#" aria-label="YouTube"><i class="bi bi-youtube" aria-hidden="true"></i></a>
            <a href="https://wa.me/qr/IYH7KPL4QUQCE1" aria-label="WhatsApp"><i class="bi bi-whatsapp" aria-hidden="true"></i></a>
        </div>
 
    </div>
 
</div>

<!-- ===========================
PAGE CONTENT
=========================== -->

<main>

@yield('content')

</main>


<!-- ===========================
FOOTER (merged: new minimal structure + old Blade data)
=========================== -->

<footer class="footer">
  <div class="wrap">
    <div class="footer-grid">

      <!-- BRAND -->
      <div class="footer-brand">
        <a class="brand d-flex align-items-center" href="{{ route('home') }}">
          <img src="{{ asset('product_images/AD3.png') }}" alt="AD-VANCE 3D" height="28" class="footer-logo me-2">
          <span class="brand-text">AD-<span class="text-orange">vance</span> <span class="text-orange">3D</span></span>
        </a>
        <p>Premium 3D printing service for custom models, prototypes, and creative designs. Fast delivery and high precision prints.</p>
        <div class="footer-social">
          <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
          <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
          <a href="#" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
          <a href="#" aria-label="Twitter"><i class="bi bi-twitter"></i></a>
          <a href="#" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
        </div>
      </div>

      <!-- QUICK LINKS -->
      <div>
        <h6>Quick Links</h6>
        <ul>
          <li><a href="{{ route('home') }}">Home</a></li>
          <li><a href="{{ route('products') }}">Products</a></li>
          <li><a href="#">Custom Orders</a></li>
          <li><a href="#">Upload Design</a></li>
          <li><a href="#">About Us</a></li>
        </ul>
      </div>

      <!-- SUPPORT -->
      <div>
        <h6>Support</h6>
        <ul>
          <li><a href="#">Contact Us</a></li>
          <li><a href="#">Order Tracking</a></li>
          <li><a href="#">Returns Policy</a></li>
          <li><a href="#">FAQ</a></li>
          <li><a href="#">Privacy Policy</a></li>
        </ul>
      </div>

      <!-- CONTACT + NEWSLETTER -->
      <div>
        <h6>Contact</h6>
        <p class="mb-1"><i class="bi bi-geo-alt"></i> India</p>
        <p class="mb-1"><i class="bi bi-envelope"></i> support@advance3d.com</p>
        <p class="mb-3"><i class="bi bi-phone"></i> +91 8827502969</p>

        <h6>Newsletter</h6>
        <form class="footer-newsletter" action="#" method="POST" onsubmit="return false;">
          <input type="email" name="email" placeholder="Your email" required>
          <button type="submit">Subscribe</button>
        </form>
      </div>

    </div>

    <div class="footer-bottom">
      <span>© {{ date('Y') }} <strong>AD-VANCE 3D</strong>. All Rights Reserved.</span>
      <span>Designed for modern 3D printing business 🚀</span>
    </div>
  </div>
</footer>


<!-- ===========================
BOOTSTRAP JS
=========================== -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


<script>

/* ================= LOADER ================= */
window.addEventListener("load", function(){
    document.getElementById("pageLoader").style.display = "none";
    document.body.classList.add("loaded");

    // Apply saved theme
    let theme = localStorage.getItem("theme");
    let icon = document.getElementById("themeIcon");

    if(theme === "dark"){
        document.body.classList.add("dark-mode");
        if(icon) icon.innerHTML = "☀";
    }
});


/* ================= THEME TOGGLE ================= */
function toggleTheme(){
    let body = document.body;
    let icon = document.getElementById("themeIcon");

    body.classList.toggle("dark-mode");

    if(body.classList.contains("dark-mode")){
        icon.innerHTML = "☀";
        localStorage.setItem("theme","dark");
    }else{
        icon.innerHTML = "🌙";
        localStorage.setItem("theme","light");
    }
}


/* ================= CART SIDEBAR ================= */

function toggleCart(){
    let sidebar = document.getElementById("cartSidebar");
    let scrim = document.getElementById("scrim");
    if(!sidebar) return; // prevents crash if sidebar isn't on the page

    sidebar.classList.toggle("open");
    if(scrim) scrim.classList.toggle("open", sidebar.classList.contains("open"));

    // lock background scroll while the sidebar is open (mobile bottom-sheet)
    document.body.style.overflow = sidebar.classList.contains("open") ? "hidden" : "";

    if(sidebar.classList.contains("open")){
        loadCartItems();
    }
}


/* ================= LOAD CART ITEMS ================= */
function loadCartItems(){

    fetch("/cart/items")
    .then(res => res.json())
    .then(cart => {

        let container = document.getElementById("cartItems");
        container.innerHTML = "";

        let items = Array.isArray(cart) ? cart : Object.values(cart);

        if(items.length === 0){
            container.innerHTML = "<p>Cart is empty</p>";
            return;
        }

        items.forEach(item => {

            container.innerHTML += `
                <div style="display:flex; margin-bottom:10px;">

                    <img src="/product_images/${item.image}" width="50">

                    <div style="margin-left:10px;">
                        <div>${item.name}</div>
                        <small>₹${item.price} × ${item.quantity}</small>
                    </div>

                </div>
            `;
        });

    });
}
/* ================= AJAX ADD TO CART ================= */
function closeCart(){
    let sidebar = document.getElementById("cartSidebar");
    let scrim = document.getElementById("scrim");
    if(sidebar) sidebar.classList.remove("open");
    if(scrim) scrim.classList.remove("open");
    document.body.style.overflow = "";
}
document.addEventListener("click", function(e){
    let sidebar = document.getElementById("cartSidebar");

    if(!sidebar) return;

    if(
        sidebar.classList.contains("open") &&
        !sidebar.contains(e.target) &&
        !e.target.closest(".floating-cart")
    ){
        closeCart();
    }
});

document.addEventListener("DOMContentLoaded", function(){

    document.querySelectorAll(".addToCart").forEach(btn => {

        btn.addEventListener("click", function(){

            let id = this.dataset.id;

           fetch("/cart/add/"+id,{
                method:"POST",
                credentials: "include", // 🔥 CHANGE THIS
                headers:{
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    "Accept": "application/json"
                }
            })
            .then(res => res.json())
            .then(data => {

                if(data.success){

                    let cartCount = document.getElementById("cartCount");
                    if(cartCount){
                        cartCount.innerText = data.cartCount;
                    }

                    let floating = document.getElementById("floatingCartCount");
                    if(floating){
                        floating.innerText = data.cartCount;
                    }

                    // ✅ SAFE CHECK BEFORE OPEN
                    let sidebar = document.getElementById("mobileCartCount");
                    if(sidebar){
                        // sidebar.classList.add("open");
                        sidebar.innerText = data.cartCount
                    }

                    loadCartItems();

                    // BUTTON FEEDBACK
                    let original = btn.innerText;
                    btn.innerText = "✓";
                    btn.classList.remove("btn-success");
                    btn.classList.add("btn-dark");

                    setTimeout(()=>{
                        btn.innerText = original;
                        btn.classList.add("btn-success");
                        btn.classList.remove("btn-dark");
                    }, 1500);

                }

            })
            .catch(err => {
                console.log("Cart add error:", err);
            });

        });

    });

});
document.querySelectorAll('#mobileMenu .nav-link').forEach(link => {
    link.addEventListener('click', () => {
        let offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('mobileMenu'));
        if(offcanvas) offcanvas.hide();
    });
});

</script>

<a href="https://wa.me/918827502969" 
   class="whatsapp-float" 
   target="_blank">

<i class="bi bi-whatsapp"></i>

</a>

<!-- BOTTOM NAV - Mobile only -->
<nav class="bottom-nav" id="bottomNav">
    <a href="{{ route('home') }}" id="bnav-home">
        <i class="bi bi-house"></i>
        <span>Home</span>
    </a>
    <a href="{{ route('products') }}" id="bnav-products">
        <i class="bi bi-box"></i>
        <span>Products</span>
    </a>
    <a href="{{ route('wishlist') }}" id="bnav-wishlist">
        <i class="bi bi-heart"></i>
        <span>Wishlist</span>
    </a>
    <a href="{{ route('cart') }}" id="bnav-cart">
        <span class="bnav-badge" id="bnavCartCount">{{ session('cart') ? count(session('cart')) : 0 }}</span>
        <i class="bi bi-cart3"></i>
        <span>Cart</span>
    </a>
    @auth
    <a href="#" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" onclick="event.preventDefault(); bootstrap.Offcanvas.getOrCreateInstance(document.getElementById('mobileMenu')).show();" id="bnav-menu">
        <i class="bi bi-list"></i>
        <span>Menu</span>
    </a>
    @else
    <a href="{{ route('login') }}" id="bnav-login">
        <i class="bi bi-person"></i>
        <span>Login</span>
    </a>
    @endauth
</nav>

<script>
// Active bottom nav highlight
(function(){
    const path = window.location.pathname;
    const map = {
        '/': 'bnav-home',
        '/products': 'bnav-products',
        '/wishlist': 'bnav-wishlist',
        '/cart': 'bnav-cart',
    };
    // Home exact match
    if(path === '/') {
        const el = document.getElementById('bnav-home');
        if(el) el.classList.add('active');
        return;
    }
    for(let [route, id] of Object.entries(map)){
        if(route !== '/' && path.startsWith(route)){
            const el = document.getElementById(id);
            if(el) el.classList.add('active');
            break;
        }
    }
})();

// Sync cart count to bottom nav
const origUpdateCart = window.loadCartItems;
document.addEventListener('DOMContentLoaded', function(){
    // Update bottom nav cart badge when cart changes
    const observer = new MutationObserver(function(){
        const topBadge = document.getElementById('cartCount');
        const botBadge = document.getElementById('bnavCartCount');
        if(topBadge && botBadge){
            botBadge.textContent = topBadge.textContent;
        }
    });
    const topBadge = document.getElementById('cartCount');
    if(topBadge) observer.observe(topBadge, { childList: true, characterData: true, subtree: true });
});
</script>

</body>
</html>