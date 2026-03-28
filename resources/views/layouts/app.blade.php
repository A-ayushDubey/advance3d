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

<style>

/* ================= GLOBAL ================= */

body{
transition:0.5s;
font-family:Arial, Helvetica, sans-serif;
opacity:0;
}
html{
    scroll-behavior: smooth;
}

main{
    /* padding-top: 10px; */
}
/* LOADED STATE */
body.loaded{
    opacity:1;
}


/* ===========================
NAVBAR
=========================== */

.navbar{
position:sticky;
top:0;
z-index:1000;
backdrop-filter:blur(10px);
background:rgba(255,255,255,0.9);
transition:0.3s;
height:60px; /* fixed navbar height */
padding:0 15px;
}
.navbar-logo{
    height:100%;
    max-height:50px; /* prevents overflow */
    width:auto;
    object-fit:contain;
}

.navbar-brand{
font-weight:bold;
font-size:22px;
}

.navbar .btn{
margin-left:10px;
white-space: nowrap;
}
.navbar-toggler{
    border:none;
}

.navbar-toggler:focus{
    box-shadow:none;
}
/* ===========================
DARK MODE
=========================== */

body.dark-mode{
background:#121212;
color:white;
}

/* Navbar */

body.dark-mode .navbar{
background:#1e1e1e !important;
}

/* Links */

body.dark-mode .navbar a{
color:white !important;
}

/* Buttons */

body.dark-mode .btn-outline-dark{
color:white !important;
border-color:white !important;
}

/* Icons */

body.dark-mode i{
color:white !important;
}

/* ===========================
FOOTER
=========================== */
/* =========================
 FOOTER RESPONSIVE
========================= */

@media (max-width: 768px){

    .footer{
        text-align: center;
    }

    .social-icons{
        justify-content: center;
    }

    .footer .input-group{
        flex-direction: column;
    }

    .footer .input-group input{
        margin-bottom: 10px;
    }
}
@media (max-width: 576px){

    .footer .input-group{
        flex-direction: column;
    }

    .footer .input-group input{
        width: 100%;
        margin-bottom: 10px;
    }

    .footer .input-group .btn{
        width: 100%;
    }

}
.footer{
background:#f8f9fa;
padding:50px 0;
font-size:15px;
}

.footer-title{
font-weight:600;
margin-bottom:15px;
}

.footer-links{
list-style:none;
padding:0;
}

.footer-links li{
margin-bottom:8px;
}

.footer-links a{
text-decoration:none;
color:#333;
transition:0.3s;
}

.footer-links a:hover{
color:#007bff;
}

.social-icons a{
font-size:20px;
margin-right:12px;
color:#333;
transition:0.3s;
}

.social-icons a:hover{
color:#007bff;
}

/* DARK MODE */

body.dark-mode .footer{
background:#1e1e1e;
color:white;
}

body.dark-mode .footer a{
color:#ddd;
}

body.dark-mode .social-icons a{
color:white;
}

body.dark-mode footer{
background:#1e1e1e;
}


.whatsapp-float{
position:fixed;
bottom:20px;
right:20px;
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
.offcanvas .nav-link{
    font-size: 16px;
    padding: 12px 10px;
    border-radius: 8px;
    color: #333;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: 0.3s;
}

.offcanvas .nav-link:hover{
    background: rgba(0,0,0,0.05);
    padding-left: 14px;
}

/* PROFILE ICON */
.profile-icon{
    width: 40px;
    height: 40px;
    background: #0d6efd;
    color: white;
    border-radius: 50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:bold;
}

/* DARK MODE */
body.dark-mode .offcanvas{
    background: #1e1e1e;
}

body.dark-mode .offcanvas .nav-link{
    color: white;
}

body.dark-mode .offcanvas .nav-link:hover{
    background: rgba(255,255,255,0.1);
}

body.dark-mode .btn-outline-dark{
    color: white;
    border-color: white;
} 

/* SOCIAL ICONS */
.social-bottom i{
    font-size: 20px;
    color: #555;
    transition: 0.3s;
}

.social-bottom i:hover{
    transform: scale(1.2);
    color: #0d6efd;
}

/* DARK MODE */
body.dark-mode .social-bottom i{
    color: white;
}
.social-bottom{
    border-top: 1px solid rgba(0,0,0,0.1);
    padding-top: 15px;
}
body.dark-mode .social-bottom{
    border-color: rgba(255,255,255,0.1);
}


/* ---------------dark mode test---------------------- */
.theme-glow {
    border: none;
    background: #111;
    color: #fff;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    transition: 0.3s;
}

.theme-glow:hover {
    box-shadow: 0 0 10px rgba(0,0,0,0.5),
                0 0 20px rgba(0,0,0,0.3);
}
/* ------------------------------------- */
/* ------------------------------------- */
</style>

</head>


<body>

<!-- LOADER -->
<div id="pageLoader">
    <div class="loader-content">
        <div class="spinner"></div>
        <h5 class="mt-3">Loading AD-VANCE 3D...</h5>
    </div>
</div>
<!-- FLOATING CART BUTTON -->
<div class="floating-cart" onclick="toggleCart()">
    <i class="bi bi-cart"></i>
    <span id="floatingCartCount">
        {{ session('cart') ? count(session('cart')) : 0 }}
    </span>
</div>

<!-- CART SIDEBAR -->
<div id="cartSidebar" class="cart-sidebar p-3">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>My Cart</h5>
        <button onclick="toggleCart()" class="btn btn-sm btn-danger">✖</button>
    </div>

    <!-- ITEMS -->
    <div id="cartItems"></div>

    <!-- FOOTER -->
    <a href="/cart" class="btn btn-primary w-100 mt-3">View Full Cart</a>

</div>
<!-- ===========================
NAVBAR
=========================== -->

<nav class="navbar navbar-expand-lg">

<div class="container">

<a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">

    <!-- LOGO IMAGE -->
    <img src="{{ asset('product_images/AD3.png') }}" alt="AD-VANCE 3D" height="40" class="navbar-logo me-2">

    <!-- BRAND TEXT -->
    <span class="brand-text">
        AD-<span class="text-orange">vance</span> <span class="text-orange">3D</span>
    </span>

</a>

<button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
    <span class="navbar-toggler-icon"></span>
</button>
<!-- -------------------------------------- -->
<div class="collapse navbar-collapse d-none d-lg-flex" id="navbarNav">

<ul class="navbar-nav ms-auto align-items-center">

<!-- HOME -->
<li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="bi bi-house"></i> Home
                </a>
            </li>

            <!-- PRODUCTS -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('products') }}">
                    <i class="bi bi-box"></i> Products
                </a>
            </li>
            
            <!-- Custom Print -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('custom.order') }}">
                    <i class="bi bi-palette"></i> Custom Print
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('wishlist') }}">
                    <i class="bi bi-heart"></i> Wishlist
                </a>
            </li>
<!-- CART -->
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center" href="{{ route('cart') }}">
                    
                    <i class="bi bi-cart me-2"></i>
                    <span class="me-2">Cart</span>

                    <span class="badge bg-primary " id="cartCount">
                        {{ session()->has('cart') ? count(session('cart')) : 0 }}
                    </span>

                </a>
            </li>




<!-- AUTH SECTION -->
@guest
    <!-- NOT LOGGED IN -->
    <li class="nav-item ms-2">
        <a class="nav-link" href="{{ route('login') }}">Login</a>
    </li>

    <!-- <li class="nav-item">
        <a class="nav-link" href="{{ route('register') }}">Register</a>
    </li> -->
@endguest
<!-- THEME -->
<li class="nav-item">
    <button class="theme-glow ms-3" onclick="toggleTheme()" id="themeIcon">
        🌙
    </button>
</li>

@auth
    <!-- LOGGED IN USER DROPDOWN -->
    <li class="nav-item dropdown ms-2">

        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            👤 {{ auth()->user()->name }}
        </a>

        <ul class="dropdown-menu dropdown-menu-end">

            <!-- ADMIN PANEL (ONLY ADMIN) -->
            @if(auth()->user()->role === 'admin')
                <li>
                    <a class="dropdown-item fw-bold" href="{{ route('admin.products') }}">
                        ⚡Admin Panel
                    </a>
                </li>
                <li>
                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                    Dashboard
                </a>
            </li>
            
            <li>
                <a class="dropdown-item" href="{{ route('admin.orders') }}">
                    Orders
                </a>
            </li>
                <li><hr class="dropdown-divider"></li>
            @endif

            <!-- HOME -->
            <li>
                <a class="dropdown-item" href="{{ route('home') }}">
                    Home
                </a>
            </li>

            

            <!-- LOGOUT -->
            <li>
                <a class="dropdown-item text-danger" href="#"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
            </li>

        </ul>

        <!-- LOGOUT FORM -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>

    </li>
@endauth

</ul>

</div>

</div>

</nav>
<!-- MOBILE SIDE NAV -->
<!-- MOBILE SIDE NAV -->
<div class="offcanvas offcanvas-start d-flex flex-column" tabindex="-1" id="mobileMenu">

    <!-- HEADER -->
    <div class="offcanvas-header border-bottom">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('product_images/AD3.png') }}" height="40" class="me-2">
            <span class="brand-text">
                AD-<span class="text-orange">vance</span> <span class="text-orange">3D</span>
            </span>
        </a>

        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <!-- BODY -->
    <div class="offcanvas-body d-flex flex-column justify-content-between">

        <!-- TOP LINKS -->
        <ul class="navbar-nav">

            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="bi bi-house"></i> Home
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('products') }}">
                    <i class="bi bi-box"></i> Products
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('custom.order') }}">
                    <i class="bi bi-palette"></i> Custom Print
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="{{ route('wishlist') }}">
                    <i class="bi bi-heart"></i> Wishlist
                </a>
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
        <!-- BOTTOM SECTION -->
        <div class="border-bottom pt-0">
            <!-- THEME -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <span class="text-muted">Theme</span>
                <button class="btn btn-outline-dark btn-sm" onclick="toggleTheme()" id="mobileThemeIcon">
                    🌙
                </button>
            </div>

            @auth
                <!-- USER INFO -->
                <div class="d-flex align-items-center mb-3 border-top pt-3"">
                    <div class="profile-icon me-2">
                        {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                    </div>

                    <div>
                        <div style="font-weight:600;">
                            {{ auth()->user()->name }}
                        </div>
                        <small class="text-muted">
                            {{ auth()->user()->email }}
                        </small>
                    </div>
                </div>

                <!-- ADMIN -->
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.products') }}" class="nav-link">
                        ⚡ Admin Panel
                    </a>
                @endif

                <!-- LOGOUT -->
                <button class="btn btn-danger w-100 mt-3"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </button>
            @endauth

            @guest
                <a href="{{ route('login') }}" class="nav-link">Login</a>
                <!-- <a href="{{ route('register') }}" class="nav-link">Register</a> -->
            @endguest

            <!-- THEME -->
            

            <!-- SOCIAL -->
            <div class="social-bottom mt-4 text-center">
                <div class="d-flex justify-content-center gap-3">
                    <a href="https://www.instagram.com/ad_vance_3d/?next=%2F_.ayush_dubey_%2F"><i class="bi bi-instagram"></i></a>
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-youtube"></i></a>
                    <a href="https://wa.me/qr/IYH7KPL4QUQCE1"><i class="bi bi-whatsapp"></i></a>
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

<footer class="footer mt-5">

<div class="container">

<div class="row gy-4">

<!-- BRAND -->
<div class="col-lg-3 col-md-6">


<h5 class="footer-title"> <img src="{{ asset('product_images/AD3.png') }}" alt="AD-VANCE 3D" height="40" class="footer-logo me-2">AD-VANCE 3D</h5>


<p class="text-muted">
Premium 3D printing service for custom models, prototypes,
and creative designs. Fast delivery and high precision prints.
</p>

<div class="social-icons mt-3">
<a href="#"><i class="bi bi-facebook"></i></a>
<a href="#"><i class="bi bi-instagram"></i></a>
<a href="#"><i class="bi bi-youtube"></i></a>
<a href="#"><i class="bi bi-twitter"></i></a>
<a href="#"><i class="bi bi-whatsapp"></i></a>
</div>

</div>


<!-- QUICK LINKS -->
<div class="col-lg-3 col-md-6">

<h6 class="footer-title">Quick Links</h6>

<ul class="footer-links">
<li><a href="{{ route('home') }}">Home</a></li>
<li><a href="{{ route('products') }}">Products</a></li>
<li><a href="#">Custom Orders</a></li>
<li><a href="#">Upload Design</a></li>
<li><a href="#">About Us</a></li>
</ul>

</div>


<!-- SUPPORT -->
<div class="col-lg-3 col-md-6">

<h6 class="footer-title">Support</h6>

<ul class="footer-links">
<li><a href="#">Contact Us</a></li>
<li><a href="#">Order Tracking</a></li>
<li><a href="#">Returns Policy</a></li>
<li><a href="#">FAQ</a></li>
<li><a href="#">Privacy Policy</a></li>
</ul>

</div>


<!-- CONTACT + NEWSLETTER -->
<div class="col-lg-3 col-md-6">

<h6 class="footer-title">Contact</h6>

<p class="mb-1"><i class="bi bi-geo-alt"></i> India</p>
<p class="mb-1"><i class="bi bi-envelope"></i> support@advance3d.com</p>
<p class="mb-3"><i class="bi bi-phone"></i> +91 8827502969</p>

<h6 class="footer-title">Newsletter</h6>

<form>
<div class="input-group">
<input type="email" class="form-control" placeholder="Your email">
<button class="btn btn-primary">Subscribe</button>
</div>
</form>

</div>

</div>

<hr class="my-4">

<div class="text-center">

<p class="mb-0">
© {{ date('Y') }} <strong>AD-VANCE 3D</strong>. All Rights Reserved.
</p>

<small class="text-muted">
Designed for modern 3D printing business 🚀
</small>

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