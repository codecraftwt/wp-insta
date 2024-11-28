@extends('layouts.app')

@section('content')
    <div class="container mt-5 mb-5">
        <!-- Home Icon -->
        <a href="{{ url('/') }}" class="position-absolute top-0 end-0 p-3">
            <i class="fas fa-home fa-lg text-dark" style="font-size: 2rem;"></i>
        </a>

        <!-- Row for center-aligned form -->
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-lg">
                    <!-- Card Header -->
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h4 class="mb-0">Reset Password</h4>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-4">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <!-- Password Reset Form -->
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <!-- Email Input -->
                            <div class="mb-4">
                                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus
                                    placeholder="Enter your email address">

                                @error('email')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
