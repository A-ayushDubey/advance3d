@extends('layouts.app')

@section('content')

<div class="container py-5 admin-panel">

<!-- HEADER -->
<div class="d-flex align-items-center gap-3 mb-4">
    <span class="admin-mark"></span>
    <div>
        <h2 class="fw-bold mb-0 admin-title">Admin Dashboard</h2>
        <small class="admin-subtitle">Overview of products, orders &amp; revenue</small>
    </div>
</div>

<!-- ADMIN NAVIGATION (tab bar) -->
<div class="admin-tabs mb-4">
    <a href="{{ route('admin.products') }}" class="admin-tab">
        <i class="bi bi-box-seam"></i> Products
    </a>
    <a href="{{ route('admin.dashboard') }}" class="admin-tab active">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>
    <a href="{{ route('admin.orders') }}" class="admin-tab">
        <i class="bi bi-receipt"></i> Orders
    </a>
    <a href="{{ route('admin.custom.orders') }}" class="admin-tab">
        <i class="bi bi-palette"></i> Custom Orders
    </a>
</div>

<!-- ================= STATS ================= -->
<div class="stat-grid mb-4">

    <div class="stat-card-mini">
        <i class="bi bi-box-seam"></i>
        <div>
            <span class="stat-mini-value">{{ $totalProducts }}</span>
            <span class="stat-mini-label">Total Products</span>
        </div>
    </div>

    <div class="stat-card-mini">
        <i class="bi bi-receipt"></i>
        <div>
            <span class="stat-mini-value">{{ $totalOrders }}</span>
            <span class="stat-mini-label">Total Orders</span>
        </div>
    </div>

    <div class="stat-card-mini">
        <i class="bi bi-hourglass-split"></i>
        <div>
            <span class="stat-mini-value accent">{{ $pendingOrders }}</span>
            <span class="stat-mini-label">Pending</span>
        </div>
    </div>

    <div class="stat-card-mini">
        <i class="bi bi-currency-rupee"></i>
        <div>
            <span class="stat-mini-value">₹{{ $revenue }}</span>
            <span class="stat-mini-label">Revenue</span>
        </div>
    </div>

</div>

<!-- CHART -->
<div class="admin-card chart-card mb-4">
    <h5 class="section-title">Monthly Revenue</h5>
    <canvas id="revenueChart" height="90"></canvas>
</div>

<!-- ROW -->
<div class="row g-4">

<!-- RECENT ORDERS -->
<div class="col-md-6">
<div class="admin-card list-card">

<h5 class="section-title">Recent Orders</h5>

<ul class="clean-list">

@forelse($recentOrders as $order)
<li class="clean-list-item">
    <span class="item-label">Order #{{ $order->id }}</span>
    <span class="item-value">₹{{ $order->total }}</span>
</li>
@empty
<li class="clean-list-empty">No recent orders</li>
@endforelse

</ul>

</div>
</div>

<!-- TOP PRODUCTS -->
<div class="col-md-6">
<div class="admin-card list-card">

<h5 class="section-title">Top Products</h5>

<ul class="clean-list">

@forelse($topProducts as $item)
<li class="clean-list-item">
    <span class="item-label">{{ $item->product->name ?? 'Deleted' }}</span>
    <span class="item-value">{{ $item->total_qty }} sold</span>
</li>
@empty
<li class="clean-list-empty">No sales data yet</li>
@endforelse

</ul>

</div>
</div>

</div>

</div>

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('revenueChart');
const isDark = document.body.classList.contains('dark-mode');

const inkColor = isDark ? '#F2F1ED' : '#1A1A1A';
const gridColor = isDark ? '#2C2C29' : '#E8E6E0';
const accentColor = '#FF5A1F';

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_keys($monthlyRevenue->toArray())) !!},
        datasets: [{
            label: 'Revenue',
            data: {!! json_encode(array_values($monthlyRevenue->toArray())) !!},
            backgroundColor: accentColor,
            borderRadius: 3,
            maxBarThickness: 36
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            x: {
                grid: { display: false },
                ticks: { color: inkColor, font: { family: "'JetBrains Mono', monospace", size: 11 } }
            },
            y: {
                grid: { color: gridColor },
                ticks: { color: inkColor, font: { family: "'JetBrains Mono', monospace", size: 11 } },
                beginAtZero: true
            }
        }
    }
});
</script>

<style>

/* =====================================================
   AD-VANCE 3D — ADMIN DASHBOARD
   modern / minimal restyle
   Tokens reused from layout.blade.php; fallbacks included.
   Reuses .admin-mark / .admin-title / .admin-subtitle /
   .admin-tabs / .admin-tab / .stat-grid / .stat-card-mini /
   .admin-card class names from the other admin pages — safe
   to duplicate if these are separate Blade files.
===================================================== */

.admin-panel{ --r: 4px; }

.admin-mark{
    width: 38px; height: 38px;
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

/* STAT GRID */

.stat-grid{
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1px;
    background: var(--hairline, #E8E6E0);
    border: 1px solid var(--hairline, #E8E6E0);
    border-radius: var(--r);
    overflow: hidden;
}
body.dark-mode .stat-grid{
    background: var(--hairline-dark, #2C2C29);
    border-color: var(--hairline-dark, #2C2C29);
}

.stat-card-mini{
    background: var(--bg-raised, #fff);
    padding: 18px 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    transition: background 0.2s ease;
}
.stat-card-mini:hover{
    background: var(--accent-50, #FFF1EA);
}
body.dark-mode .stat-card-mini{
    background: var(--bg-raised-dark, #1A1A19);
}
body.dark-mode .stat-card-mini:hover{
    background: var(--accent-50-dark, #2A1A12);
}

.stat-card-mini i{
    font-size: 20px;
    color: var(--accent, #FF5A1F);
    flex-shrink: 0;
}

.stat-card-mini div{
    display: flex;
    flex-direction: column;
}

.stat-mini-value{
    font-family: var(--font-mono, monospace);
    font-size: 1.3rem;
    font-weight: 500;
    color: var(--ink, #1A1A1A);
    line-height: 1.2;
}
.stat-mini-value.accent{
    color: var(--accent, #FF5A1F);
}
body.dark-mode .stat-mini-value{ color: var(--ink-dark, #F2F1ED); }
body.dark-mode .stat-mini-value.accent{ color: var(--accent, #FF5A1F); }

.stat-mini-label{
    font-size: 11.5px;
    color: var(--ink-soft, #6B6B65);
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
body.dark-mode .stat-mini-label{ color: var(--ink-soft-dark, #9B9A92); }

@media (max-width: 768px){
    .stat-grid{ grid-template-columns: repeat(2, 1fr); }
}

/* CARDS */

.admin-card{
    background: var(--bg-raised, #fff);
    border: 1px solid var(--hairline, #E8E6E0);
    border-radius: var(--r);
    padding: 22px;
}
body.dark-mode .admin-card{
    background: var(--bg-raised-dark, #1A1A19);
    border-color: var(--hairline-dark, #2C2C29);
}

.section-title{
    font-family: var(--font-display, sans-serif);
    font-weight: 600;
    font-size: 15px;
    color: var(--ink, #1A1A1A);
    margin-bottom: 16px;
}
body.dark-mode .section-title{ color: var(--ink-dark, #F2F1ED); }

.chart-card canvas{
    max-height: 280px;
}

/* CLEAN LISTS */

.clean-list{
    list-style: none;
    padding: 0;
    margin: 0;
}

.clean-list-item{
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid var(--hairline, #E8E6E0);
    font-size: 13.5px;
}
.clean-list-item:last-child{
    border-bottom: none;
    padding-bottom: 0;
}
.clean-list-item:first-child{
    padding-top: 0;
}
body.dark-mode .clean-list-item{
    border-bottom-color: var(--hairline-dark, #2C2C29);
}

.item-label{
    color: var(--ink, #1A1A1A);
    font-weight: 500;
}
body.dark-mode .item-label{ color: var(--ink-dark, #F2F1ED); }

.item-value{
    font-family: var(--font-mono, monospace);
    color: var(--ink-soft, #6B6B65);
    font-size: 13px;
}
body.dark-mode .item-value{ color: var(--ink-soft-dark, #9B9A92); }

.clean-list-empty{
    color: var(--ink-soft, #6B6B65);
    font-size: 13.5px;
    padding: 20px 0;
    text-align: center;
}
body.dark-mode .clean-list-empty{ color: var(--ink-soft-dark, #9B9A92); }

</style>

@endsection