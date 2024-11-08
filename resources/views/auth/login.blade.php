@extends('layouts.app')

@section('content')
    <a href="{{ url('/') }}" class="position-absolute top-0 end-0 p-3">
        <i class="fas fa-home fa-lg text-dark" style="font-size: 2rem;"></i>
    </a>
    <!-- Main Container -->
    <section class="section  min-vh-100 d-flex flex-column align-items-center justify-content-center py-4"
        style=" background: linear-gradient(135deg, #d9ffdc 0%, #e0f7fa 100%);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                    <div class="d-flex justify-content-center py-4">
                        <a href="/" class="logo d-flex align-items-center w-auto">
                            <img src="{{ asset('assets/img/walstarLogo.png') }}" alt="WALSTAR Logo"
                                style="max-height: 50px;">
                        </a>
                    </div><!-- End Logo -->

                    <div class="card shadow-sm w-100">
                        <div class="card-body p-4">
                            <div class="pt-4 pb-2 text-center">
                                <h5 class="card-title fs-4 fw-bold">Login to Your Account</h5>
                                <p class="text-muted small">Enter your username & password to login</p>
                            </div>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <!-- Email Address -->
                                <div class="form-floating mb-3">
                                    <input type="email"
                                        class="form-control rounded-3 @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus
                                        placeholder="Enter your email">
                                    <label for="email">Email Address</label>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="form-floating mb-3">
                                    <input type="password"
                                        class="form-control rounded-3 @error('password') is-invalid @enderror"
                                        name="password" required autocomplete="current-password"
                                        placeholder="Enter your password">
                                    <label for="password">Password</label>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-primary btn-lg rounded-3">Sign In</button>
                                </div>

                                <!-- Forgot Password -->
                                <div class="text-center">
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="link-primary">Forgot password?</a>
                                    @endif
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
