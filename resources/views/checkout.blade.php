@extends('layouts.app')

@section('content')

<div class="checkout-page">
<h2 class="checkout-heading">
    <i class="ti ti-shopping-bag"></i> Checkout
</h2>

<div class="checkout-grid">

{{-- ===== LEFT ===== --}}
<div class="checkout-left">

    {{-- Billing --}}
    <div class="co-card">
        <div class="co-section-head"><span class="co-step">1</span> Billing details</div>

        <form id="checkoutForm" action="{{ route('place.order') }}" method="POST">
        @csrf
        <input type="hidden" name="payment_method" id="paymentMethodInput" value="cod">

        <div class="co-field">
            <label>Full name</label>
            <input type="text" name="name" placeholder="Enter your full name" required>
            <span class="co-err" id="err-name"></span>
        </div>
        <div class="co-field">
            <label>Phone number</label>
            <input type="tel" name="phone" placeholder="10-digit mobile number" required>
            <span class="co-err" id="err-phone"></span>
        </div>
        <div class="co-field">
            <label>Delivery address</label>
            <textarea name="address" placeholder="House no., street, area, city, pincode" required></textarea>
            <span class="co-err" id="err-address"></span>
        </div>
        </form>
    </div>

    {{-- Payment --}}
    <div class="co-card" style="margin-top: 1rem">
        <div class="co-section-head"><span class="co-step">2</span> Payment method</div>

        <div class="co-pay-options">

            <label class="co-pay-opt active" data-value="cod">
                <input type="radio" name="payment_method" value="cod" checked hidden>
                <div class="co-pay-icon icon-cod"><i class="ti ti-cash"></i></div>
                <div class="co-pay-text">
                    <div class="co-pay-name">Cash on delivery</div>
                    <div class="co-pay-sub">Pay when your order arrives</div>
                </div>
                <i class="ti ti-check co-check" id="chk-cod"></i>
            </label>

            <label class="co-pay-opt" data-value="upi">
                <input type="radio" name="payment_method" value="upi" hidden>
                <div class="co-pay-icon icon-upi"><i class="ti ti-device-mobile"></i></div>
                <div class="co-pay-text">
                    <div class="co-pay-name">UPI</div>
                    <div class="co-pay-sub">PhonePe · GPay · Paytm</div>
                </div>
                <i class="ti ti-check co-check" id="chk-upi" style="display:none"></i>
            </label>

            <label class="co-pay-opt" data-value="razorpay">
                <input type="radio" name="payment_method" value="razorpay" hidden>
                <div class="co-pay-icon icon-rzp"><i class="ti ti-credit-card"></i></div>
                <div class="co-pay-text">
                    <div class="co-pay-name">Online payment</div>
                    <div class="co-pay-sub">Cards · Netbanking · Razorpay</div>
                </div>
                <i class="ti ti-check co-check" id="chk-rzp" style="display:none"></i>
            </label>

        </div>

        @php
            $upiLink = "upi://pay?pa=9617371417@ybl&pn=ADVANCE3D&am={$total}&cu=INR";
        @endphp

        <div class="co-upi-qr" id="upiQR" style="display:none">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=160x160&data={{ urlencode($upiLink) }}" alt="UPI QR Code">
            <div class="co-upi-caption"><i class="ti ti-qrcode"></i> Scan with any UPI app on desktop</div>
            <div class="co-upi-caption muted">On mobile, tap the button below to open your UPI app</div>
        </div>
    </div>

</div>

{{-- ===== RIGHT ===== --}}
<div class="checkout-right">
    <div class="co-card co-sticky">

        <div class="co-section-head"><span class="co-step">3</span> Order summary</div>

        @foreach($cart as $item)
            <div class="co-line">
                <span class="co-item-name">
                    {{ $item['name'] }}
                    <span class="co-qty">× {{ $item['quantity'] }}</span>
                </span>
                <span class="co-item-price">₹{{ number_format($item['price'] * $item['quantity']) }}</span>
            </div>
        @endforeach

        <hr class="co-divider">

        <div class="co-line">
            <span class="co-muted">Subtotal</span>
            <span>₹{{ number_format($total) }}</span>
        </div>
        <div class="co-line">
            <span class="co-muted">Shipping</span>
            <span class="co-free">
                <i class="ti ti-truck" style="font-size:13px;vertical-align:-1px"></i> Free
            </span>
        </div>

        <hr class="co-divider">

        <div class="co-line co-total">
            <span>Total</span>
            <span>₹{{ number_format($total) }}</span>
        </div>

        <button type="button" id="mainBtn" class="co-btn co-btn-cod" disabled>
            <i class="ti ti-package" id="btnIcon"></i>
            <span id="btnLabel">Place order (COD)</span>
        </button>

        <div class="co-trust">
            <i class="ti ti-shield-check"></i>
            Secure checkout · Verified orders · Real 3D prints
        </div>

    </div>
</div>

</div>
</div>

{{-- Razorpay SDK --}}
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
const TOTAL      = {{ $total }};
const UPI_LINK   = "{{ $upiLink }}";
const RZP_KEY    = "{{ env('RAZORPAY_KEY') }}";
const ORDER_URL  = "{{ route('place.order') }}";
const VERIFY_URL = "{{ route('payment.verify') }}";
const CSRF       = "{{ csrf_token() }}";

let currentMethod = 'cod';

const payConfigs = {
    cod:      { label: 'Place order (COD)',  icon: 'ti-package',       cls: 'co-btn-cod' },
    upi:      { label: 'Pay via UPI',        icon: 'ti-device-mobile', cls: 'co-btn-upi' },
    razorpay: { label: 'Pay with Razorpay',  icon: 'ti-credit-card',   cls: 'co-btn-rzp' },
};

const mainBtn        = document.getElementById('mainBtn');
const btnLabel       = document.getElementById('btnLabel');
const btnIcon        = document.getElementById('btnIcon');
const upiQR          = document.getElementById('upiQR');
const payMethodInput = document.getElementById('paymentMethodInput');
const checkoutForm   = document.getElementById('checkoutForm');

// Inline validation
function validateForm() {
    const fields = [
        { name: 'name',    id: 'err-name',    msg: 'Please enter your full name' },
        { name: 'phone',   id: 'err-phone',   msg: 'Please enter your phone number' },
        { name: 'address', id: 'err-address', msg: 'Please enter your delivery address' },
    ];
    let valid = true;
    fields.forEach(f => {
        const el  = checkoutForm.querySelector(`[name="${f.name}"]`);
        const err = document.getElementById(f.id);
        if (!el.value.trim()) {
            err.textContent = f.msg;
            el.classList.add('co-input-err');
            valid = false;
        } else {
            err.textContent = '';
            el.classList.remove('co-input-err');
        }
    });
    return valid;
}

// Clear error on input
checkoutForm.addEventListener('input', (e) => {
    mainBtn.disabled = false;
    e.target.classList.remove('co-input-err');
    const errMap = { name: 'err-name', phone: 'err-phone', address: 'err-address' };
    if (errMap[e.target.name]) document.getElementById(errMap[e.target.name]).textContent = '';
});

// Payment method switch
document.querySelectorAll('.co-pay-opt').forEach(opt => {
    opt.addEventListener('click', () => {
        const val = opt.dataset.value;
        currentMethod = val;
        payMethodInput.value = val;

        document.querySelectorAll('.co-pay-opt').forEach(o => o.classList.remove('active'));
        opt.classList.add('active');
        document.querySelectorAll('.co-check').forEach(c => c.style.display = 'none');
        document.getElementById('chk-' + (val === 'razorpay' ? 'rzp' : val)).style.display = '';

        upiQR.style.display = val === 'upi' ? 'flex' : 'none';

        const cfg = payConfigs[val];
        mainBtn.className    = 'co-btn ' + cfg.cls;
        btnLabel.textContent = cfg.label;
        btnIcon.className    = 'ti ' + cfg.icon;
    });
});

// Main button
mainBtn.addEventListener('click', async () => {
    if (!validateForm()) return;
    if (currentMethod === 'cod')           submitCOD();
    else if (currentMethod === 'upi')      submitUPI();
    else                                   submitRazorpay();
});

function submitCOD() {
    payMethodInput.value = 'cod';
    setLoading(true, 'Placing your order…');
    checkoutForm.submit();
}

function submitUPI() {
    if (/Android|iPhone/i.test(navigator.userAgent)) {
        window.location.href = UPI_LINK;
    } else {
        alert('Scan the QR code with your UPI app to complete payment.');
    }
}

async function submitRazorpay() {
    setLoading(true, 'Creating order…');
    const formData = new FormData(checkoutForm);
    formData.set('payment_method', 'razorpay');

    try {
        const res  = await fetch(ORDER_URL, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF },
            body: formData,
        });
        const data = await res.json();
        if (!data.order_id) throw new Error('Order creation failed');
        setLoading(false);

        const rzp = new Razorpay({
            key:         RZP_KEY,
            amount:      data.amount * 100,
            currency:    'INR',
            name:        'ADVANCE3D',
            description: 'Order #' + data.order_id,
            order_id:    data.razorpay_order_id ?? undefined,

            handler: async (response) => {
                setLoading(true, 'Verifying payment…');
                try {
                    const vRes = await fetch(VERIFY_URL, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': CSRF,
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            payment_id: response.razorpay_payment_id,
                            order_id:   data.order_id,
                        }),
                    });
                    const result = await vRes.json();
                    if (result.success) {
                        window.location.href = '/order/' + result.order_id;
                    } else {
                        setLoading(false);
                        alert('Payment verification failed. Save this ID for support: ' + response.razorpay_payment_id);
                    }
                } catch {
                    setLoading(false);
                    alert('Verification error. Please contact support.');
                }
            },

            modal: { ondismiss: () => setLoading(false) },
        });

        rzp.on('payment.failed', (e) => {
            setLoading(false);
            alert('Payment failed: ' + (e.error?.description ?? 'Please try again.'));
        });

        rzp.open();

    } catch {
        setLoading(false);
        alert('Could not create order. Please try again.');
    }
}

function setLoading(on, msg = '') {
    mainBtn.disabled = on;
    if (on) {
        btnIcon.className    = 'ti ti-loader-2';
        btnLabel.textContent = msg;
    } else {
        const cfg            = payConfigs[currentMethod];
        mainBtn.className    = 'co-btn ' + cfg.cls;
        btnIcon.className    = 'ti ' + cfg.icon;
        btnLabel.textContent = cfg.label;
    }
}
</script>

<style>
.checkout-page {
    max-width: 900px;
    margin: 2.5rem auto;
    padding: 0 1.25rem;
}

.checkout-heading {
    font-size: 19px;
    font-weight: 500;
    margin-bottom: 1.75rem;
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--color-text-primary);
}

.checkout-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.25rem;
    align-items: start;
}

@media (max-width: 680px) {
    .checkout-grid  { grid-template-columns: 1fr; }
    .co-sticky      { position: static !important; }
}

.co-card {
    background: var(--color-background-primary);
    border: 0.5px solid var(--color-border-tertiary);
    border-radius: 12px;
    padding: 1.25rem 1.375rem;
}

.co-sticky { position: sticky; top: 1rem; }

.co-section-head {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 11px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: .07em;
    color: var(--color-text-secondary);
    margin-bottom: 1.1rem;
}

.co-step {
    width: 19px; height: 19px;
    border-radius: 50%;
    background: var(--color-background-secondary);
    border: 0.5px solid var(--color-border-secondary);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    font-weight: 500;
    color: var(--color-text-secondary);
    flex-shrink: 0;
}

/* Fields */
.co-field { margin-bottom: 1rem; }

.co-field label {
    display: block;
    font-size: 12px;
    font-weight: 500;
    color: var(--color-text-secondary);
    margin-bottom: 5px;
}

.co-field input,
.co-field textarea {
    width: 100%;
    padding: 9px 12px;
    font-size: 14px;
    border: 0.5px solid var(--color-border-tertiary);
    border-radius: 8px;
    background: var(--color-background-secondary);
    color: var(--color-text-primary);
    outline: none;
    transition: border-color .15s, background .15s;
    font-family: var(--font-sans);
}

.co-field input::placeholder,
.co-field textarea::placeholder {
    color: var(--color-text-tertiary);
    font-size: 13px;
}

.co-field input:focus,
.co-field textarea:focus {
    border-color: var(--color-border-primary);
    background: var(--color-background-primary);
}

.co-field textarea { resize: none; height: 80px; }

.co-input-err { border-color: #E24B4A !important; }

.co-err {
    display: block;
    font-size: 11px;
    color: #E24B4A;
    margin-top: 4px;
    min-height: 15px;
}

/* Payment options */
.co-pay-options { display: flex; flex-direction: column; gap: 6px; }

.co-pay-opt {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    border: 0.5px solid var(--color-border-tertiary);
    border-radius: 9px;
    cursor: pointer;
    transition: border-color .15s, background .15s;
    user-select: none;
}

.co-pay-opt:hover { background: var(--color-background-secondary); }

.co-pay-opt.active {
    border-color: #378ADD;
    background: var(--color-background-info);
}

.co-pay-icon {
    width: 34px; height: 34px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
}

.icon-cod { background: #EAF3DE; color: #3B6D11; }
.icon-upi { background: #E1F5EE; color: #0F6E56; }
.icon-rzp { background: #EEEDFE; color: #3C3489; }

.co-pay-text { flex: 1; }
.co-pay-name { font-size: 14px; font-weight: 500; color: var(--color-text-primary); }
.co-pay-sub  { font-size: 12px; color: var(--color-text-secondary); margin-top: 1px; }
.co-check    { font-size: 15px; }

/* UPI QR */
.co-upi-qr {
    margin-top: 1rem;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    padding: 1rem;
    border: 0.5px solid var(--color-border-tertiary);
    border-radius: 9px;
    background: var(--color-background-secondary);
}

.co-upi-qr img { border-radius: 6px; }

.co-upi-caption {
    font-size: 12px;
    color: var(--color-text-secondary);
    text-align: center;
}

.co-upi-caption.muted { opacity: .65; }

/* Order summary lines */
.co-line {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    font-size: 14px;
    padding: 5px 0;
    gap: 8px;
}

.co-item-name {
    color: var(--color-text-primary);
    flex: 1;
    min-width: 0;
}

.co-item-price {
    white-space: nowrap;
    font-variant-numeric: tabular-nums;
}

.co-total {
    font-weight: 500;
    font-size: 15px;
}

.co-muted { color: var(--color-text-secondary); }
.co-qty   { color: var(--color-text-secondary); font-size: 13px; margin-left: 3px; }
.co-free  { color: #3B6D11; font-weight: 500; }

.co-divider {
    border: none;
    border-top: 0.5px solid var(--color-border-tertiary);
    margin: .75rem 0;
}

/* Button */
.co-btn {
    width: 100%;
    margin-top: 1rem;
    padding: 11px 16px;
    font-size: 14px;
    font-weight: 500;
    border-radius: 9px;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    transition: opacity .15s, transform .1s;
    font-family: var(--font-sans);
    letter-spacing: .01em;
}

.co-btn:active:not(:disabled) { transform: scale(0.98); }
.co-btn:disabled { opacity: .45; cursor: not-allowed; }

.co-btn-cod { background: #1D9E75; color: #fff; }
.co-btn-upi { background: #0F6E56; color: #fff; }
.co-btn-rzp { background: #534AB7; color: #fff; }

/* Trust */
.co-trust {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    color: var(--color-text-tertiary);
    margin-top: .875rem;
    justify-content: center;
}

/* Loader */
@keyframes spin { to { transform: rotate(360deg); } }
.ti-loader-2 { animation: spin .9s linear infinite; display: inline-block; }
</style>

@endsection