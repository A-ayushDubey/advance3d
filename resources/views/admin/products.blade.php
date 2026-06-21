@extends('layouts.app')

@section('content')

<div class="container py-5 admin-panel">

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div class="d-flex align-items-center gap-3">
        <span class="admin-mark"></span>
        <div>
            <h2 class="fw-bold mb-0 admin-title">Admin Panel</h2>
            <small class="admin-subtitle">Manage your products &amp; orders</small>
        </div>
    </div>

    <a href="{{ route('admin.products.create') }}" class="btn btn-admin-primary">
        <i class="bi bi-plus-lg"></i> Add Product
    </a>
</div>


<!-- ADMIN NAVIGATION (tab bar) -->
<div class="admin-tabs mb-4">
    <a href="{{ route('admin.products') }}" class="admin-tab active">
        <i class="bi bi-box-seam"></i> Products
    </a>
    <a href="{{ route('admin.dashboard') }}" class="admin-tab">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>
    <a href="{{ route('admin.orders') }}" class="admin-tab">
        <i class="bi bi-receipt"></i> Orders
    </a>
    <a href="{{ route('admin.custom.orders') }}" class="admin-tab">
        <i class="bi bi-palette"></i> Custom Orders
    </a>
</div>


<!-- SUCCESS MESSAGE -->
@if(session('success'))
<div class="admin-alert">
    <i class="bi bi-check-circle"></i> {{ session('success') }}
</div>
@endif


<!-- STAT STRIP -->
@php
    $totalCount = $products->count();
    $inStockCount = $products->where('stock', '>', 0)->count();
    $outStockCount = $products->where('stock', '<=', 0)->count();
@endphp

<div class="stat-strip mb-4">
    <div class="stat-box">
        <span class="stat-value">{{ $totalCount }}</span>
        <span class="stat-label">Total Products</span>
    </div>
    <div class="stat-box">
        <span class="stat-value">{{ $inStockCount }}</span>
        <span class="stat-label">In Stock</span>
    </div>
    <div class="stat-box">
        <span class="stat-value out">{{ $outStockCount }}</span>
        <span class="stat-label">Out of Stock</span>
    </div>
</div>


<!-- PRODUCT TABLE -->
<div class="admin-card">

<div class="admin-card-head">
    <h6 class="mb-0">All Products</h6>

    <div class="admin-search">
        <i class="bi bi-search"></i>
        <input type="text" id="productSearch" placeholder="Search products...">
    </div>
</div>

<div class="table-responsive">
<table class="table align-middle admin-table" id="productTable">

<thead>
<tr>
<th>#</th>
<th>Image</th>
<th>Name</th>
<th>Price</th>
<th>Stock</th>
<th class="text-center">Actions</th>
</tr>
</thead>

<tbody>

@forelse($products as $product)

<tr class="product-row" data-name="{{ strtolower($product->name) }}">

<td class="text-muted-id">{{ $product->id }}</td>

<td>
<img src="/product_images/{{ $product->image }}"
     width="52"
     height="52"
     class="admin-thumb object-fit-cover">
</td>

<td class="fw-semibold product-name-cell">
{{ $product->name }}
</td>

<td class="price-cell">
₹{{ $product->price }}
</td>

<td>
<span class="stock-pill {{ $product->stock > 0 ? 'ok' : 'empty' }}">
    {{ $product->stock }}
</span>
</td>

<td class="text-center">

<a href="{{ route('admin.products.edit', $product->id) }}"
   class="admin-icon-btn edit" aria-label="Edit product">
   <i class="bi bi-pencil"></i>
</a>

<a href="{{ route('admin.products.delete', $product->id) }}"
   class="admin-icon-btn delete"
   aria-label="Delete product"
   onclick="return confirm('Delete this product?')">
   <i class="bi bi-trash3"></i>
</a>

</td>

</tr>

@empty

<tr>
<td colspan="6" class="empty-state-cell">
    <div class="empty-state">
        <i class="bi bi-inbox"></i>
        <p>No products found</p>
        <a href="{{ route('admin.products.create') }}" class="btn btn-admin-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Add your first product
        </a>
    </div>
</td>
</tr>

@endforelse

</tbody>

</table>
</div>

<p class="text-center text-muted-empty py-3 d-none" id="noSearchResults">
    No products match your search.
</p>

</div>

</div>


<style>

/* =====================================================
   AD-VANCE 3D — ADMIN PANEL
   modern / minimal / creative
   Tokens reused from layout.blade.php; fallbacks included.
===================================================== */

.admin-panel{
    --r: 4px;
}

/* HEADER */

.admin-mark{
    width: 38px;
    height: 38px;
    border-radius: 8px;
    background: var(--ink, #1A1A1A);
    position: relative;
    flex-shrink: 0;
}
.admin-mark::before{
    content: "";
    position: absolute;
    inset: 9px;
    border: 1.5px solid var(--accent, #FF5A1F);
    border-radius: 3px;
}
body.dark-mode .admin-mark{
    background: var(--ink-dark, #F2F1ED);
}
body.dark-mode .admin-mark::before{
    border-color: var(--accent, #FF5A1F);
}

.admin-title{
    font-family: var(--font-display, sans-serif);
    font-weight: 600;
    letter-spacing: -0.01em;
    color: var(--ink, #1A1A1A);
    font-size: 1.5rem;
}
body.dark-mode .admin-title{
    color: var(--ink-dark, #F2F1ED);
}

.admin-subtitle{
    color: var(--ink-soft, #6B6B65);
    font-size: 13px;
}
body.dark-mode .admin-subtitle{
    color: var(--ink-soft-dark, #9B9A92);
}

.btn-admin-primary{
    background: var(--ink, #1A1A1A);
    color: var(--bg, #FAFAF8);
    border: 1px solid var(--ink, #1A1A1A);
    border-radius: var(--r);
    font-weight: 600;
    font-size: 13.5px;
    padding: 10px 18px;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    transition: 0.2s ease;
}
.btn-admin-primary:hover{
    background: var(--accent, #FF5A1F);
    border-color: var(--accent, #FF5A1F);
    color: #fff;
    transform: translateY(-1px);
}
body.dark-mode .btn-admin-primary{
    background: var(--ink-dark, #F2F1ED);
    border-color: var(--ink-dark, #F2F1ED);
    color: var(--bg-dark, #0F0F0F);
}

/* TAB NAV */

.admin-tabs{
    display: flex;
    gap: 4px;
    border-bottom: 1px solid var(--hairline, #E8E6E0);
    flex-wrap: wrap;
}
body.dark-mode .admin-tabs{
    border-bottom-color: var(--hairline-dark, #2C2C29);
}

.admin-tab{
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 11px 16px;
    font-size: 13.5px;
    font-weight: 500;
    color: var(--ink-soft, #6B6B65);
    border-bottom: 2px solid transparent;
    margin-bottom: -1px;
    transition: 0.2s ease;
}
.admin-tab:hover{
    color: var(--ink, #1A1A1A);
}
.admin-tab.active{
    color: var(--ink, #1A1A1A);
    border-bottom-color: var(--accent, #FF5A1F);
    font-weight: 600;
}
body.dark-mode .admin-tab{
    color: var(--ink-soft-dark, #9B9A92);
}
body.dark-mode .admin-tab:hover,
body.dark-mode .admin-tab.active{
    color: var(--ink-dark, #F2F1ED);
}

/* ALERT */

.admin-alert{
    background: var(--accent-50, #FFF1EA);
    color: var(--accent-ink, #7A2B0E);
    border: 1px solid var(--accent, #FF5A1F);
    border-radius: var(--r);
    padding: 12px 16px;
    font-size: 14px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 9px;
    margin-bottom: 20px;
}
body.dark-mode .admin-alert{
    background: var(--accent-50-dark, #2A1A12);
    color: var(--ink-dark, #F2F1ED);
}

/* STAT STRIP */

.stat-strip{
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1px;
    background: var(--hairline, #E8E6E0);
    border: 1px solid var(--hairline, #E8E6E0);
    border-radius: var(--r);
    overflow: hidden;
}
body.dark-mode .stat-strip{
    background: var(--hairline-dark, #2C2C29);
    border-color: var(--hairline-dark, #2C2C29);
}

.stat-box{
    background: var(--bg-raised, #fff);
    padding: 18px 20px;
    display: flex;
    flex-direction: column;
    gap: 4px;
}
body.dark-mode .stat-box{
    background: var(--bg-raised-dark, #1A1A19);
}

.stat-value{
    font-family: var(--font-mono, monospace);
    font-size: 1.6rem;
    font-weight: 500;
    color: var(--ink, #1A1A1A);
}
.stat-value.out{
    color: #B3261E;
}
body.dark-mode .stat-value{
    color: var(--ink-dark, #F2F1ED);
}

.stat-label{
    font-size: 12px;
    color: var(--ink-soft, #6B6B65);
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
body.dark-mode .stat-label{
    color: var(--ink-soft-dark, #9B9A92);
}

@media (max-width: 576px){
    .stat-strip{ grid-template-columns: 1fr; }
}

/* TABLE CARD */

.admin-card{
    background: var(--bg-raised, #fff);
    border: 1px solid var(--hairline, #E8E6E0);
    border-radius: var(--r);
    overflow: hidden;
}
body.dark-mode .admin-card{
    background: var(--bg-raised-dark, #1A1A19);
    border-color: var(--hairline-dark, #2C2C29);
}

.admin-card-head{
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    padding: 16px 20px;
    border-bottom: 1px solid var(--hairline, #E8E6E0);
}
body.dark-mode .admin-card-head{
    border-bottom-color: var(--hairline-dark, #2C2C29);
}

.admin-card-head h6{
    font-family: var(--font-display, sans-serif);
    font-weight: 600;
    font-size: 14.5px;
    color: var(--ink, #1A1A1A);
}
body.dark-mode .admin-card-head h6{
    color: var(--ink-dark, #F2F1ED);
}

.admin-search{
    position: relative;
    display: flex;
    align-items: center;
}
.admin-search i{
    position: absolute;
    left: 11px;
    font-size: 13px;
    color: var(--ink-soft, #6B6B65);
}
.admin-search input{
    border: 1px solid var(--hairline, #E8E6E0);
    border-radius: var(--r);
    font-size: 13px;
    padding: 8px 12px 8px 32px;
    width: 220px;
    background: transparent;
    color: var(--ink, #1A1A1A);
    transition: border-color 0.2s ease;
}
.admin-search input:focus{
    outline: none;
    border-color: var(--accent, #FF5A1F);
}
body.dark-mode .admin-search input{
    border-color: var(--hairline-dark, #2C2C29);
    color: var(--ink-dark, #F2F1ED);
}
body.dark-mode .admin-search i{
    color: var(--ink-soft-dark, #9B9A92);
}

/* TABLE */

.admin-table{
    margin-bottom: 0;
}
.admin-table thead tr{
    border-bottom: 1px solid var(--hairline, #E8E6E0);
}
.admin-table thead th{
    font-family: var(--font-mono, monospace);
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--ink-soft, #6B6B65);
    font-weight: 500;
    padding: 13px 16px;
    border: none;
    background: transparent;
}
body.dark-mode .admin-table thead tr{
    border-bottom-color: var(--hairline-dark, #2C2C29);
}
body.dark-mode .admin-table thead th{
    color: var(--ink-soft-dark, #9B9A92);
}

.admin-table tbody tr{
    border-bottom: 1px solid var(--hairline, #E8E6E0);
    transition: background 0.15s ease;
}
.admin-table tbody tr:last-child{
    border-bottom: none;
}
.admin-table tbody tr:hover{
    background: var(--accent-50, #FFF1EA);
}
body.dark-mode .admin-table tbody tr{
    border-bottom-color: var(--hairline-dark, #2C2C29);
}
body.dark-mode .admin-table tbody tr:hover{
    background: var(--accent-50-dark, #2A1A12);
}

.admin-table td{
    padding: 12px 16px;
    border: none;
    color: var(--ink, #1A1A1A);
    font-size: 14px;
}
body.dark-mode .admin-table td{
    color: var(--ink-dark, #F2F1ED);
}

.text-muted-id{
    color: var(--ink-soft, #6B6B65);
    font-family: var(--font-mono, monospace);
    font-size: 12.5px;
}
body.dark-mode .text-muted-id{
    color: var(--ink-soft-dark, #9B9A92);
}

.admin-thumb{
    border-radius: 6px;
    border: 1px solid var(--hairline, #E8E6E0);
    background: var(--accent-50, #FFF1EA);
}
body.dark-mode .admin-thumb{
    border-color: var(--hairline-dark, #2C2C29);
    background: var(--accent-50-dark, #2A1A12);
}

.product-name-cell{
    font-weight: 500 !important;
}

.price-cell{
    font-family: var(--font-mono, monospace);
    font-weight: 500;
}

.stock-pill{
    font-family: var(--font-mono, monospace);
    font-size: 12px;
    font-weight: 500;
    padding: 3px 10px;
    border-radius: 20px;
    display: inline-block;
}
.stock-pill.ok{
    background: var(--accent-50, #FFF1EA);
    color: var(--accent-ink, #7A2B0E);
}
.stock-pill.empty{
    background: rgba(179,38,30,0.1);
    color: #B3261E;
}
body.dark-mode .stock-pill.ok{
    background: var(--accent-50-dark, #2A1A12);
    color: var(--ink-dark, #F2F1ED);
}

.admin-icon-btn{
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 1px solid var(--hairline, #E8E6E0);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: var(--ink, #1A1A1A);
    font-size: 13.5px;
    margin: 0 3px;
    transition: 0.2s ease;
}
.admin-icon-btn:hover{
    transform: translateY(-1px);
}
.admin-icon-btn.edit:hover{
    border-color: var(--accent, #FF5A1F);
    color: var(--accent, #FF5A1F);
}
.admin-icon-btn.delete:hover{
    border-color: #B3261E;
    color: #B3261E;
}
body.dark-mode .admin-icon-btn{
    border-color: var(--hairline-dark, #2C2C29);
    color: var(--ink-dark, #F2F1ED);
}

/* EMPTY STATE */

.empty-state-cell{
    padding: 60px 20px !important;
}
.empty-state{
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
}
.empty-state i{
    font-size: 32px;
    color: var(--hairline, #E8E6E0);
}
.empty-state p{
    color: var(--ink-soft, #6B6B65);
    font-size: 14px;
    margin: 0;
}
body.dark-mode .empty-state i{
    color: var(--hairline-dark, #2C2C29);
}
body.dark-mode .empty-state p{
    color: var(--ink-soft-dark, #9B9A92);
}

.text-muted-empty{
    color: var(--ink-soft, #6B6B65);
    font-size: 13.5px;
}
body.dark-mode .text-muted-empty{
    color: var(--ink-soft-dark, #9B9A92);
}

</style>


<script>
document.addEventListener("DOMContentLoaded", function(){

    let searchInput = document.getElementById("productSearch");
    if(!searchInput) return;

    searchInput.addEventListener("input", function(){
        let term = this.value.trim().toLowerCase();
        let rows = document.querySelectorAll(".product-row");
        let visibleCount = 0;

        rows.forEach(function(row){
            let match = row.dataset.name.includes(term);
            row.style.display = match ? "" : "none";
            if(match) visibleCount++;
        });

        let noResults = document.getElementById("noSearchResults");
        if(noResults){
            noResults.classList.toggle("d-none", visibleCount !== 0 || rows.length === 0);
        }
    });

});
</script>

@endsection