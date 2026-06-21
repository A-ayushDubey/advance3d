@extends('layouts.app')

@section('content')

<div class="container py-5 admin-panel">

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div class="d-flex align-items-center gap-3">
        <span class="admin-mark"></span>
        <div>
            <h2 class="fw-bold mb-0 admin-title">Custom Orders</h2>
            <small class="admin-subtitle">{{ $orders->count() }} request{{ $orders->count() == 1 ? '' : 's' }} submitted</small>
        </div>
    </div>
</div>

<!-- ADMIN NAVIGATION (tab bar) -->
<div class="admin-tabs mb-4">
    <a href="{{ route('admin.products') }}" class="admin-tab">
        <i class="bi bi-box-seam"></i> Products
    </a>
    <a href="{{ route('admin.dashboard') }}" class="admin-tab">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>
    <a href="{{ route('admin.orders') }}" class="admin-tab ">
        <i class="bi bi-receipt"></i> Orders
    </a>
    <a href="{{ route('admin.custom.orders') }}" class="admin-tab active">
        <i class="bi bi-palette"></i> Custom Orders
    </a>
</div>

@if($orders->count() > 0)

<div class="order-list">

@foreach($orders as $order)

@php
    $statusKey = strtolower($order->status ?? 'pending');
@endphp

<div class="order-card">

    <div class="order-card-top">
        <div class="order-id-block">
            <span class="order-tag">Order #{{ $order->id ?? $loop->iteration }}</span>
            <h5 class="order-name">{{ $order->name }}</h5>
        </div>

        <span class="status-pill status-{{ $statusKey }}">
            <span class="status-dot"></span>
            {{ ucfirst($order->status ?? 'Pending') }}
        </span>
    </div>

    <div class="order-card-body">

        <div class="order-meta">
            <a href="tel:{{ $order->phone }}" class="meta-item meta-link">
                <i class="bi bi-telephone"></i> {{ $order->phone }}
            </a>
        </div>

        <p class="order-desc">{{ $order->description }}</p>

    </div>

    <div class="order-card-foot">
        <a href="{{ asset('custom_uploads/'.$order->file) }}" target="_blank" class="btn-order-action download">
            <i class="bi bi-download"></i> Download File
        </a>

        <a href="tel:{{ $order->phone }}" class="btn-order-action call">
            <i class="bi bi-telephone"></i> Call
        </a>
    </div>

</div>

@endforeach

</div>

@else

<div class="empty-state-block">
    <i class="bi bi-inbox"></i>
    <p>No custom orders yet</p>
    <small>Submitted custom print requests will appear here.</small>
</div>

@endif

</div>


<style>

/* =====================================================
   AD-VANCE 3D — CUSTOM ORDERS (ADMIN)
   modern / minimal / creative
   Tokens reused from layout.blade.php; fallbacks included.
   Reuses .admin-mark / .admin-title / .admin-subtitle
   classes from the admin products page for consistency —
   safe to duplicate here if these are separate Blade files.
===================================================== */
/* * TAB NAV */

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

.admin-panel{ --r: 4px; }

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
body.dark-mode .admin-mark{ background: var(--ink-dark, #F2F1ED); }

.admin-title{
    font-family: var(--font-display, sans-serif);
    font-weight: 600;
    letter-spacing: -0.01em;
    color: var(--ink, #1A1A1A);
    font-size: 1.5rem;
}
body.dark-mode .admin-title{ color: var(--ink-dark, #F2F1ED); }

.admin-subtitle{
    color: var(--ink-soft, #6B6B65);
    font-size: 13px;
}
body.dark-mode .admin-subtitle{ color: var(--ink-soft-dark, #9B9A92); }

/* ORDER LIST */

.order-list{
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.order-card{
    background: var(--bg-raised, #fff);
    border: 1px solid var(--hairline, #E8E6E0);
    border-radius: 6px;
    overflow: hidden;
    transition: 0.25s ease;
}
.order-card:hover{
    border-color: var(--accent, #FF5A1F);
    box-shadow: 0 16px 36px rgba(0,0,0,0.06);
}
body.dark-mode .order-card{
    background: var(--bg-raised-dark, #1A1A19);
    border-color: var(--hairline-dark, #2C2C29);
}

.order-card-top{
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 12px;
    padding: 18px 20px 14px;
    border-bottom: 1px solid var(--hairline, #E8E6E0);
}
body.dark-mode .order-card-top{
    border-bottom-color: var(--hairline-dark, #2C2C29);
}

.order-tag{
    font-family: var(--font-mono, monospace);
    font-size: 11px;
    color: var(--ink-soft, #6B6B65);
    text-transform: uppercase;
    letter-spacing: 0.04em;
    display: block;
    margin-bottom: 4px;
}
body.dark-mode .order-tag{ color: var(--ink-soft-dark, #9B9A92); }

.order-name{
    font-family: var(--font-display, sans-serif);
    font-weight: 600;
    font-size: 17px;
    margin: 0;
    color: var(--ink, #1A1A1A);
}
body.dark-mode .order-name{ color: var(--ink-dark, #F2F1ED); }

/* STATUS PILL — generic mapping, adjust class names below to
   match your real status enum values if they differ */

.status-pill{
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: 12.5px;
    font-weight: 500;
    padding: 6px 13px;
    border-radius: 20px;
    white-space: nowrap;
    text-transform: capitalize;
}
.status-dot{
    width: 6px;
    height: 6px;
    border-radius: 50%;
    display: inline-block;
}

.status-pending{
    background: var(--accent-50, #FFF1EA);
    color: var(--accent-ink, #7A2B0E);
}
.status-pending .status-dot{ background: var(--accent, #FF5A1F); }

.status-processing,
.status-in_progress,
.status-in-progress{
    background: #E8F0FE;
    color: #1A4FBA;
}
.status-processing .status-dot,
.status-in_progress .status-dot,
.status-in-progress .status-dot{ background: #1A4FBA; }

.status-completed,
.status-done,
.status-delivered{
    background: #E6F4EA;
    color: #1E7E34;
}
.status-completed .status-dot,
.status-done .status-dot,
.status-delivered .status-dot{ background: #1E7E34; }

.status-cancelled,
.status-rejected{
    background: rgba(179,38,30,0.1);
    color: #B3261E;
}
.status-cancelled .status-dot,
.status-rejected .status-dot{ background: #B3261E; }

body.dark-mode .status-pending{ background: var(--accent-50-dark, #2A1A12); color: var(--ink-dark, #F2F1ED); }
body.dark-mode .status-processing,
body.dark-mode .status-in_progress,
body.dark-mode .status-in-progress{ background: rgba(26,79,186,0.18); color: #8FB4FF; }
body.dark-mode .status-completed,
body.dark-mode .status-done,
body.dark-mode .status-delivered{ background: rgba(30,126,52,0.18); color: #7FD99A; }

/* CARD BODY */

.order-card-body{
    padding: 16px 20px;
}

.order-meta{
    margin-bottom: 10px;
}

.meta-item{
    font-size: 13.5px;
    color: var(--ink-soft, #6B6B65);
    display: inline-flex;
    align-items: center;
    gap: 7px;
}
.meta-link{
    text-decoration: none;
    transition: color 0.2s ease;
}
.meta-link:hover{
    color: var(--accent, #FF5A1F);
}
body.dark-mode .meta-item{ color: var(--ink-soft-dark, #9B9A92); }

.order-desc{
    font-size: 14px;
    color: var(--ink, #1A1A1A);
    line-height: 1.65;
    margin: 0;
}
body.dark-mode .order-desc{ color: var(--ink-dark, #F2F1ED); }

/* CARD FOOTER */

.order-card-foot{
    display: flex;
    gap: 10px;
    padding: 14px 20px;
    border-top: 1px solid var(--hairline, #E8E6E0);
    background: var(--bg, #FAFAF8);
}
body.dark-mode .order-card-foot{
    border-top-color: var(--hairline-dark, #2C2C29);
    background: var(--bg-dark, #0F0F0F);
}

.btn-order-action{
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: 13px;
    font-weight: 600;
    padding: 8px 15px;
    border-radius: 3px;
    border: 1px solid var(--hairline, #E8E6E0);
    color: var(--ink, #1A1A1A);
    transition: 0.2s ease;
}
.btn-order-action.download:hover{
    border-color: var(--ink, #1A1A1A);
    background: var(--ink, #1A1A1A);
    color: var(--bg, #FAFAF8);
}
.btn-order-action.call:hover{
    border-color: var(--accent, #FF5A1F);
    color: var(--accent, #FF5A1F);
}
body.dark-mode .btn-order-action{
    border-color: var(--hairline-dark, #2C2C29);
    color: var(--ink-dark, #F2F1ED);
}
body.dark-mode .btn-order-action.download:hover{
    background: var(--ink-dark, #F2F1ED);
    color: var(--bg-dark, #0F0F0F);
}

/* EMPTY STATE */

.empty-state-block{
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    padding: 80px 20px;
    border: 1px dashed var(--hairline, #E8E6E0);
    border-radius: 6px;
}
.empty-state-block i{
    font-size: 34px;
    color: var(--hairline, #E8E6E0);
}
.empty-state-block p{
    font-size: 15px;
    font-weight: 500;
    color: var(--ink, #1A1A1A);
    margin: 0;
}
.empty-state-block small{
    color: var(--ink-soft, #6B6B65);
    font-size: 13px;
}
body.dark-mode .empty-state-block{
    border-color: var(--hairline-dark, #2C2C29);
}
body.dark-mode .empty-state-block i{
    color: var(--hairline-dark, #2C2C29);
}
body.dark-mode .empty-state-block p{
    color: var(--ink-dark, #F2F1ED);
}
body.dark-mode .empty-state-block small{
    color: var(--ink-soft-dark, #9B9A92);
}

@media (max-width: 576px){
    .order-card-foot{ flex-direction: column; }
    .btn-order-action{ justify-content: center; }
}

</style>

@endsection