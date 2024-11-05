@extends('layouts.app')

@section('content')

<!-- Main Container -->
<div class="container  d-flex justify-content-center align-items-center bg-light">
    <div class="col-md-5">
        <div class="card shadow-sm border-0 rounded-4 p-4" id="loginCard">
            <div class="card-body">
                <!-- Form Header -->
                <h3 class="text-center fw-bold mb-4 text-primary">Sign in to Your Account</h3>

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf

                    <!-- Email Address -->
                    <div class="form-floating mb-3">
                        <input type="email" id="email" class="form-control rounded-3 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        <label for="email">Email Address</label>
                        @error('email')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-floating mb-3">
                        <input type="password" id="password" class="form-control rounded-3 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        <label for="password">Password</label>
                        @error('password')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">Remember Me</label>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg rounded-3">Sign In</button>
                    </div>

                    <!-- Forgot Password -->
                    <div class="text-center mt-3">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="link-primary">Forgot password?</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

<!-- Custom CSS -->
<style>
    /* Background and layout */
    .bg-light {
        background-color: #f5f5f5 !important;
    }

    /* Card styling */
    #loginCard {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    #loginCard:hover {
        transform: translateY(-5px);
        box-shadow: 0px 12px 20px rgba(0, 0, 0, 0.15);
    }

    /* Form header */
    .text-primary {
        color: #4285f4; /* Google blue */
    }

    /* Floating labels for form inputs */
    .form-floating label {
        color: #6c757d;
        transition: all 0.2s;
    }

    .form-floating input:focus ~ label {
        color: #4285f4; /* Google blue on focus */
        font-weight: bold;
    }

    /* Input field styling */
    .form-control {
        border-radius: 8px;
        border: 1px solid #ced4da;
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    .form-control:focus {
        border-color: #4285f4; /* Google blue */
        box-shadow: 0px 0px 5px rgba(66, 133, 244, 0.3);
    }

    /* Remember me checkbox */
    .form-check-input:checked {
        background-color: #4285f4;
        border-color: #4285f4;
    }

    /* Button styling */
    .btn-primary {
        background-color: #4285f4;
        border-color: #4285f4;
        transition: background-color 0.3s, box-shadow 0.3s;
    }

    .btn-primary:hover {
        background-color: #3071e7;
        border-color: #3071e7;
        box-shadow: 0px 4px 10px rgba(66, 133, 244, 0.3);
    }

    /* Forgot password link */
    .link-primary {
        color: #4285f4;
        text-decoration: none;
        font-weight: 500;
    }

    .link-primary:hover {
        text-decoration: underline;
    }
</style>
