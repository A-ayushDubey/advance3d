@extends('layouts.app')

@section('content')

<style>
/* ================= REGISTER PAGE ================= */

.register-wrapper{
    min-height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.register-card{
    width: 100%;
    max-width: 450px;
    border: none;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    padding: 30px;
    background: #fff;
    transition: 0.3s;
}

.register-card:hover{
    transform: translateY(-5px);
}

/* Title */
.register-title{
    font-size: 24px;
    font-weight: 700;
    text-align: center;
    margin-bottom: 25px;
}

/* Input styling */
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
.register-btn{
    width: 100%;
    padding: 10px;
    border-radius: 6px;
    font-weight: 600;
    background: #0d6efd;
    border: none;
    transition: 0.3s;
}

.register-btn:hover{
    background: #0b5ed7;
}

/* Footer */
.register-links{
    text-align: center;
    margin-top: 15px;
}

.register-links a{
    font-size: 14px;
    text-decoration: none;
}

/* Dark mode */
body.dark-mode .register-card{
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


<div class="register-wrapper">

    <div class="register-card">

        <div class="register-title">
            Create Account 🚀
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- NAME -->
            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-person"></i>
                    </span>
                    <input id="name" type="text"
                        class="form-control @error('name') is-invalid @enderror"
                        name="name"
                        placeholder="Full name"
                        value="{{ old('name') }}"
                        required autofocus>
                </div>

                @error('name')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- EMAIL -->
            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-envelope"></i>
                    </span>
                    <input id="email" type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        name="email"
                        placeholder="Email address"
                        value="{{ old('email') }}"
                        required>
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
                        placeholder="Password"
                        required>
                </div>

                @error('password')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- CONFIRM PASSWORD -->
            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-shield-lock"></i>
                    </span>
                    <input id="password-confirm" type="password"
                        class="form-control"
                        name="password_confirmation"
                        placeholder="Confirm password"
                        required>
                </div>
            </div>

            <!-- BUTTON -->
            <button type="submit" class="register-btn">
                Register
            </button>

        </form>

        <!-- EXTRA LINKS -->
        <div class="register-links">
            <p class="mt-2">
                Already have an account?
                <a href="{{ route('login') }}">Login</a>
            </p>
        </div>

    </div>

</div>

@endsection