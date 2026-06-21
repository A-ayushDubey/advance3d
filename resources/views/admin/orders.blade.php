@extends('layouts.app')

@section('content')

<div class="container py-5 admin-panel">

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div class="d-flex align-items-center gap-3">
        <span class="admin-mark"></span>
        <div>
            <h2 class="fw-bold mb-0 admin-title">Admin Dashboard</h2>
            <small class="admin-subtitle">Orders overview &amp; management</small>
        </div>
    </div>

    <a href="{{ route('admin.products.create') }}" class="btn-admin-primary">
        <i class="bi bi-plus-lg"></i> Add Product
    </a>
</div>


<!-- ADMIN NAVIGATION (tab bar) -->
<div class="admin-tabs mb-4">
    <a href="{{ route('admin.products') }}" class="admin-tab">
        <i class="bi bi-box-seam"></i> Products
    </a>
    <a href="{{ route('admin.dashboard') }}" class="admin-tab">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>
    <a href="{{ route('admin.orders') }}" class="admin-tab active">
        <i class="bi bi-receipt"></i> Orders
    </a>
    <a href="{{ route('admin.custom.orders') }}" class="admin-tab">
        <i class="bi bi-palette"></i> Custom Orders
    </a>
</div>

<!-- ================= STATS ================= -->
<div class="stat-grid mb-4">

@php
$cards = [
    ['title'=>'Total Orders','value'=>$totalOrders,'icon'=>'bi-receipt'],
    ['title'=>'Revenue','value'=>'₹'.$totalRevenue,'icon'=>'bi-currency-rupee'],
    ['title'=>'Pending','value'=>$pendingOrders,'icon'=>'bi-hourglass-split'],
    ['title'=>'Delivered','value'=>$deliveredOrders,'icon'=>'bi-truck']
];
@endphp

@foreach($cards as $card)
<div class="stat-card-mini">
    <i class="bi {{ $card['icon'] }}"></i>
    <div>
        <span class="stat-mini-value">{{ $card['value'] }}</span>
        <span class="stat-mini-label">{{ $card['title'] }}</span>
    </div>
</div>
@endforeach

</div>

<!-- ================= FILTER ================= -->
<form method="GET" class="admin-filter-bar mb-4">

<div class="filter-field">
    <i class="bi bi-search"></i>
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search orders...">
</div>

<div class="filter-field select-field">
    <select name="status">
        <option value="">All Status</option>
        @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
        <option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>
            {{ ucfirst($s) }}
        </option>
        @endforeach
    </select>
</div>

<div class="filter-field">
    <input type="date" name="date" value="{{ request('date') }}">
</div>

<div class="filter-actions">
    <button class="btn-admin-primary">Filter</button>
    <a href="{{ route('admin.orders') }}" class="btn-admin-secondary">Reset</a>
</div>

</form>

<!-- ================= TABLE ================= -->
<div class="admin-card">
<div class="table-responsive">

<table class="table align-middle admin-table mb-0">

<thead>
<tr>
<th>#</th>
<th>User</th>
<th>Total</th>
<th>Payment</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>

@forelse($orders as $order)

@php
$statusKey = strtolower($order->status ?? 'pending');
@endphp

<tr>

<td class="text-muted-id">#{{ $order->id }}</td>

<td>
<strong class="order-user-name">{{ $order->name }}</strong><br>
<small class="order-user-phone">{{ $order->phone }}</small>
</td>

<td class="price-cell">₹{{ $order->total }}</td>

<td>
<span class="pay-pill {{ $order->payment_status=='paid' ? 'paid' : 'unpaid' }}">
{{ strtoupper($order->payment_status) }}
</span>
<br>
<small class="pay-method">{{ strtoupper($order->payment_method) }}</small>
</td>

<td>
<span class="status-pill status-{{ $statusKey }}">
    <span class="status-dot"></span>
    {{ ucfirst($order->status) }}
</span>
</td>

<td class="action-cell">

<!-- STATUS + UPDATE (self-contained form) -->
<form action="{{ route('admin.orders.update',$order->id) }}" method="POST" class="update-form">
@csrf

<select name="status" class="status-select">
@foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
<option value="{{ $s }}" {{ $order->status==$s?'selected':'' }}>
{{ ucfirst($s) }}
</option>
@endforeach
</select>

<button class="btn-order-action update">
    <i class="bi bi-check2"></i> Update
</button>

</form>

<!-- DELETE BUTTON (separate, self-contained form) -->
<form id="deleteForm{{ $order->id }}"
      action="{{ route('admin.orders.delete',$order->id) }}"
      method="POST"
      class="delete-form">
@csrf
    <button type="button" onclick="confirmDelete({{ $order->id }})" class="btn-order-action delete">
        <i class="bi bi-trash3"></i> Delete
    </button>
</form>

</td>

</tr>

@empty

<tr>
<td colspan="6" class="empty-state-cell">
    <div class="empty-state">
        <i class="bi bi-inbox"></i>
        <p>No orders found</p>
    </div>
</td>
</tr>

@endforelse

</tbody>

</table>

</div>
</div>

<!-- PAGINATION -->
<div class="mt-3">
{{ $orders->appends(request()->query())->links() }}
</div>

</div>

<!-- ================= SWEET ALERT ================= -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmDelete(id){
    Swal.fire({
        title: 'Delete Order?',
        text: "This cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#FF5A1F',
        cancelButtonColor: '#6B6B65',
        confirmButtonText: 'Yes, delete it!',
        background: document.body.classList.contains('dark-mode') ? '#1A1A19' : '#fff',
        color: document.body.classList.contains('dark-mode') ? '#F2F1ED' : '#1A1A1A'
    }).then((result)=>{
        if(result.isConfirmed){
            document.getElementById('deleteForm'+id).submit();
        }
    });
}
</script>

<style>

/* =====================================================
   AD-VANCE 3D — ADMIN ORDERS DASHBOARD
   modern / minimal / creative
   Tokens reused from layout.blade.php; fallbacks included.
   Reuses .admin-mark / .admin-title / .admin-subtitle /
   .admin-card / .admin-table / .text-muted-id / .price-cell /
   .status-pill / .status-dot / .empty-state* class names from
   the other admin pages — safe to duplicate if these are
   separate Blade files.
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
body.dark-mode .stat-mini-value{ color: var(--ink-dark, #F2F1ED); }

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

/* FILTER BAR */

.admin-filter-bar{
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    align-items: center;
}

.filter-field{
    position: relative;
    flex: 1 1 200px;
    display: flex;
    align-items: center;
}
.filter-field i{
    position: absolute;
    left: 11px;
    font-size: 13px;
    color: var(--ink-soft, #6B6B65);
    pointer-events: none;
}
.filter-field input,
.filter-field select{
    width: 100%;
    border: 1px solid var(--hairline, #E8E6E0);
    border-radius: var(--r);
    font-size: 13.5px;
    padding: 9px 12px;
    background: var(--bg-raised, #fff);
    color: var(--ink, #1A1A1A);
    transition: border-color 0.2s ease;
}
.filter-field input{ padding-left: 32px; }
.filter-field input:focus,
.filter-field select:focus{
    outline: none;
    border-color: var(--accent, #FF5A1F);
}
body.dark-mode .filter-field input,
body.dark-mode .filter-field select{
    background: var(--bg-raised-dark, #1A1A19);
    border-color: var(--hairline-dark, #2C2C29);
    color: var(--ink-dark, #F2F1ED);
}
body.dark-mode .filter-field i{
    color: var(--ink-soft-dark, #9B9A92);
}

.filter-actions{
    display: flex;
    gap: 8px;
    flex: 0 0 auto;
}

.btn-admin-primary{
    background: var(--ink, #1A1A1A);
    color: var(--bg, #FAFAF8);
    border: 1px solid var(--ink, #1A1A1A);
    border-radius: var(--r);
    font-weight: 600;
    font-size: 13.5px;
    padding: 9px 18px;
    transition: 0.2s ease;
}
.btn-admin-primary:hover{
    background: var(--accent, #FF5A1F);
    border-color: var(--accent, #FF5A1F);
}
body.dark-mode .btn-admin-primary{
    background: var(--ink-dark, #F2F1ED);
    border-color: var(--ink-dark, #F2F1ED);
    color: var(--bg-dark, #0F0F0F);
}

.btn-admin-secondary{
    background: transparent;
    color: var(--ink, #1A1A1A);
    border: 1px solid var(--hairline, #E8E6E0);
    border-radius: var(--r);
    font-weight: 600;
    font-size: 13.5px;
    padding: 9px 18px;
    transition: 0.2s ease;
    display: inline-flex;
    align-items: center;
}
.btn-admin-secondary:hover{
    border-color: var(--accent, #FF5A1F);
    color: var(--accent, #FF5A1F);
}
body.dark-mode .btn-admin-secondary{
    border-color: var(--hairline-dark, #2C2C29);
    color: var(--ink-dark, #F2F1ED);
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
    position: sticky;
    top: 0;
}
body.dark-mode .admin-table thead tr{ border-bottom-color: var(--hairline-dark, #2C2C29); }
body.dark-mode .admin-table thead th{ color: var(--ink-soft-dark, #9B9A92); background: var(--bg-raised-dark, #1A1A19); }

.admin-table tbody tr{
    border-bottom: 1px solid var(--hairline, #E8E6E0);
    transition: background 0.15s ease;
}
.admin-table tbody tr:last-child{ border-bottom: none; }
.admin-table tbody tr:hover{ background: var(--accent-50, #FFF1EA); }
body.dark-mode .admin-table tbody tr{ border-bottom-color: var(--hairline-dark, #2C2C29); }
body.dark-mode .admin-table tbody tr:hover{ background: var(--accent-50-dark, #2A1A12); }

.admin-table td{
    padding: 14px 16px;
    border: none;
    color: var(--ink, #1A1A1A);
    font-size: 14px;
    vertical-align: middle;
}
body.dark-mode .admin-table td{ color: var(--ink-dark, #F2F1ED); }

.text-muted-id{
    color: var(--ink-soft, #6B6B65);
    font-family: var(--font-mono, monospace);
    font-size: 12.5px;
}
body.dark-mode .text-muted-id{ color: var(--ink-soft-dark, #9B9A92); }

.order-user-name{
    font-size: 14px;
    color: var(--ink, #1A1A1A);
}
body.dark-mode .order-user-name{ color: var(--ink-dark, #F2F1ED); }

.order-user-phone{
    color: var(--ink-soft, #6B6B65);
    font-size: 12.5px;
}
body.dark-mode .order-user-phone{ color: var(--ink-soft-dark, #9B9A92); }

.price-cell{
    font-family: var(--font-mono, monospace);
    font-weight: 500;
}

/* PAYMENT PILL */

.pay-pill{
    font-family: var(--font-mono, monospace);
    font-size: 11px;
    font-weight: 500;
    letter-spacing: 0.03em;
    padding: 3px 9px;
    border-radius: 3px;
    display: inline-block;
}
.pay-pill.paid{
    background: #E6F4EA;
    color: #1E7E34;
}
.pay-pill.unpaid{
    background: var(--accent-50, #FFF1EA);
    color: var(--accent-ink, #7A2B0E);
}
body.dark-mode .pay-pill.paid{ background: rgba(30,126,52,0.18); color: #7FD99A; }
body.dark-mode .pay-pill.unpaid{ background: var(--accent-50-dark, #2A1A12); color: var(--ink-dark, #F2F1ED); }

.pay-method{
    color: var(--ink-soft, #6B6B65);
    font-size: 11px;
}
body.dark-mode .pay-method{ color: var(--ink-soft-dark, #9B9A92); }

/* STATUS PILL */

.status-pill{
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: 12.5px;
    font-weight: 500;
    padding: 5px 12px;
    border-radius: 20px;
    white-space: nowrap;
}
.status-dot{
    width: 6px; height: 6px;
    border-radius: 50%;
    display: inline-block;
}

.status-pending{ background: var(--accent-50, #FFF1EA); color: var(--accent-ink, #7A2B0E); }
.status-pending .status-dot{ background: var(--accent, #FF5A1F); }

.status-processing{ background: #E8F0FE; color: #1A4FBA; }
.status-processing .status-dot{ background: #1A4FBA; }

.status-shipped{ background: #FFF4DE; color: #946200; }
.status-shipped .status-dot{ background: #946200; }

.status-delivered{ background: #E6F4EA; color: #1E7E34; }
.status-delivered .status-dot{ background: #1E7E34; }

.status-cancelled{ background: rgba(179,38,30,0.1); color: #B3261E; }
.status-cancelled .status-dot{ background: #B3261E; }

body.dark-mode .status-pending{ background: var(--accent-50-dark, #2A1A12); color: var(--ink-dark, #F2F1ED); }
body.dark-mode .status-processing{ background: rgba(26,79,186,0.18); color: #8FB4FF; }
body.dark-mode .status-shipped{ background: rgba(148,98,0,0.18); color: #E8B84B; }
body.dark-mode .status-delivered{ background: rgba(30,126,52,0.18); color: #7FD99A; }
body.dark-mode .status-cancelled{ background: rgba(179,38,30,0.18); color: #FF8A80; }

/* ACTION CELL — fixed nesting: each form is now fully
   self-contained, no crossed div/form tags */

.action-cell{
    min-width: 190px;
}

.update-form,
.delete-form{
    margin-bottom: 6px;
}
.delete-form{ margin-bottom: 0; }

.status-select{
    width: 100%;
    border: 1px solid var(--hairline, #E8E6E0);
    border-radius: var(--r);
    font-size: 12.5px;
    padding: 6px 8px;
    margin-bottom: 6px;
    background: var(--bg-raised, #fff);
    color: var(--ink, #1A1A1A);
}
body.dark-mode .status-select{
    background: var(--bg-raised-dark, #1A1A19);
    border-color: var(--hairline-dark, #2C2C29);
    color: var(--ink-dark, #F2F1ED);
}

.btn-order-action{
    width: 100%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    font-size: 12.5px;
    font-weight: 600;
    padding: 7px 10px;
    border-radius: var(--r);
    border: 1px solid var(--hairline, #E8E6E0);
    background: transparent;
    color: var(--ink, #1A1A1A);
    transition: 0.2s ease;
}
.btn-order-action.update:hover{
    background: var(--ink, #1A1A1A);
    border-color: var(--ink, #1A1A1A);
    color: var(--bg, #FAFAF8);
}
.btn-order-action.delete:hover{
    border-color: #B3261E;
    color: #B3261E;
}
body.dark-mode .btn-order-action{
    border-color: var(--hairline-dark, #2C2C29);
    color: var(--ink-dark, #F2F1ED);
}
body.dark-mode .btn-order-action.update:hover{
    background: var(--ink-dark, #F2F1ED);
    color: var(--bg-dark, #0F0F0F);
}

/* EMPTY STATE */

.empty-state-cell{ padding: 60px 20px !important; }
.empty-state{
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
}
.empty-state i{
    font-size: 30px;
    color: var(--hairline, #E8E6E0);
}
.empty-state p{
    color: var(--ink-soft, #6B6B65);
    font-size: 14px;
    margin: 0;
}
body.dark-mode .empty-state i{ color: var(--hairline-dark, #2C2C29); }
body.dark-mode .empty-state p{ color: var(--ink-soft-dark, #9B9A92); }

</style>

@endsection