@extends('layouts.app')
@section('content')
<style>
.auth-wrapper { min-height: 85vh; display: flex; align-items: center; justify-content: center; padding: 2rem; }
.auth-card { width: 100%; max-width: 420px; background: #fff; border-radius: 16px; box-shadow: 0 1px 2px rgba(0,0,0,.06), 0 20px 60px rgba(0,0,0,.08); padding: 2.2rem 2rem; position: relative; overflow: hidden; }
.card-top-bar { position: absolute; top: 0; left: 0; right: 0; height: 3px; background: #534AB7; border-radius: 16px 16px 0 0; }
.card-deco { position: absolute; top: -40px; right: -40px; width: 140px; height: 140px; border-radius: 50%; background: #534AB7; opacity: .05; pointer-events: none; }
.card-badge { position: absolute; top: 1.1rem; right: 1.1rem; display: inline-flex; align-items: center; gap: 4px; font-size: 10px; font-weight: 500; padding: 3px 8px; border-radius: 99px; background: #EEEDFE; color: #534AB7; }
.icon-ring { width: 46px; height: 46px; border-radius: 50%; background: #EEEDFE; color: #534AB7; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 1rem; }
.auth-title { font-size: 20px; font-weight: 600; color: #1a1a2e; margin-bottom: 4px; }
.auth-sub { font-size: 13px; color: #6b7280; margin-bottom: 1.5rem; }
.social-row { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 1.2rem; }
.social-btn { height: 38px; border: 1px solid #e5e7eb; border-radius: 8px; background: #fff; display: flex; align-items: center; justify-content: center; gap: 7px; font-size: 13px; color: #374151; cursor: pointer; transition: background .2s; text-decoration: none; }
.social-btn:hover { background: #f9fafb; }
.divider { display: flex; align-items: center; gap: 10px; margin-bottom: 1.2rem; }
.divider hr { flex: 1; border: none; border-top: 1px solid #f0f0f0; }
.divider span { font-size: 11px; color: #9ca3af; white-space: nowrap; }
.field-group { margin-bottom: 12px; }
.field-label { font-size: 12px; color: #6b7280; margin-bottom: 5px; display: flex; align-items: center; gap: 5px; }
.field-wrap { display: flex; align-items: center; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; height: 40px; padding: 0 10px; gap: 8px; transition: border-color .2s; }
.field-wrap:focus-within { border-color: #534AB7; background: #fff; }
.field-wrap i { color: #9ca3af; font-size: 15px; }
.field-wrap input { flex: 1; border: none; background: transparent; outline: none; font-size: 13.5px; color: #111; }
.field-wrap input::placeholder { color: #bbb; }
.row-between { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.1rem; }
.check-label { font-size: 12px; color: #6b7280; display: flex; align-items: center; gap: 6px; }
.check-label input { accent-color: #534AB7; }
.forgot-link { font-size: 12px; color: #534AB7; text-decoration: none; }
.forgot-link:hover { text-decoration: underline; }
.submit-btn { width: 100%; height: 42px; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; letter-spacing: .02em; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 7px; transition: opacity .2s, transform .1s; background: #534AB7; color: #EEEDFE; }
.submit-btn:hover { opacity: .88; }
.submit-btn:active { transform: scale(.98); }
.card-footer-note { text-align: center; margin-top: 1.1rem; font-size: 13px; color: #6b7280; }
.card-footer-note a { color: #534AB7; text-decoration: none; font-weight: 500; }
body.dark-mode .auth-card { background: #1a1a2e; }
body.dark-mode .field-wrap { background: #232336; border-color: #3a3a5c; }
body.dark-mode .field-wrap input { color: #f0f0ff; }
body.dark-mode .auth-title { color: #e0e0ff; }
</style>
<div class="auth-wrapper">
  <div class="auth-card">
    <div class="card-top-bar"></div>
    <div class="card-deco"></div>
    <span class="card-badge"><i class="bi bi-shield-check"></i> Secure</span>
    <div class="icon-ring"><i class="bi bi-person"></i></div>
    <div class="auth-title">Welcome back</div>
    <div class="auth-sub">Sign in to your account</div>

    <div class="social-row">
      <a href="#" class="social-btn">
        <svg width="14" height="14" viewBox="0 0 24 24">...</svg> Google
      </a>
      <a href="#" class="social-btn">
        <i class="bi bi-github"></i> GitHub
      </a>
    </div>
    <div class="divider"><hr><span>or continue with email</span><hr></div>

    <form method="POST" action="{{ route('login') }}">
      @csrf
      <div class="field-group">
        <div class="field-label"><i class="bi bi-at"></i> Email</div>
        <div class="field-wrap">
          <i class="bi bi-envelope"></i>
          <input id="email" type="email" name="email" placeholder="you@example.com"
            value="{{ old('email') }}" required autofocus
            class="@error('email') is-invalid @enderror">
        </div>
        @error('email')<div class="text-danger mt-1" style="font-size:12px">{{ $message }}</div>@enderror
      </div>

      <div class="field-group">
        <div class="field-label"><i class="bi bi-lock"></i> Password</div>
        <div class="field-wrap">
          <i class="bi bi-lock"></i>
          <input id="password" type="password" name="password" placeholder="••••••••"
            required class="@error('password') is-invalid @enderror">
          <i class="bi bi-eye" style="cursor:pointer;color:#bbb" onclick="togglePw('password',this)"></i>
        </div>
        @error('password')<div class="text-danger mt-1" style="font-size:12px">{{ $message }}</div>@enderror
      </div>

      <div class="row-between">
        <label class="check-label">
          <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
          Remember me
        </label>
        @if (Route::has('password.request'))
          <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
        @endif
      </div>

      <button type="submit" class="submit-btn">
        <i class="bi bi-arrow-right-circle"></i> Sign in
      </button>
    </form>

    <div class="card-footer-note">
      No account? <a href="{{ route('register') }}">Create one</a>
    </div>
  </div>
</div>
<script>
function togglePw(id, icon) {
  const el = document.getElementById(id);
  el.type = el.type === 'password' ? 'text' : 'password';
  icon.className = el.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}
</script>
@endsection