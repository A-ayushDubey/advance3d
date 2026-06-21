<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <script src="https://cdn.jsdelivr.net/npm/three@0.152.2/build/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.152.2/examples/js/loaders/STLLoader.js"></script> -->
<!-- ----------192.168.29.143----------- -->
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

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
   NAVBAR
===================================================== */

.nav{
  position:sticky;
  top:0;
  z-index:1000;
  height:var(--nav-h);
  display:flex;
  align-items:center;
  background:rgba(250,250,248,0.82);
  backdrop-filter:blur(14px);
  -webkit-backdrop-filter:blur(14px);
  border-bottom:1px solid var(--hairline);
  transition:background .35s ease, border-color .35s ease;
}

body.dark .nav{
  background:rgba(15,15,15,0.78);
  border-bottom-color:var(--hairline-dark);
}

/* the "print line" signature: an underline that draws itself
   in once, the first time the user scrolls past the hero */
.nav::after{
  content:"";
  position:absolute;
  left:0; bottom:-1px;
  height:1px;
  width:0%;
  background:var(--accent);
  transition:width 1.1s cubic-bezier(.16,.84,.44,1);
}

.nav.inked::after{ width:100%; }

.nav .wrap{
  display:flex;
  align-items:center;
  justify-content:space-between;
  width:100%;
}

.brand{
  display:flex;
  align-items:center;
  gap:10px;
}

.brand-mark{
  width:30px; height:30px;
  border:1.5px solid var(--ink);
  border-radius:50%;
  position:relative;
  flex-shrink:0;
}
body.dark .brand-mark{ border-color:var(--ink-dark); }
.brand-mark::before{
  content:"";
  position:absolute;
  inset:5px;
  border:1.5px solid var(--accent);
  border-radius:50%;
}

.brand-text{
  font-family:var(--font-display);
  font-weight:600;
  font-size:18px;
  letter-spacing:-0.01em;
}
.brand-text span{ color:var(--accent); }

.nav-links{
  display:flex;
  align-items:center;
  gap:36px;
  list-style:none;
  margin:0; padding:0;
}

.nav-links a{
  font-size:14px;
  font-weight:500;
  color:var(--ink-soft);
  display:flex;
  align-items:center;
  gap:7px;
  padding:6px 0;
  position:relative;
  transition:color .2s ease;
}
body.dark .nav-links a{ color:var(--ink-soft-dark); }

.nav-links a:hover{ color:var(--ink); }
body.dark .nav-links a:hover{ color:var(--ink-dark); }

.nav-links a::after{
  content:"";
  position:absolute;
  left:0; bottom:-3px;
  width:0; height:1px;
  background:var(--accent);
  transition:width .25s ease;
}
.nav-links a:hover::after{ width:100%; }

.nav-links a i{ font-size:15px; }

.nav-actions{
  display:flex;
  align-items:center;
  gap:14px;
}

.icon-btn{
  width:36px; height:36px;
  border-radius:50%;
  border:1px solid var(--hairline);
  display:flex; align-items:center; justify-content:center;
  font-size:15px;
  background:transparent;
  color:var(--ink);
  cursor:pointer;
  transition:border-color .2s ease, transform .15s ease, background .2s ease;
  position:relative;
}
body.dark .icon-btn{ border-color:var(--hairline-dark); color:var(--ink-dark); }
.icon-btn:hover{ border-color:var(--accent); transform:translateY(-1px); }

.cart-badge{
  position:absolute;
  top:-5px; right:-5px;
  background:var(--accent);
  color:#fff;
  font-family:var(--font-mono);
  font-size:10px;
  width:16px; height:16px;
  border-radius:50%;
  display:flex; align-items:center; justify-content:center;
  line-height:1;
}

.btn-login{
  font-size:13.5px;
  font-weight:600;
  padding:9px 18px;
  border:1px solid var(--ink);
  border-radius:var(--radius);
  transition:background .2s ease, color .2s ease;
}
body.dark .btn-login{ border-color:var(--ink-dark); }
.btn-login:hover{ background:var(--ink); color:var(--bg); }
body.dark .btn-login:hover{ background:var(--ink-dark); color:var(--bg-dark); }

.nav-toggle{
  display:none;
  background:none; border:none;
  font-size:22px;
  color:var(--ink);
  cursor:pointer;
}
body.dark .nav-toggle{ color:var(--ink-dark); }

@media (max-width:920px){
  .nav-links{ display:none; }
  .nav-toggle{ display:block; }
  .btn-login{ display:none; }
}

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

/* theme toggle */
.theme-toggle{
  width:36px; height:36px;
  border-radius:50%;
  border:1px solid var(--hairline);
  background:transparent;
  color:var(--ink);
  cursor:pointer;
  font-size:15px;
  display:flex; align-items:center; justify-content:center;
  transition:border-color .2s ease, transform .25s ease;
}
body.dark .theme-toggle{ border-color:var(--hairline-dark); color:var(--ink-dark); }
.theme-toggle:hover{ border-color:var(--accent); transform:rotate(20deg); }

/* whatsapp float — kept, restyled to match */
.wa-float{
  position:fixed;
  bottom:28px; left:28px;
  width:50px; height:50px;
  border-radius:50%;
  background:#25D366;
  color:#fff;
  display:flex; align-items:center; justify-content:center;
  font-size:22px;
  z-index:998;
  box-shadow:0 8px 24px rgba(0,0,0,0.18);
  transition:transform .2s ease;
}
.wa-float:hover{ transform:scale(1.08); }

/* ------ */
/* ------ */
/* ------ */
/* ------ */
/* ------ */

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

.object-fit-cover{
object-fit: cover;
}

.table td, .table th{
vertical-align: middle;
}

/* ================= LOADER ================= */

#pageLoader{
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:#000;
z-index:9999;
display:flex;
justify-content:center;
align-items:center;
flex-direction:column;
color:white;
}

.spinner{
width:50px;
height:50px;
border:5px solid #fff;
border-top:5px solid transparent;
border-radius:50%;
animation:spin 1s linear infinite;
}

@keyframes spin{
0%{transform:rotate(0deg);}
100%{transform:rotate(360deg);}
}
#pageLoader h5{
    font-size:16px;
    text-align:center;
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

/* BRAND TEXT STYLE */
.brand-text{
    font-weight:700;
    font-size:20px;
    letter-spacing:1px;
    color:#333;
}

/* ORANGE COLOR (matching your logo) */
.text-orange{
    color:#ff6a00;
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

    .navbar{
        height: auto;
        padding: 10px 0;
    }

    .navbar-brand{
        font-size: 18px;
    }

    .navbar-logo{
        max-height: 40px;
    }

    .navbar-collapse{
        background: white;
        padding: 15px;
        border-radius: 10px;
        margin-top: 10px;
    }

    body.dark-mode .navbar-collapse{
        background: #1e1e1e;
    }

    .navbar-nav{
        align-items: flex-start !important;
    }

    .navbar .btn{
        margin-left: 0;
        margin-top: 8px;
        width: 100%;
    }
}

/* =========================
FLOATING CART
========================= */
.cart-sidebar{
    position: fixed;
    top: 0;
    right: -350px;
    width: 320px;
    height: 100%;
    background: white;
    box-shadow: -5px 0 20px rgba(0,0,0,0.2);
    z-index: 9999;
    transition: 0.3s;
}

.cart-sidebar.open{
    right: 0;
}
.floating-cart{
    position: fixed;
    bottom: 90px;
    right: 20px;
    background: #0d6efd;
    color: white;
    width: 55px;
    height: 55px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    cursor: pointer;
    z-index: 9999;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    transition: 0.3s;
}

.floating-cart:hover{
    transform: scale(1.1);
}

.floating-cart span{
    position: absolute;
    top: -5px;
    right: -5px;
    background: red;
    color: white;
    font-size: 12px;
    padding: 2px 6px;
    border-radius: 50%;
}


/* SIDEBAR BASE */
.offcanvas{
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(10px);
    width: 270px;
}

/* SAME NAV LINK STYLE */

/* ------------------------------------- */
/* ------------------------------------- */
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

.nav .wrap{ max-width:1180px; margin:0 auto; height:72px; display:flex; align-items:center; justify-content:space-between; }

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

.nav .nav-actions{ display:flex; align-items:center; gap:12px; }

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
    position:absolute; top:-5px; right:-5px;
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

.nav .nav-toggle{
    display:none;
    background:none; border:none;
    font-size:21px;
    color:var(--ink, #1A1A1A);
    cursor:pointer;
}
body.dark-mode .nav .nav-toggle{ color:var(--ink-dark, #F2F1ED); }

/* user dropdown trigger, restyled to match nav-links */
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
    .nav .nav-toggle{ display:flex !important; align-items:center; justify-content:center; }
}

/* ---- MOBILE OFFCANVAS ---- */
.offcanvas{
    background:rgba(250,250,248,0.97);
    backdrop-filter:blur(14px);
    width:280px;
    border-right:1px solid var(--hairline, #E8E6E0);
}
body.dark-mode .offcanvas{ background:rgba(15,15,15,0.97); border-right-color:var(--hairline-dark, #2C2C29); }

.offcanvas-header{ border-bottom:1px solid var(--hairline, #E8E6E0) !important; }
body.dark-mode .offcanvas-header{ border-bottom-color:var(--hairline-dark, #2C2C29) !important; }

.offcanvas .navbar-nav .nav-link{
    font-size:14.5px; font-weight:500;
    padding:12px 10px;
    border-radius:3px;
    color:var(--ink-soft, #6B6B65);
    display:flex; align-items:center; gap:10px;
    transition:.2s ease;
}
.offcanvas .navbar-nav .nav-link:hover{ background:var(--accent-50, #FFF1EA); color:var(--ink, #1A1A1A); padding-left:14px; }
body.dark-mode .offcanvas .navbar-nav .nav-link{ color:var(--ink-soft-dark, #9B9A92); }
body.dark-mode .offcanvas .navbar-nav .nav-link:hover{ background:var(--accent-50-dark, #2A1A12); color:var(--ink-dark, #F2F1ED); }

.offcanvas .badge.bg-primary{
    background:var(--accent, #FF5A1F) !important;
    font-family:var(--font-mono, monospace);
    font-weight:500; font-size:11px;
}

.offcanvas .theme-toggle{
    width:34px; height:34px;
    border-radius:50%;
    border:1px solid var(--hairline, #E8E6E0);
    background:transparent;
    color:var(--ink, #1A1A1A);
    font-size:14px;
    display:flex; align-items:center; justify-content:center;
    transition:border-color .2s ease;
}
.offcanvas .theme-toggle:hover{ border-color:var(--accent, #FF5A1F); }
body.dark-mode .offcanvas .theme-toggle{ border-color:var(--hairline-dark, #2C2C29); color:var(--ink-dark, #F2F1ED); }

.profile-icon{
    width:38px; height:38px;
    background:var(--ink, #1A1A1A);
    color:var(--bg, #FAFAF8);
    border-radius:50%;
    display:flex; align-items:center; justify-content:center;
    font-weight:600;
    font-family:var(--font-display, sans-serif);
}
body.dark-mode .profile-icon{ background:var(--ink-dark, #F2F1ED); color:var(--bg-dark, #0F0F0F); }

.offcanvas .btn-danger{
    background:transparent;
    border:1px solid var(--hairline, #E8E6E0);
    color:var(--ink, #1A1A1A);
    font-weight:600;
    font-size:13.5px;
    border-radius:3px;
    padding:11px;
    transition:.2s ease;
}
.offcanvas .btn-danger:hover{ border-color:var(--accent, #FF5A1F); color:var(--accent, #FF5A1F); }
body.dark-mode .offcanvas .btn-danger{ border-color:var(--hairline-dark, #2C2C29); color:var(--ink-dark, #F2F1ED); }

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
        <!-- <a class="btn-login d-none d-lg-inline-flex" href="{{ route('register') }}">Register</a> -->
    @endguest

    @auth
        <div class="dropdown d-none d-lg-block">

            <a class="user-trigger dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                👤 {{ auth()->user()->name }}
            </a>

            <ul class="dropdown-menu dropdown-menu-end">

                @if(auth()->user()->role === 'admin')
                    <li><a class="dropdown-item fw-bold" href="{{ route('admin.products') }}">⚡ Admin Panel</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.orders') }}">Orders</a></li>
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

    <!-- MOBILE TOGGLE -->
    <button class="nav-toggle" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-label="Menu">
        <i class="bi bi-list"></i>
    </button>

</div>

</div>

</nav>

<!-- ===========================
MOBILE SIDE NAV
=========================== -->
<div class="offcanvas offcanvas-start d-flex flex-column" tabindex="-1" id="mobileMenu">

    <div class="offcanvas-header">
        <a class="brand" href="{{ route('home') }}">
            <span class="brand-mark"></span>
            <span class="brand-text">
                AD-<span class="text-orange">vance</span> <span class="text-orange">3D</span>
            </span>
        </a>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body d-flex flex-column justify-content-between">

        <ul class="navbar-nav">

            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}"><i class="bi bi-house"></i> Home</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('products') }}"><i class="bi bi-box"></i> Products</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('custom.order') }}"><i class="bi bi-palette"></i> Custom Print</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('wishlist') }}"><i class="bi bi-heart"></i> Wishlist</a>
            </li>

            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" href="{{ route('cart') }}">
                    <span><i class="bi bi-cart"></i> Cart</span>
                    <span class="badge bg-primary" id="mobileCartCount">
                        {{ session('cart') ? count(session('cart')) : 0 }}
                    </span>
                </a>
            </li>

        </ul>

        <div class="border-bottom pt-0">

            <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
                <span class="text-muted">Theme</span>
                <button class="theme-toggle" onclick="toggleTheme()" id="mobileThemeIcon" aria-label="Toggle theme">
                    <i class="bi bi-moon-stars"></i>
                </button>
            </div>

            @auth
                <div class="d-flex align-items-center mb-3 border-top pt-3">
                    <div class="profile-icon me-2">
                        {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                    </div>
                    <div>
                        <div style="font-weight:600;">{{ auth()->user()->name }}</div>
                        <small class="text-muted">{{ auth()->user()->email }}</small>
                    </div>
                </div>

                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.products') }}" class="nav-link">⚡ Admin Panel</a>
                @endif

                <button class="btn-danger w-100 mt-3"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </button>
            @endauth

            @guest
                <a href="{{ route('login') }}" class="nav-link">Login</a>
                <!-- <a href="{{ route('register') }}" class="nav-link">Register</a> -->
            @endguest

            <div class="social-bottom mt-4 text-center">
                <div class="d-flex justify-content-center gap-3">
                    <a href="https://www.instagram.com/ad_vance_3d/?next=%2F_.ayush_dubey_%2F" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                    <a href="https://wa.me/qr/IYH7KPL4QUQCE1" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>

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
FOOTER
=========================== -->

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
    if(!sidebar) return; // 🔥 prevents crash

    sidebar.classList.toggle("open");

    if(sidebar.classList.contains("open")){
        loadCartItems();
    }
}
function toggleCart(){
    document.getElementById("cartSidebar").classList.toggle("open");
    loadCartItems();
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
    document.getElementById("cartSidebar").classList.remove("open");
}
document.addEventListener("click", function(e){
    let sidebar = document.getElementById("cartSidebar");

    if(!sidebar) return;

    if(
        sidebar.classList.contains("open") &&
        !sidebar.contains(e.target) &&
        !e.target.closest(".floating-cart")
    ){
        sidebar.classList.remove("open");
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
</body>
</html>