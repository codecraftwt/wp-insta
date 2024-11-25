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
    <style>
        /* Remove any default margin or padding on the body */
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        /* Adjust navbar padding */
        .navbar {
            padding: 0.5rem 1rem;
        }

        /* Align buttons properly */
        .navbar .btn {
            margin-left: 0.5rem;
        }

        .section_1 {
            background: linear-gradient(135deg, #f1fdf6 0%, #f7f7f7 100%);


        }
    </style>
</head>

<body>
    @if (request()->routeIs('login') || request()->routeIs('password.request'))
        <!-- Do not show the footer -->
    @else
        <div id="app">


            <nav class="navbar navbar-expand-lg navbar-light"
                style="background: linear-gradient(135deg, #d9ffdc 0%, #e0f7fa 100%);">
                <div class="container">
                    <!-- Logo Section -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ asset('assets/img/walstarLogo.png') }}" alt="Walstar Logo" width="150"
                            height="50" />
                    </a>

                    <!-- Toggler Button for Mobile View -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <!-- Navbar Links -->
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto w-100 justify-content-around text-center">
                            <!-- Centered Links with Equal Spacing -->
                            <li class="nav-item">
                                <a class="nav-link" href="/">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/about">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/pricing">Pricing</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/templates">Templates</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/services">Services</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/contact">Contact</a>
                            </li>

                            <!-- Right-Aligned Buttons -->
                            <li class="nav-item">
                                <a class="btn btn-primary login" href="/login">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn register" href="/register-page">
                                    Get Started <i class="fa fa-star ms-2"></i>
                                </a>
                            </li>
                        </ul>
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
                                <li><a href="/" style="color: inherit;">Home</a></li>
                                <li><a href="/about" style="color: inherit;">About Us</a></li>
                                <li><a href="/terms" style="color: inherit;">Terms & Conditions</a></li>
                                <li><a href="/templates" style="color: inherit;">Templates</a></li>
                                <li><a href="/services" style="color: inherit;">Services</a></li>
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
