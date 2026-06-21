@extends('layouts.app')

@section('content')

@php
$statusConfig = [
    'pending'    => ['icon' => 'ti-clock',        'color' => 'amber',  'label' => 'Pending'],
    'processing' => ['icon' => 'ti-settings',      'color' => 'blue',   'label' => 'Processing'],
    'shipped'    => ['icon' => 'ti-truck',         'color' => 'purple', 'label' => 'Shipped'],
    'delivered'  => ['icon' => 'ti-circle-check',  'color' => 'green',  'label' => 'Delivered'],
];
$steps = ['pending', 'processing', 'shipped', 'delivered'];
@endphp

<div class="mo-wrap">
<div class="mo-page">

    {{-- ===== HEADER ===== --}}
    <div class="mo-header">
        <div>
            <h1 class="mo-title">My orders</h1>
            <p class="mo-sub">
                <i class="ti ti-package" style="font-size:13px;vertical-align:-1px"></i>
                {{ $orders->count() }} {{ Str::plural('order', $orders->count()) }} placed
            </p>
        </div>
        <a href="{{ route('products') }}" class="mo-shop-btn">
            <i class="ti ti-plus"></i> Shop more
        </a>
    </div>

    @forelse($orders as $idx => $order)
    @php
        $status  = strtolower($order->status);
        $cfg     = $statusConfig[$status] ?? $statusConfig['pending'];
        $current = array_search($status, $steps);
        $pct     = round(($current + 1) / count($steps) * 100);
    @endphp

    <div class="mo-card mo-card-reveal" style="animation-delay: {{ $idx * 0.07 }}s">

        {{-- Colored left accent --}}
        <div class="mo-accent mo-accent--{{ $cfg['color'] }}"></div>

        <div class="mo-card-inner">

            {{-- Top row --}}
            <div class="mo-card-top">
                <div class="mo-order-meta">
                    <span class="mo-order-id">#{{ $order->id }}</span>
                    <span class="mo-dot"></span>
                    <span class="mo-date">{{ $order->created_at->format('d M Y') }}</span>
                    <span class="mo-dot"></span>
                    <span class="mo-time">{{ $order->created_at->format('h:i A') }}</span>
                </div>
                <div class="mo-status mo-status--{{ $cfg['color'] }}">
                    <i class="ti {{ $cfg['icon'] }} {{ $status === 'processing' ? 'spin-slow' : '' }} {{ $status === 'shipped' ? 'truck-rock' : '' }}"></i>
                    {{ $cfg['label'] }}
                </div>
            </div>

            {{-- Item thumbnails --}}
            <div class="mo-items">
                @foreach($order->items->take(3) as $item)
                <div class="mo-thumb">
                    @if($item->product && $item->product->image)
                        <img src="{{ asset('product_images/' . $item->product->image) }}"
                             alt="{{ $item->product->name }}"
                             class="mo-thumb-img">
                    @else
                        <div class="mo-thumb-ph"><i class="ti ti-box"></i></div>
                    @endif
                </div>
                @endforeach
                @if($order->items->count() > 3)
                <div class="mo-thumb mo-thumb-more">+{{ $order->items->count() - 3 }}</div>
                @endif

                {{-- Item names beside thumbnails --}}
                <div class="mo-item-names">
                    @foreach($order->items->take(2) as $item)
                    <span class="mo-item-name-chip">{{ Str::limit($item->product->name ?? 'Item', 22) }}</span>
                    @endforeach
                    @if($order->items->count() > 2)
                    <span class="mo-item-name-chip mo-chip-muted">+{{ $order->items->count() - 2 }} more</span>
                    @endif
                </div>
            </div>

            {{-- Divider --}}
            <div class="mo-inner-divider"></div>

            {{-- Bottom row --}}
            <div class="mo-card-bottom">

                {{-- Step dots + bar --}}
                <div class="mo-progress-wrap">
                    <div class="mo-steps">
                        @foreach($steps as $i => $step)
                        <div class="mo-step {{ $i <= $current ? 'done' : '' }} {{ $i === $current ? 'active' : '' }}">
                            <div class="mo-step-dot {{ $i === $current ? 'pulse' : '' }}"></div>
                            <span class="mo-step-label">{{ ucfirst($step) }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="mo-track">
                        <div class="mo-track-fill" style="width:{{ $pct }}%"></div>
                    </div>
                </div>

                {{-- Total + CTA --}}
                <div class="mo-card-actions">
                    <span class="mo-total">₹{{ number_format($order->total) }}</span>
                    <a href="{{ route('orders.show', $order->id) }}" class="mo-track-btn">
                        Track <i class="ti ti-arrow-right mo-btn-arrow"></i>
                    </a>
                </div>

            </div>

        </div>
    </div>

    @empty

    <div class="mo-empty">
        <div class="mo-empty-icon-wrap">
            <div class="mo-empty-ring"></div>
            <i class="ti ti-shopping-bag mo-empty-icon"></i>
        </div>
        <h2 class="mo-empty-title">No orders yet</h2>
        <p class="mo-empty-sub">You haven't placed any orders yet. Browse our products and start printing!</p>
        <a href="{{ route('products') }}" class="mo-browse-btn">
            Browse products <i class="ti ti-arrow-right"></i>
        </a>
    </div>

    @endforelse

</div>
</div>

<style>

/* ===== PAGE WRAP — light grey bg ===== */
.mo-wrap {
    min-height: 100vh;
    background: #F5F5F3;
    padding: 2.5rem 0 5rem;
}

.mo-page {
    max-width: 720px;
    margin: 0 auto;
    padding: 0 1.25rem;
}

/* ===== HEADER ===== */
.mo-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 1.75rem;
    gap: 1rem;
}

.mo-title {
    font-size: 22px;
    font-weight: 500;
    color: #1a1a1a;
    margin: 0 0 3px;
}

.mo-sub {
    font-size: 13px;
    color: #888;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 4px;
}

.mo-shop-btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 7px 15px;
    font-size: 13px;
    font-weight: 500;
    border: 1px solid #e0e0e0;
    border-radius: 9px;
    color: #1a1a1a;
    text-decoration: none;
    background: #fff;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
    transition: box-shadow .15s, background .15s;
    white-space: nowrap;
}
.mo-shop-btn:hover {
    background: #fafafa;
    box-shadow: 0 2px 8px rgba(0,0,0,.08);
    color: #1a1a1a;
}

/* ===== CARD ===== */
.mo-card {
    background: #fff;
    border-radius: 16px;
    margin-bottom: .875rem;
    box-shadow: 0 1px 4px rgba(0,0,0,.06), 0 0 0 0.5px rgba(0,0,0,.06);
    display: flex;
    overflow: hidden;
    transition: box-shadow .2s, transform .2s;
}
.mo-card:hover {
    box-shadow: 0 4px 20px rgba(0,0,0,.1), 0 0 0 0.5px rgba(0,0,0,.07);
    transform: translateY(-2px);
}

/* Colored left accent bar */
.mo-accent {
    width: 4px;
    flex-shrink: 0;
    border-radius: 16px 0 0 16px;
}
.mo-accent--amber  { background: #FAC775; }
.mo-accent--blue   { background: #378ADD; }
.mo-accent--purple { background: #7F77DD; }
.mo-accent--green  { background: #1D9E75; }

.mo-card-inner {
    flex: 1;
    padding: 1.125rem 1.25rem;
    min-width: 0;
}

/* ===== TOP ROW ===== */
.mo-card-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: .875rem;
    gap: 8px;
}

.mo-order-meta {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
}

.mo-order-id {
    font-size: 14px;
    font-weight: 600;
    color: #1a1a1a;
}

.mo-date, .mo-time {
    font-size: 12px;
    color: #999;
}

.mo-dot {
    width: 3px; height: 3px;
    border-radius: 50%;
    background: #ccc;
    flex-shrink: 0;
}

/* Status pill */
.mo-status {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
    flex-shrink: 0;
    letter-spacing: .02em;
}
.mo-status--amber  { background: #FAEEDA; color: #854F0B; }
.mo-status--blue   { background: #E6F1FB; color: #185FA5; }
.mo-status--purple { background: #EEEDFE; color: #3C3489; }
.mo-status--green  { background: #EAF3DE; color: #3B6D11; }

/* ===== ITEM THUMBNAILS ===== */
.mo-items {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: .875rem;
}

.mo-thumb { flex-shrink: 0; }

.mo-thumb-img {
    width: 44px; height: 44px;
    border-radius: 9px;
    object-fit: cover;
    border: 1px solid #f0f0f0;
    display: block;
    transition: transform .2s;
}
.mo-thumb-img:hover { transform: scale(1.08); }

.mo-thumb-ph {
    width: 44px; height: 44px;
    border-radius: 9px;
    background: #f5f5f3;
    border: 1px solid #eee;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #bbb;
    font-size: 17px;
}

.mo-thumb-more {
    width: 44px; height: 44px;
    border-radius: 9px;
    background: #f5f5f3;
    border: 1px solid #eee;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 600;
    color: #999;
}

/* Item name chips */
.mo-item-names {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
    min-width: 0;
}

.mo-item-name-chip {
    font-size: 12px;
    padding: 3px 9px;
    border-radius: 20px;
    background: #f5f5f3;
    border: 1px solid #eee;
    color: #555;
    white-space: nowrap;
    max-width: 160px;
    overflow: hidden;
    text-overflow: ellipsis;
}

.mo-chip-muted { color: #aaa; }

/* Divider */
.mo-inner-divider {
    border: none;
    border-top: 1px solid #f3f3f3;
    margin: 0 0 .875rem;
}

/* ===== BOTTOM ROW ===== */
.mo-card-bottom {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 1rem;
}

/* Step tracker */
.mo-progress-wrap { flex: 1; min-width: 0; }

.mo-steps {
    display: flex;
    justify-content: space-between;
    margin-bottom: 7px;
}

.mo-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    flex: 1;
}

.mo-step-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    background: #e0e0e0;
    transition: background .25s;
    position: relative;
}

.mo-step.done .mo-step-dot  { background: #1D9E75; }
.mo-step.active .mo-step-dot { background: #1D9E75; }

.mo-step-dot.pulse::after {
    content: '';
    position: absolute;
    inset: -4px;
    border-radius: 50%;
    border: 2px solid #1D9E75;
    animation: pulse-dot 1.8s ease-out infinite;
}
@keyframes pulse-dot {
    0%   { transform: scale(.7); opacity: 1; }
    100% { transform: scale(1.8); opacity: 0; }
}

.mo-step-label {
    font-size: 10px;
    color: #bbb;
    white-space: nowrap;
}
.mo-step.done .mo-step-label,
.mo-step.active .mo-step-label { color: #666; }

.mo-track {
    height: 3px;
    background: #efefef;
    border-radius: 99px;
    overflow: hidden;
}

.mo-track-fill {
    height: 100%;
    background: linear-gradient(90deg, #1D9E75, #5DCAA5);
    border-radius: 99px;
    transition: width .6s ease;
}

/* Actions */
.mo-card-actions {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 7px;
    flex-shrink: 0;
}

.mo-total {
    font-size: 16px;
    font-weight: 600;
    color: #1a1a1a;
    font-variant-numeric: tabular-nums;
}

.mo-track-btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 13px;
    font-size: 13px;
    font-weight: 500;
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    color: #1a1a1a;
    text-decoration: none;
    background: #fff;
    box-shadow: 0 1px 3px rgba(0,0,0,.04);
    transition: box-shadow .15s, gap .15s;
    white-space: nowrap;
}
.mo-track-btn:hover {
    box-shadow: 0 2px 8px rgba(0,0,0,.09);
    color: #1a1a1a;
}
.mo-track-btn:hover .mo-btn-arrow { transform: translateX(3px); }
.mo-btn-arrow { transition: transform .2s; }

/* ===== EMPTY STATE ===== */
.mo-empty {
    text-align: center;
    padding: 5rem 1rem;
}

.mo-empty-icon-wrap {
    position: relative;
    width: 72px; height: 72px;
    margin: 0 auto 1.5rem;
}

.mo-empty-ring {
    position: absolute;
    inset: -8px;
    border-radius: 50%;
    border: 1.5px dashed #ddd;
    animation: spin-ring 12s linear infinite;
}
@keyframes spin-ring { to { transform: rotate(360deg); } }

.mo-empty-icon {
    position: relative;
    width: 72px; height: 72px;
    border-radius: 18px;
    background: #fff;
    border: 1px solid #eee;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 30px;
    color: #bbb;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
}

.mo-empty-title {
    font-size: 18px;
    font-weight: 500;
    margin-bottom: .5rem;
    color: #1a1a1a;
}

.mo-empty-sub {
    font-size: 14px;
    color: #999;
    max-width: 300px;
    margin: 0 auto 1.75rem;
    line-height: 1.6;
}

.mo-browse-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 10px 22px;
    font-size: 14px;
    font-weight: 500;
    border-radius: 10px;
    background: #1a1a1a;
    color: #fff;
    text-decoration: none;
    box-shadow: 0 2px 8px rgba(0,0,0,.15);
    transition: opacity .15s, box-shadow .15s;
}
.mo-browse-btn:hover {
    opacity: .88;
    color: #fff;
    box-shadow: 0 4px 16px rgba(0,0,0,.2);
}

/* ===== ANIMATIONS ===== */
@keyframes card-in {
    from { opacity: 0; transform: translateY(18px); }
    to   { opacity: 1; transform: translateY(0); }
}
.mo-card-reveal {
    animation: card-in .4s ease both;
}

@keyframes spin-slow { to { transform: rotate(360deg); } }
.spin-slow { animation: spin-slow 3s linear infinite; display: inline-block; }

@keyframes truck-rock {
    0%,100% { transform: translateX(0); }
    50%      { transform: translateX(3px); }
}
.truck-rock { animation: truck-rock .9s ease-in-out infinite; display: inline-block; }

/* ===== RESPONSIVE ===== */
@media (max-width: 560px) {
    .mo-card-bottom  { flex-direction: column; align-items: stretch; }
    .mo-card-actions { flex-direction: row; align-items: center; justify-content: space-between; }
    .mo-step-label   { display: none; }
    .mo-item-names   { display: none; }
}
</style>

@endsection