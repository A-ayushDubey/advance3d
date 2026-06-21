@extends('layouts.app')
@section('content')

<style>
* { box-sizing: border-box; }

.auth-wrapper {
    min-height: 85vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
}

.auth-card {
    width: 100%;
    max-width: 460px;
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 1px 2px rgba(0,0,0,.06), 0 20px 60px rgba(0,0,0,.08);
    padding: 2.4rem 2.2rem;
    position: relative;
    overflow: hidden;
    animation: slideUp 0.4s ease;
}

@keyframes slideUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* Top accent bar */
.card-top-bar {
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, #1D9E75, #0F6E56);
    border-radius: 20px 20px 0 0;
}

/* Background deco circle */
.card-deco {
    position: absolute;
    top: -50px; right: -50px;
    width: 160px; height: 160px;
    border-radius: 50%;
    background: #1D9E75;
    opacity: .05;
    pointer-events: none;
}
.card-deco-2 {
    position: absolute;
    bottom: -60px; left: -30px;
    width: 130px; height: 130px;
    border-radius: 50%;
    background: #0F6E56;
    opacity: .04;
    pointer-events: none;
}

/* Badge */
.card-badge {
    position: absolute;
    top: 1.1rem; right: 1.1rem;
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 10px; font-weight: 600;
    padding: 3px 10px;
    border-radius: 99px;
    background: #E1F5EE;
    color: #1D9E75;
    letter-spacing: .03em;
}

/* Icon ring */
.icon-ring {
    width: 50px; height: 50px;
    border-radius: 50%;
    background: #E1F5EE;
    color: #1D9E75;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px;
    margin-bottom: 1rem;
}

/* Title */
.auth-title {
    font-size: 22px;
    font-weight: 700;
    color: #0F1F1A;
    margin-bottom: 4px;
}
.auth-sub {
    font-size: 13px;
    color: #6b7280;
    margin-bottom: 1.6rem;
}

/* Field */
.field-group { margin-bottom: 14px; }
.field-label {
    font-size: 12px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 5px;
    display: flex; align-items: center; gap: 5px;
    letter-spacing: .01em;
    text-transform: uppercase;
}
.field-label i { font-size: 12px; color: #9ca3af; }

.field-wrap {
    display: flex; align-items: center;
    background: #f9fafb;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    height: 44px;
    padding: 0 12px;
    gap: 10px;
    transition: border-color .2s, background .2s, box-shadow .2s;
}
.field-wrap:focus-within {
    border-color: #1D9E75;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(29,158,117,.1);
}
.field-wrap i { color: #9ca3af; font-size: 15px; flex-shrink: 0; }
.field-wrap input {
    flex: 1; border: none; background: transparent;
    outline: none; font-size: 14px; color: #111;
}
.field-wrap input::placeholder { color: #c4c4c4; }

/* Two-column grid */
.row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

/* Strength bar */
.strength-wrap { margin-top: 6px; }
.strength-bar { display: flex; gap: 4px; margin-bottom: 4px; }
.strength-seg {
    flex: 1; height: 3px; border-radius: 2px;
    background: #e5e7eb;
    transition: background .3s;
}
.strength-label {
    font-size: 11px; color: #9ca3af;
    min-height: 14px;
    transition: color .3s;
}

/* Checklist */
.req-list {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 4px 12px; margin-top: 8px;
}
.req-item {
    display: flex; align-items: center; gap: 5px;
    font-size: 11px; color: #9ca3af;
    transition: color .2s;
}
.req-item i { font-size: 12px; }
.req-item.met { color: #1D9E75; }

/* TOS row */
.tos-row {
    display: flex; align-items: flex-start; gap: 8px;
    margin-bottom: 1.3rem; margin-top: 4px;
}
.tos-row input { accent-color: #1D9E75; margin-top: 2px; flex-shrink: 0; }
.tos-row label { font-size: 12.5px; color: #6b7280; line-height: 1.6; }
.tos-row a { color: #1D9E75; text-decoration: none; font-weight: 600; }
.tos-row a:hover { text-decoration: underline; }

/* Submit button */
.submit-btn {
    width: 100%; height: 46px;
    border: none; border-radius: 10px;
    font-size: 14.5px; font-weight: 700;
    letter-spacing: .03em;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    background: #1D9E75;
    color: #fff;
    transition: opacity .2s, transform .1s, box-shadow .2s;
    box-shadow: 0 4px 14px rgba(29,158,117,.3);
}
.submit-btn:hover { opacity: .9; box-shadow: 0 6px 20px rgba(29,158,117,.4); }
.submit-btn:active { transform: scale(.98); }

/* Footer note */
.card-footer-note {
    text-align: center;
    margin-top: 1.2rem;
    font-size: 13px;
    color: #6b7280;
}
.card-footer-note a {
    color: #1D9E75;
    text-decoration: none;
    font-weight: 600;
}
.card-footer-note a:hover { text-decoration: underline; }

/* Divider */
.divider {
    display: flex; align-items: center; gap: 10px;
    margin: 1.2rem 0;
}
.divider hr { flex: 1; border: none; border-top: 1px solid #f0f0f0; }
.divider span { font-size: 11px; color: #9ca3af; white-space: nowrap; }

/* Social buttons */
.social-row { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
.social-btn {
    height: 40px;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    background: #fff;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    font-size: 13px; font-weight: 500;
    color: #374151;
    cursor: pointer;
    text-decoration: none;
    transition: background .2s, border-color .2s;
}
.social-btn:hover { background: #f9fafb; border-color: #d1d5db; }

/* Error */
.field-error {
    font-size: 11.5px; color: #dc2626;
    margin-top: 4px;
    display: flex; align-items: center; gap: 4px;
}

/* Dark mode */
body.dark-mode .auth-card { background: #0f1f1a; }
body.dark-mode .auth-title { color: #e0fff5; }
body.dark-mode .auth-sub { color: #6b9e8a; }
body.dark-mode .field-wrap { background: #162820; border-color: #1f3d30; }
body.dark-mode .field-wrap:focus-within { background: #1a3028; }
body.dark-mode .field-wrap input { color: #d0ffe8; }
body.dark-mode .field-label { color: #9bbfaf; }
body.dark-mode .card-badge { background: #0f3328; color: #5DCAA5; }
body.dark-mode .icon-ring { background: #0f3328; }
body.dark-mode .social-btn { background: #162820; border-color: #1f3d30; color: #9bbfaf; }
body.dark-mode .tos-row label { color: #6b9e8a; }
body.dark-mode .strength-seg { background: #1f3d30; }
</style>

<div class="auth-wrapper">
    <div class="auth-card">

        <div class="card-top-bar"></div>
        <div class="card-deco"></div>
        <div class="card-deco-2"></div>
        <span class="card-badge">
            <i class="bi bi-stars"></i> Free Forever
        </span>

        <div class="icon-ring">
            <i class="bi bi-person-plus"></i>
        </div>
        <div class="auth-title">Create your account</div>
        <div class="auth-sub">Join thousands of users — it only takes a minute</div>

        <!-- Social signup -->
        <div class="social-row">
            <a href="#" class="social-btn">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57C21.36 18.36 22.56 15.55 22.56 12.25z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                Sign up with Google
            </a>
            <a href="#" class="social-btn">
                <i class="bi bi-github" style="font-size:16px"></i>
                Sign up with GitHub
            </a>
        </div>

        <div class="divider">
            <hr><span>or register with email</span><hr>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Full Name -->
            <div class="field-group">
                <div class="field-label">
                    <i class="bi bi-person"></i> Full Name
                </div>
                <div class="field-wrap">
                    <i class="bi bi-person"></i>
                    <input id="name" type="text" name="name"
                        placeholder="Jane Smith"
                        value="{{ old('name') }}"
                        required autofocus
                        class="@error('name') is-invalid @enderror">
                </div>
                @error('name')
                    <div class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="field-group">
                <div class="field-label">
                    <i class="bi bi-envelope"></i> Email Address
                </div>
                <div class="field-wrap">
                    <i class="bi bi-at"></i>
                    <input id="email" type="email" name="email"
                        placeholder="jane@example.com"
                        value="{{ old('email') }}"
                        required
                        class="@error('email') is-invalid @enderror">
                </div>
                @error('email')
                    <div class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                @enderror
            </div>

            <!-- Password + Confirm in 2 cols -->
            <div class="row-2">
                <div class="field-group">
                    <div class="field-label">
                        <i class="bi bi-lock"></i> Password
                    </div>
                    <div class="field-wrap">
                        <i class="bi bi-lock"></i>
                        <input id="password" type="password" name="password"
                            placeholder="Create password"
                            required
                            oninput="updateStrength(this.value)"
                            class="@error('password') is-invalid @enderror">
                        <i class="bi bi-eye" style="cursor:pointer;color:#c4c4c4;font-size:14px"
                           onclick="togglePw('password', this)"></i>
                    </div>
                    @error('password')
                        <div class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="field-group">
                    <div class="field-label">
                        <i class="bi bi-shield-lock"></i> Confirm
                    </div>
                    <div class="field-wrap">
                        <i class="bi bi-shield-check"></i>
                        <input id="password-confirm" type="password"
                            name="password_confirmation"
                            placeholder="Repeat password"
                            required>
                        <i class="bi bi-eye" style="cursor:pointer;color:#c4c4c4;font-size:14px"
                           onclick="togglePw('password-confirm', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Strength bar -->
            <div class="strength-wrap" style="margin-top:-6px; margin-bottom:12px;">
                <div class="strength-bar">
                    <div class="strength-seg" id="s1"></div>
                    <div class="strength-seg" id="s2"></div>
                    <div class="strength-seg" id="s3"></div>
                    <div class="strength-seg" id="s4"></div>
                </div>
                <div class="strength-label" id="strength-label"></div>
            </div>

            <!-- Requirement checklist -->
            <div class="req-list" id="req-list" style="margin-bottom:14px;">
                <div class="req-item" id="r-len">
                    <i class="bi bi-circle"></i> 8+ characters
                </div>
                <div class="req-item" id="r-upper">
                    <i class="bi bi-circle"></i> Uppercase letter
                </div>
                <div class="req-item" id="r-num">
                    <i class="bi bi-circle"></i> Number
                </div>
                <div class="req-item" id="r-special">
                    <i class="bi bi-circle"></i> Special character
                </div>
            </div>

            <!-- Terms -->
            <div class="tos-row">
                <input type="checkbox" id="tos" required>
                <label for="tos">
                    I agree to the <a href="#">Terms of Service</a>
                    and <a href="#">Privacy Policy</a>. We'll never share your data.
                </label>
            </div>

            <!-- Submit -->
            <button type="submit" class="submit-btn">
                <i class="bi bi-rocket-takeoff"></i>
                Create My Account
            </button>

        </form>

        <div class="card-footer-note">
            Already have an account?
            <a href="{{ route('login') }}">Sign in instead</a>
        </div>

    </div>
</div>

<script>
function togglePw(id, icon) {
    const el = document.getElementById(id);
    el.type = el.type === 'password' ? 'text' : 'password';
    icon.className = el.type === 'password'
        ? 'bi bi-eye'
        : 'bi bi-eye-slash';
    icon.style.cssText = 'cursor:pointer;color:#c4c4c4;font-size:14px';
}

function updateStrength(val) {
    const checks = {
        'r-len':     val.length >= 8,
        'r-upper':   /[A-Z]/.test(val),
        'r-num':     /[0-9]/.test(val),
        'r-special': /[^A-Za-z0-9]/.test(val),
    };

    Object.entries(checks).forEach(([id, met]) => {
        const el = document.getElementById(id);
        el.classList.toggle('met', met);
        el.querySelector('i').className = met
            ? 'bi bi-check-circle-fill'
            : 'bi bi-circle';
    });

    const score = Object.values(checks).filter(Boolean).length;
    const segs  = ['s1','s2','s3','s4'];
    const colors = {
        1: '#ef4444',
        2: '#f97316',
        3: '#eab308',
        4: '#1D9E75',
    };
    const labels = {
        0: '',
        1: 'Weak',
        2: 'Fair',
        3: 'Good',
        4: 'Strong ✓',
    };
    const labelColors = {
        1: '#ef4444', 2: '#f97316', 3: '#eab308', 4: '#1D9E75'
    };

    segs.forEach((id, i) => {
        const el = document.getElementById(id);
        el.style.background = i < score && score > 0
            ? colors[score]
            : '';
        el.style.background = el.style.background || '#e5e7eb';
    });

    if (score > 0) {
        segs.forEach((id, i) => {
            document.getElementById(id).style.background =
                i < score ? colors[score] : '#e5e7eb';
        });
    }

    const lbl = document.getElementById('strength-label');
    lbl.textContent = val.length > 0 ? `Password strength: ${labels[score]}` : '';
    lbl.style.color = labelColors[score] || '#9ca3af';
}
</script>

@endsection