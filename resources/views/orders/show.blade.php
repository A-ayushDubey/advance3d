@extends('layouts.app')

@section('content')

@php
$statusConfig = [
    'pending'    => ['icon' => 'ti-clock',       'color' => 'amber',  'label' => 'Pending'],
    'processing' => ['icon' => 'ti-settings',     'color' => 'blue',   'label' => 'Processing'],
    'shipped'    => ['icon' => 'ti-truck',        'color' => 'purple', 'label' => 'Shipped'],
    'delivered'  => ['icon' => 'ti-circle-check', 'color' => 'green',  'label' => 'Delivered'],
];

$steps   = ['pending', 'processing', 'shipped', 'delivered'];
$status  = strtolower($order->status);
$cfg     = $statusConfig[$status] ?? $statusConfig['pending'];
$current = array_search($status, $steps);
$pct     = round(($current + 1) / count($steps) * 100);

$stepIcons = [
    'pending'    => 'ti-clock',
    'processing' => 'ti-settings',
    'shipped'    => 'ti-truck',
    'delivered'  => 'ti-circle-check',
];

$stepMessages = [
    'pending'    => 'Your order has been received and is waiting to be confirmed.',
    'processing' => 'We are preparing your 3D prints. This usually takes 1–2 days.',
    'shipped'    => 'Your order is on its way! Expect delivery in 2–4 days.',
    'delivered'  => 'Your order has been delivered. Enjoy your prints!',
];
@endphp

<div class="os-page">

    {{-- Back --}}
    <a href="{{ route('orders.my') }}" class="os-back">
        <i class="ti ti-arrow-left"></i> My orders
    </a>

    {{-- ===== HERO BANNER ===== --}}
    <div class="os-hero os-hero--{{ $cfg['color'] }}">
        <div class="os-hero-glow"></div>
        <div class="os-hero-content">
            <div class="os-hero-icon-wrap">
                <i class="ti {{ $cfg['icon'] }} os-hero-icon {{ $status === 'processing' ? 'spin-slow' : '' }} {{ $status === 'shipped' ? 'truck-anim' : '' }}"></i>
            </div>
            <div class="os-hero-text">
                <div class="os-hero-label">Order #{{ $order->id }}</div>
                <div class="os-hero-status">{{ $cfg['label'] }}</div>
                <div class="os-hero-msg">{{ $stepMessages[$status] }}</div>
            </div>
        </div>
        <div class="os-hero-date">
            <i class="ti ti-calendar"></i>
            {{ $order->created_at->format('d M Y · h:i A') }}
        </div>

        {{-- Animated dots --}}
        <div class="os-hero-dots">
            <span></span><span></span><span></span>
            <span></span><span></span><span></span>
        </div>
    </div>

    {{-- ===== TRACKING STEPS ===== --}}
    <div class="os-card os-reveal">
        <div class="os-card-label">
            <i class="ti ti-map-pin"></i> Order progress
        </div>

        <div class="os-steps">
            @foreach($steps as $i => $step)
            @php
                $done   = $i < $current;
                $active = $i === $current;
                $future = $i > $current;
            @endphp
            <div class="os-step {{ $done ? 'done' : '' }} {{ $active ? 'active' : '' }} {{ $future ? 'future' : '' }}">

                {{-- Connector before (except first) --}}
                @if($i > 0)
                <div class="os-conn {{ $i <= $current ? 'filled' : '' }}">
                    <div class="os-conn-fill" style="width: {{ $i <= $current ? '100%' : '0%' }}"></div>
                </div>
                @endif

                <div class="os-step-btn {{ $active ? 'pulse' : '' }}">
                    @if($done)
                        <i class="ti ti-check"></i>
                    @else
                        <i class="ti {{ $stepIcons[$step] }} {{ $active && $step === 'processing' ? 'spin-slow' : '' }}"></i>
                    @endif
                </div>

                <div class="os-step-label-wrap">
                    <div class="os-step-name">{{ ucfirst($step) }}</div>
                    @if($active)
                        <div class="os-step-pill active-pill">Now</div>
                    @elseif($done)
                        <div class="os-step-pill done-pill"><i class="ti ti-check" style="font-size:9px"></i></div>
                    @endif
                </div>

            </div>
            @endforeach
        </div>

        {{-- Status message bar --}}
        <div class="os-status-bar os-status-bar--{{ $cfg['color'] }}">
            <i class="ti {{ $cfg['icon'] }} {{ $status === 'processing' ? 'spin-slow' : '' }}"></i>
            <span>{{ $stepMessages[$status] }}</span>
        </div>

    </div>

    {{-- ===== ITEMS ===== --}}
    <div class="os-card os-reveal" style="animation-delay:.1s">
        <div class="os-card-label">
            <i class="ti ti-shopping-bag"></i> Items ordered
            <span class="os-count-pill">{{ $order->items->count() }}</span>
        </div>

        <div class="os-items">
            @foreach($order->items as $idx => $item)
            <div class="os-item os-item-reveal" style="animation-delay:{{ $idx * 0.06 }}s">
                @if($item->product && $item->product->image)
                    <div class="os-item-img-wrap">
                        <img src="{{ asset('product_images/' . $item->product->image) }}"
                             alt="{{ $item->product->name }}"
                             class="os-item-img">
                    </div>
                @else
                    <div class="os-item-placeholder">
                        <i class="ti ti-box"></i>
                    </div>
                @endif
                <div class="os-item-info">
                    <div class="os-item-name">{{ $item->product->name ?? 'Product' }}</div>
                    <div class="os-item-meta">
                        <span class="os-qty-pill">× {{ $item->quantity }}</span>
                        <span class="os-item-unit">₹{{ number_format($item->price) }} each</span>
                    </div>
                </div>
                <div class="os-item-total">₹{{ number_format($item->price * $item->quantity) }}</div>
            </div>
            @endforeach
        </div>

        {{-- Summary --}}
        <div class="os-summary">
            <div class="os-summary-row">
                <span class="os-muted">Subtotal</span>
                <span>₹{{ number_format($order->total) }}</span>
            </div>
            <div class="os-summary-row">
                <span class="os-muted">Shipping</span>
                <span class="os-free"><i class="ti ti-truck"></i> Free</span>
            </div>
            <div class="os-divider"></div>
            <div class="os-summary-row os-grand-total">
                <span>Total paid</span>
                <span class="os-total-amount">₹{{ number_format($order->total) }}</span>
            </div>
        </div>
    </div>

    {{-- ===== DELIVERY INFO ===== --}}
    <div class="os-card os-reveal" style="animation-delay:.2s">
        <div class="os-card-label">
            <i class="ti ti-home"></i> Delivery details
        </div>
        <div class="os-info-grid">
            <div class="os-info-item">
                <div class="os-info-icon"><i class="ti ti-user"></i></div>
                <div>
                    <div class="os-info-key">Name</div>
                    <div class="os-info-val">{{ $order->name }}</div>
                </div>
            </div>
            <div class="os-info-item">
                <div class="os-info-icon"><i class="ti ti-phone"></i></div>
                <div>
                    <div class="os-info-key">Phone</div>
                    <div class="os-info-val">{{ $order->phone }}</div>
                </div>
            </div>
            <div class="os-info-item" style="grid-column:1/-1">
                <div class="os-info-icon"><i class="ti ti-map-pin"></i></div>
                <div>
                    <div class="os-info-key">Address</div>
                    <div class="os-info-val">{{ $order->address }}</div>
                </div>
            </div>
            <div class="os-info-item">
                <div class="os-info-icon"><i class="ti ti-credit-card"></i></div>
                <div>
                    <div class="os-info-key">Payment</div>
                    <div class="os-info-val">{{ ucfirst($order->payment_method) }}</div>
                </div>
            </div>
            <div class="os-info-item">
                <div class="os-info-icon os-info-icon--{{ $order->payment_status === 'paid' ? 'green' : 'amber' }}">
                    <i class="ti {{ $order->payment_status === 'paid' ? 'ti-circle-check' : 'ti-clock' }}"></i>
                </div>
                <div>
                    <div class="os-info-key">Payment status</div>
                    <div class="os-info-val os-pay-{{ $order->payment_status }}">
                        {{ ucfirst($order->payment_status) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== NEED HELP ===== --}}
    <div class="os-help os-reveal" style="animation-delay:.3s">
        <i class="ti ti-headset os-help-icon"></i>
        <div>
            <div class="os-help-title">Need help with this order?</div>
            <div class="os-help-sub">Contact us and quote order #{{ $order->id }}</div>
        </div>
        <a href="https://wa.me/919617371417?text=Hi, I need help with Order %23{{ $order->id }}"
           target="_blank" class="os-help-btn">
            <i class="ti ti-brand-whatsapp"></i> WhatsApp
        </a>
    </div>

</div>

<style>
.os-page {
    max-width: 680px;
    margin: 2rem auto;
    padding: 0 1.25rem 5rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

/* Back */
.os-back {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 13px; color: var(--color-text-secondary);
    text-decoration: none; margin-bottom: .25rem;
    transition: color .15s, gap .15s;
}
.os-back:hover { color: var(--color-text-primary); gap: 8px; }

/* ===== HERO ===== */
.os-hero {
    border-radius: 16px;
    padding: 1.5rem;
    position: relative;
    overflow: hidden;
    border: 0.5px solid transparent;
}
.os-hero--amber  { background: linear-gradient(135deg,#FAEEDA 0%,#FAC775 100%); border-color: #FAC775; }
.os-hero--blue   { background: linear-gradient(135deg,#E6F1FB 0%,#B5D4F4 100%); border-color: #B5D4F4; }
.os-hero--purple { background: linear-gradient(135deg,#EEEDFE 0%,#CECBF6 100%); border-color: #CECBF6; }
.os-hero--green  { background: linear-gradient(135deg,#EAF3DE 0%,#C0DD97 100%); border-color: #9FE1CB; }

.os-hero-glow {
    position: absolute; inset: 0; pointer-events: none;
    background: radial-gradient(circle at 80% 20%, rgba(255,255,255,.45) 0%, transparent 60%);
}

.os-hero-content {
    display: flex; align-items: flex-start; gap: 1rem;
    position: relative; z-index: 1;
}

.os-hero-icon-wrap {
    width: 52px; height: 52px; border-radius: 14px;
    background: rgba(255,255,255,.55);
    display: flex; align-items: center; justify-content: center;
    font-size: 24px; flex-shrink: 0;
    backdrop-filter: blur(4px);
}

.os-hero--amber  .os-hero-icon-wrap { color: #854F0B; }
.os-hero--blue   .os-hero-icon-wrap { color: #185FA5; }
.os-hero--purple .os-hero-icon-wrap { color: #3C3489; }
.os-hero--green  .os-hero-icon-wrap { color: #3B6D11; }

.os-hero-label {
    font-size: 12px; font-weight: 500;
    opacity: .7; margin-bottom: 2px;
}
.os-hero--amber  .os-hero-label,
.os-hero--amber  .os-hero-status,
.os-hero--amber  .os-hero-msg  { color: #633806; }
.os-hero--blue   .os-hero-label,
.os-hero--blue   .os-hero-status,
.os-hero--blue   .os-hero-msg  { color: #0C447C; }
.os-hero--purple .os-hero-label,
.os-hero--purple .os-hero-status,
.os-hero--purple .os-hero-msg  { color: #26215C; }
.os-hero--green  .os-hero-label,
.os-hero--green  .os-hero-status,
.os-hero--green  .os-hero-msg  { color: #173404; }

.os-hero-status { font-size: 20px; font-weight: 500; line-height: 1.2; }
.os-hero-msg    { font-size: 13px; margin-top: 4px; opacity: .8; line-height: 1.5; }

.os-hero-date {
    display: flex; align-items: center; gap: 5px;
    font-size: 12px; margin-top: 1rem;
    opacity: .65; position: relative; z-index: 1;
}
.os-hero--amber  .os-hero-date { color: #633806; }
.os-hero--blue   .os-hero-date { color: #0C447C; }
.os-hero--purple .os-hero-date { color: #26215C; }
.os-hero--green  .os-hero-date { color: #173404; }

/* Animated background dots */
.os-hero-dots {
    position: absolute; inset: 0; pointer-events: none; z-index: 0;
}
.os-hero-dots span {
    position: absolute;
    border-radius: 50%;
    background: rgba(255,255,255,.25);
    animation: float-dot 6s ease-in-out infinite;
}
.os-hero-dots span:nth-child(1) { width:60px;height:60px; top:-20px; right:60px; animation-delay:0s; }
.os-hero-dots span:nth-child(2) { width:35px;height:35px; top:10px;  right:10px; animation-delay:1s; }
.os-hero-dots span:nth-child(3) { width:20px;height:20px; top:50%;   right:30%;  animation-delay:2s; }
.os-hero-dots span:nth-child(4) { width:50px;height:50px; bottom:-15px; right:40%; animation-delay:.5s; }
.os-hero-dots span:nth-child(5) { width:15px;height:15px; bottom:10px; right:10px; animation-delay:1.5s; }
.os-hero-dots span:nth-child(6) { width:25px;height:25px; bottom:20px; right:80px; animation-delay:2.5s; }

@keyframes float-dot {
    0%,100% { transform: translateY(0) scale(1); }
    50%      { transform: translateY(-8px) scale(1.05); }
}

/* ===== CARD ===== */
.os-card {
    background: var(--color-background-primary);
    border: 0.5px solid var(--color-border-tertiary);
    border-radius: 14px;
    padding: 1.25rem 1.375rem;
    transition: border-color .2s;
}
.os-card:hover { border-color: var(--color-border-secondary); }

.os-card-label {
    display: flex; align-items: center; gap: 6px;
    font-size: 11px; font-weight: 500;
    text-transform: uppercase; letter-spacing: .07em;
    color: var(--color-text-secondary);
    margin-bottom: 1.1rem;
}

.os-count-pill {
    background: var(--color-background-secondary);
    border: 0.5px solid var(--color-border-tertiary);
    border-radius: 20px;
    padding: 1px 8px;
    font-size: 11px;
    color: var(--color-text-secondary);
}

/* ===== STEPS ===== */
.os-steps {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 1.1rem;
    position: relative;
}

.os-step {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    position: relative;
}

.os-conn {
    position: absolute;
    top: 18px;
    left: calc(-50% + 19px);
    right: calc(50% + 19px);
    height: 2px;
    background: var(--color-border-tertiary);
    overflow: hidden;
}
.os-conn-fill {
    height: 100%;
    background: #1D9E75;
    transition: width 1s ease;
    border-radius: 99px;
}

.os-step-btn {
    width: 38px; height: 38px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px;
    background: var(--color-background-secondary);
    border: 0.5px solid var(--color-border-tertiary);
    color: var(--color-text-tertiary);
    transition: all .3s;
    position: relative; z-index: 1;
}

.os-step.done .os-step-btn {
    background: #EAF3DE; border-color: #9FE1CB; color: #3B6D11;
}
.os-step.active .os-step-btn {
    background: #1D9E75; border-color: #1D9E75; color: #fff;
}

.os-step-btn.pulse::after {
    content: '';
    position: absolute; inset: -5px;
    border-radius: 50%;
    border: 2px solid #1D9E75;
    animation: pulse-ring 2s ease-out infinite;
}
@keyframes pulse-ring {
    0%   { transform: scale(.85); opacity: .8; }
    100% { transform: scale(1.4);  opacity: 0;  }
}

.os-step-label-wrap { text-align: center; }
.os-step-name {
    font-size: 11px; font-weight: 500;
    color: var(--color-text-tertiary);
}
.os-step.done .os-step-name,
.os-step.active .os-step-name { color: var(--color-text-primary); }

.os-step-pill {
    display: inline-block;
    font-size: 9px; font-weight: 500;
    padding: 1px 6px; border-radius: 20px;
    margin-top: 3px;
}
.active-pill { background: #E6F1FB; color: #185FA5; }
.done-pill   { background: #EAF3DE; color: #3B6D11; }

/* Status bar */
.os-status-bar {
    display: flex; align-items: center; gap: 8px;
    padding: 10px 14px;
    border-radius: 9px;
    font-size: 13px;
    margin-top: .25rem;
}
.os-status-bar--amber  { background: #FAEEDA; color: #854F0B; }
.os-status-bar--blue   { background: #E6F1FB; color: #185FA5; }
.os-status-bar--purple { background: #EEEDFE; color: #3C3489; }
.os-status-bar--green  { background: #EAF3DE; color: #3B6D11; }

/* ===== ITEMS ===== */
.os-items { display: flex; flex-direction: column; gap: .875rem; margin-bottom: 1rem; }

.os-item {
    display: flex; align-items: center; gap: 12px;
    padding: 10px;
    border-radius: 10px;
    border: 0.5px solid var(--color-border-tertiary);
    background: var(--color-background-secondary);
    transition: border-color .15s, background .15s;
}
.os-item:hover {
    background: var(--color-background-primary);
    border-color: var(--color-border-secondary);
}

.os-item-img-wrap { position: relative; flex-shrink: 0; }
.os-item-img {
    width: 54px; height: 54px;
    border-radius: 9px; object-fit: cover;
    border: 0.5px solid var(--color-border-tertiary);
    display: block;
}

.os-item-placeholder {
    width: 54px; height: 54px; border-radius: 9px;
    background: var(--color-background-primary);
    border: 0.5px solid var(--color-border-tertiary);
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; color: var(--color-text-tertiary);
    flex-shrink: 0;
}

.os-item-info { flex: 1; min-width: 0; }
.os-item-name {
    font-size: 14px; font-weight: 500;
    color: var(--color-text-primary);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}

.os-item-meta {
    display: flex; align-items: center; gap: 8px; margin-top: 4px;
}

.os-qty-pill {
    background: var(--color-background-primary);
    border: 0.5px solid var(--color-border-tertiary);
    border-radius: 20px;
    padding: 1px 8px;
    font-size: 12px;
    color: var(--color-text-secondary);
}
.os-item-unit { font-size: 12px; color: var(--color-text-secondary); }

.os-item-total {
    font-size: 14px; font-weight: 500;
    color: var(--color-text-primary);
    font-variant-numeric: tabular-nums;
    white-space: nowrap;
}

/* Summary */
.os-summary { display: flex; flex-direction: column; gap: 7px; padding-top: .25rem; }
.os-summary-row {
    display: flex; justify-content: space-between;
    font-size: 14px; color: var(--color-text-primary);
}
.os-muted  { color: var(--color-text-secondary); }
.os-free   { color: #3B6D11; font-weight: 500; display: flex; align-items: center; gap: 4px; }
.os-divider { border: none; border-top: 0.5px solid var(--color-border-tertiary); margin: 4px 0; }
.os-grand-total { font-size: 15px; font-weight: 500; }
.os-total-amount { font-variant-numeric: tabular-nums; }

/* ===== DELIVERY INFO ===== */
.os-info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: .875rem 1.25rem;
}
.os-info-item {
    display: flex; align-items: flex-start; gap: 10px;
}
.os-info-icon {
    width: 32px; height: 32px; border-radius: 8px;
    background: var(--color-background-secondary);
    border: 0.5px solid var(--color-border-tertiary);
    display: flex; align-items: center; justify-content: center;
    font-size: 15px; color: var(--color-text-secondary);
    flex-shrink: 0; margin-top: 1px;
}
.os-info-icon--green { background: #EAF3DE; color: #3B6D11; border-color: #9FE1CB; }
.os-info-icon--amber { background: #FAEEDA; color: #854F0B; border-color: #FAC775; }

.os-info-key {
    font-size: 11px; font-weight: 500;
    text-transform: uppercase; letter-spacing: .05em;
    color: var(--color-text-tertiary);
    margin-bottom: 2px;
}
.os-info-val { font-size: 14px; color: var(--color-text-primary); line-height: 1.4; }
.os-pay-paid    { color: #3B6D11; font-weight: 500; }
.os-pay-pending { color: #854F0B; }

/* ===== HELP ===== */
.os-help {
    display: flex; align-items: center; gap: 12px;
    padding: 1rem 1.25rem;
    border-radius: 14px;
    border: 0.5px solid var(--color-border-tertiary);
    background: var(--color-background-primary);
}
.os-help-icon {
    font-size: 22px; color: var(--color-text-secondary); flex-shrink: 0;
}
.os-help-title { font-size: 14px; font-weight: 500; color: var(--color-text-primary); }
.os-help-sub   { font-size: 12px; color: var(--color-text-secondary); margin-top: 1px; }
.os-help-btn {
    margin-left: auto; flex-shrink: 0;
    display: inline-flex; align-items: center; gap: 6px;
    padding: 7px 14px; border-radius: 8px;
    font-size: 13px; font-weight: 500;
    background: #EAF3DE; color: #3B6D11;
    border: 0.5px solid #9FE1CB;
    text-decoration: none;
    transition: background .15s;
}
.os-help-btn:hover { background: #C0DD97; color: #27500A; }

/* ===== ANIMATIONS ===== */
@keyframes spin-slow {
    to { transform: rotate(360deg); }
}
.spin-slow { animation: spin-slow 3s linear infinite; display: inline-block; }

@keyframes truck-move {
    0%,100% { transform: translateX(0); }
    50%      { transform: translateX(4px); }
}
.truck-anim { animation: truck-move 1s ease-in-out infinite; display: inline-block; }

@keyframes reveal-up {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}
.os-reveal {
    animation: reveal-up .4s ease both;
}

@keyframes item-in {
    from { opacity: 0; transform: translateX(-10px); }
    to   { opacity: 1; transform: translateX(0); }
}
.os-item-reveal {
    animation: item-in .35s ease both;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 500px) {
    .os-info-grid { grid-template-columns: 1fr; }
    .os-step-pill { display: none; }
    .os-help { flex-wrap: wrap; }
    .os-help-btn { margin-left: 0; width: 100%; justify-content: center; }
    .os-hero-status { font-size: 17px; }
}
</style>

@endsection