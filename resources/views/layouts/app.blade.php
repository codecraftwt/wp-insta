<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="https://www.walstartechnologies.com/wp-content/uploads/2024/09/Favicons3-150x150.png"
        sizes="32x32" />
    <link rel="icon" href="https://www.walstartechnologies.com/wp-content/uploads/2024/09/Favicons3-300x300.png"
        sizes="192x192" />
    <link rel="apple-touch-icon"
        href="https://www.walstartechnologies.com/wp-content/uploads/2024/09/Favicons3-300x300.png" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>InstantPress</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Open+Sans:wght@400;600&display=swap"
        rel="stylesheet">

    <link href="assets/landing-css/landingstyle.css" rel="stylesheet">

    <!-- Custom CSS to fix alignment issues -->

</head>

<body>
    @if (request()->routeIs('login') || request()->routeIs('password.request'))
        <!-- Do not show the footer -->
    @else
        <div id="app">

            <nav class="navbar navbar-expand-lg navbar-light navbar-section sticky-top" id="nav-section">
                <div class="container">
                    <div class="row w-100 align-items-center">
                        <!-- First Column: Logo -->
                        <div class="col-6 col-lg-2 text-center">
                            <a class="navbar-brand" href="{{ url('/') }}">
                                <img src="{{ asset('assets/img/walstarLogo.png') }}" alt="Walstar Logo" width="150"
                                    height="50" />
                            </a>
                        </div>
        
                        <!-- Second Column: Navbar Toggler (Visible only on mobile) -->
                        <div class="col-6 col-lg-2 d-lg-none text-end">
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                        </div>
        
                        <!-- Third Column: Navigation Links -->
                        <div class="col-12 col-lg-7">
                            <div class="collapse navbar-collapse justify-content-center text-center" id="navbarNav">
                                <ul class="navbar-nav">
                                    <li class="nav-item mx-1">
                                        <a class="nav-link fw-bold {{ request()->is('/') ? 'active' : '' }}" href="/">Home</a>
                                    </li>
                                    <li class="nav-item mx-1">
                                        <a class="nav-link fw-bold {{ request()->is('about') ? 'active' : '' }}" href="/about">About Us</a>
                                    </li>
                                    <li class="nav-item mx-1">
                                        <a class="nav-link fw-bold {{ request()->is('pricing') ? 'active' : '' }}" href="/pricing">Pricing</a>
                                    </li>
                                    <li class="nav-item mx-1">
                                        <a class="nav-link fw-bold {{ request()->is('templates') ? 'active' : '' }}" href="/templates">Templates</a>
                                    </li>
                                    <li class="nav-item mx-1">
                                        <a class="nav-link fw-bold {{ request()->is('services') ? 'active' : '' }}" href="/services">Services</a>
                                    </li>
                                    <li class="nav-item mx-1">
                                        <a class="nav-link fw-bold {{ request()->is('contact') ? 'active' : '' }}" href="/contact">Contact</a>
                                    </li>
                        
                                    <!-- Mobile Buttons -->
                                    <li class="nav-item d-lg-none mx-1">
                                        @if (Auth::check())
                                            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-primary login">Logout</button>
                                            </form>
                                            <a class="btn register" href="/dashboard">Dashboard</a>
                                        @else
                                            <a class="btn btn-primary login mx-1" href="/login">Login</a>
                                            <a class="btn register mx-1" href="subscription-plans">
                                                Get Started <i class="fa fa-star ms-2"></i>
                                            </a>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
        
        
                        <!-- Fourth Column: Buttons (Visible on desktop) -->
                        <div class="col-6 col-lg-3 text-end d-none d-lg-block">
                            @if (Auth::check())
                                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary login me-2">Logout</button>
                                </form>
                                <a class="btn register" href="/dashboard">Dashboard</a>
                            @else
                                <a class="btn btn-primary login me-2" href="/login">Login</a>
                                <a class="btn register" href="subscription-plans">
                                    Get Started <i class="fa fa-star ms-2"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </nav>

    @endif
    <main>
        @yield('content')
    </main>

    @if (request()->routeIs('login') || request()->routeIs('password.request'))
        <!-- Do not show the footer -->
    @else
        <section class="project section_5">
            <div class="footer"
                style="background-color: {{ isset($siteSetting) ? $siteSetting->footer_background : '#333' }}; color: {{ isset($siteSetting) ? $siteSetting->footer_text : '#fff' }};">
                <div class="container">
                    <div class="row footer-container">
                        <!-- Logo and Company Info -->
                        <div class="col-12 col-md-3 mb-4 mt-5 text-center text-md-start">
                            <div class="logo mb-4">
                                <a class="footer-brand" href="{{ url('/') }}">
                                    <img src="{{ asset(isset($siteSetting) && $siteSetting->logo ? $siteSetting->logo : 'assets/img/walstarLogo.png') }}"
                                        alt="Walstar Logo" class="img-fluid fimg">
                                </a>
                            </div>
                            <p>We are an award-winning multinational Company. We believe in quality and standards
                                worldwide.
                            </p>
                        </div>

                        <!-- Useful Links -->
                        <div class="col-12 col-md-3 mb-4 mt-5 text-center text-md-start">
                            <h5 class="mb-4">Useful Links</h5>
                            <ul class="list-unstyled">
                                <li><a href="/" class="text-decoration-none" style="color: inherit;">Home</a>
                                </li>
                                <li><a href="/about" class="text-decoration-none" style="color: inherit;">About
                                        Us</a>
                                </li>
                                <li><a href="/terms" class="text-decoration-none" style="color: inherit;">Terms &
                                        Conditions</a></li>
                                <li><a href="/templates" class="text-decoration-none"
                                        style="color: inherit;">Templates</a></li>
                                <li><a href="/services" class="text-decoration-none"
                                        style="color: inherit;">Services</a></li>
                            </ul>
                        </div>

                        <!-- Contact Information -->
                        <div class="col-12 col-md-3 mb-4 mt-5 text-center text-md-start">
                            <h5 class="mb-4">Contact Us</h5>
                            <p><i class="fas fa-map-marker-alt"></i> 2103/47 E, Rukmini Nagar, Front Of Datta Mandir,
                                Kolhapur,
                                Maharashtra 416005</p>
                            <p><i class="fas fa-phone-alt"></i> +91 777 503 2331</p>
                            <p><i class="fas fa-envelope"></i> info@walstartechnologies.com</p>
                        </div>
                    </div>

                    <!-- Social Icons and Footer Text -->
                    <div class="row mt-4">
                        <div class="col-12 text-center">
                            <div class="social-icons mb-3">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                                <a href="#"><i class="fab fa-dribbble"></i></a>
                            </div>
                            <p class="copyright">Copyright © 2024 All Rights Reserved Terms of Use and Privacy Policy
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    </div>
</body>

</html>
