@extends('layouts.app')

@section('content')
    <!-- Main Container -->
    <section class="section min-vh-100 d-flex flex-column align-items-center justify-content-center py-4"
        style="background: linear-gradient(135deg, #d9ffdc 0%, #e0f7fa 100%);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                    <div class="d-flex justify-content-center py-4">
                        <a href="/" class="logo d-flex align-items-center w-auto">
                            <img src="{{ asset('assets/img/walstarLogo.png') }}" alt="WALSTAR Logo" style="max-height: 50px;">
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

                            </form>

                            <div class="row text-center">
                                <!-- Sign up with Google -->
                                <div class="col-6">
                                    <button
                                        class="btn border border-success info d-flex align-items-center justify-content-center"
                                        id="googlesignup">
                                        <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg"
                                            alt="Sign in with Google" height="20" width="20" class="me-2"> Google
                                        Sign up
                                    </button>
                                </div>

                                <!-- Forgot Password -->
                                <div class="col-6">
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}"
                                            class="btn border border-danger d-flex align-items-center justify-content-center">
                                            <i class="fas fa-lock me-2"></i> Forgot password?
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div class="text-center mt-3">
                                <p>Don't have an account? <a href="subscription-plans" class="link-primary">Register
                                        here</a></p>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Google Sign Up script -->
    <script>
        document.getElementById("googlesignup").addEventListener("click", function() {
            window.location.href = "{{ route('auth.google.redirect') }}";
        });
    </script>

    <style>
        #googlesignup:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            /* Adds shadow with a little spread */
            transform: translateY(-2px);
            /* Lift the button slightly when hovered */
        }

        #googlesignup img {
            transition: transform 0.3s ease;
            /* Smooth transition for icon */
        }

        #googlesignup:hover img {
            transform: translateX(4px);
            /* Slight move to the right for the image on hover */
        }
    </style>
@endsection
