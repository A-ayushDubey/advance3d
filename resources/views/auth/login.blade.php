@extends('layouts.app')

@section('content')

<style>
/* ================= LOGIN PAGE ================= */

.login-wrapper{
    min-height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.login-card{
    width: 100%;
    max-width: 420px;
    border: none;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    padding: 30px;
    background: #fff;
    transition: 0.3s;
}

.login-card:hover{
    transform: translateY(-5px);
}

/* Heading */
.login-title{
    font-size: 24px;
    font-weight: 700;
    text-align: center;
    margin-bottom: 25px;
}

/* Input group */
.input-group-text{
    background: #f1f1f1;
    border: none;
}

.form-control{
    border-radius: 6px;
    border: 1px solid #ddd;
    padding: 10px;
}

.form-control:focus{
    box-shadow: none;
    border-color: #0d6efd;
}

/* Button */
.login-btn{
    width: 100%;
    padding: 10px;
    border-radius: 6px;
    font-weight: 600;
    background: #0d6efd;
    border: none;
    transition: 0.3s;
}

.login-btn:hover{
    background: #0b5ed7;
}

/* Footer links */
.login-links{
    text-align: center;
    margin-top: 15px;
}

.login-links a{
    font-size: 14px;
    text-decoration: none;
}

/* Dark mode support */
body.dark-mode .login-card{
    background: #1e1e1e;
    color: white;
}

body.dark-mode .form-control{
    background: #2a2a2a;
    color: white;
    border-color: #444;
}

body.dark-mode .input-group-text{
    background: #2a2a2a;
    color: white;
}
</style>


<div class="login-wrapper">

    <div class="login-card">

        <div class="login-title">
            Welcome Back 👋
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- EMAIL -->
            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-envelope"></i>
                    </span>
                    <input id="email" type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        name="email"
                        placeholder="Enter your email"
                        value="{{ old('email') }}"
                        required autofocus>
                </div>

                @error('email')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- PASSWORD -->
            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input id="password" type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        name="password"
                        placeholder="Enter your password"
                        required>
                </div>

                @error('password')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- REMEMBER -->
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                        {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        Remember me
                    </label>
                </div>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        Forgot?
                    </a>
                @endif
            </div>

            <!-- BUTTON -->
            <button type="submit" class="login-btn">
                Login
            </button>

        </form>

        <!-- EXTRA LINKS -->
        <div class="login-links">
            <p class="mt-2">
                Don’t have an account?
                <a href="{{ route('register') }}">Register</a>
            </p>
        </div>

    </div>

</div>

@endsection