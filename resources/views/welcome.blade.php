<!DOCTYPE html>
<html lang="en">

<head>

    <title>{{ $siteSetting->site_title ?? 'InstaWP' }}</title>

    <meta charset="utf-8" />
    <link rel="icon" href="https://www.walstartechnologies.com/wp-content/uploads/2024/09/Favicons3-150x150.png"
        sizes="32x32" />
    <link rel="icon" href="https://www.walstartechnologies.com/wp-content/uploads/2024/09/Favicons3-300x300.png"
        sizes="192x192" />
    <link rel="apple-touch-icon"
        href="https://www.walstartechnologies.com/wp-content/uploads/2024/09/Favicons3-300x300.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">


    <link href="{{ asset('assets/css/subscription.css') }}" rel="stylesheet">




    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" rel="stylesheet" />

    <link href="assets/landing-css/landingstyle.css" rel="stylesheet">

    {{-- FONT FAMILY --}}

    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400&display=swap" rel="stylesheet">


    <!-- Load jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>



</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col text-center">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

            </div>
        </div>
    </div>
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
                                <a class="nav-link fw-bold {{ request()->is('/') || request()->is('home') ? 'active' : '' }}"
                                    href="/">Home</a>

                            </li>
                            <li class="nav-item mx-1">
                                <a class="nav-link fw-bold {{ request()->is('about') ? 'active' : '' }}"
                                    href="/about">About Us</a>
                            </li>
                            <li class="nav-item mx-1">
                                <a class="nav-link fw-bold {{ request()->is('pricing') ? 'active' : '' }}"
                                    href="/pricing">Pricing</a>
                            </li>
                            <li class="nav-item mx-1">
                                <a class="nav-link fw-bold {{ request()->is('templates') ? 'active' : '' }}"
                                    href="/templates">Templates</a>
                            </li>
                            <li class="nav-item mx-1">
                                <a class="nav-link fw-bold {{ request()->is('services') ? 'active' : '' }}"
                                    href="/services">Services</a>
                            </li>
                            <li class="nav-item mx-1">
                                <a class="nav-link fw-bold {{ request()->is('contact') ? 'active' : '' }}"
                                    href="/contact">Contact</a>
                            </li>

                            <!-- Mobile Buttons -->
                            <li class="nav-item d-lg-none mx-1">
                                @if (Auth::check())
                                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-primary login">Logout</button>
                                    </form>
                                    <a class="btn register" href="/home">Dashboard</a>
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
                        <a class="btn register" href="/home">Dashboard</a>
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



    <!-- Hero Section -->
    <section class="hero hero-section" id="hero-section">
        <div class="container">
            <h1 class="heading-hero">We make it <span id="hero-easy"> easy </span> <br> to use WordPress</h1>
            <div class="subtitile-head">
                <p>Easiest Cloud Platform for WordPress Professionals and Companies</p>
            </div>
            <div>
                <a href="subscription-plans" class="btn trial-btn">
                    Start 30 Days Trial
                </a>
                <a href="subscription-plans" class="btn view_price">View Pricing <i
                        class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </section>


    <!-- project-section -->
    <section class="project section_2">
        <div class="container text-center mt-5 project-section">
            <div class="project-text">
                <h3>Our Great Achievement Proved Us!</h3>
            </div>
            <div class="project-heading">
                We Completed 500+ Projects With Clients Satisfaction
            </div>

            <div class="slide-container mt-5">
                <div class="clients-section">
                    <div class="card">
                        <img class="card-img-top small-image" src="{{ asset('assets/img/img_1.png') }}"
                            alt="First slide">
                    </div>
                    <div class="card">
                        <img class="card-img-top small-image" src="{{ asset('assets/img/img_2.png') }}"
                            alt="Second slide">
                    </div>
                    <div class="card">
                        <img class="card-img-top small-image" src="{{ asset('assets/img/img_3.png') }}"
                            alt="Third slide">
                    </div>
                    <div class="card">
                        <img class="card-img-top small-image" src="{{ asset('assets/img/img_4.png') }}"
                            alt="Fourth slide">
                    </div>
                </div>
            </div>

        </div>
    </section>




    <!--Setup  Website -->
    <section class="Setup section_1" style="padding-top: 100px;">
        <div class="container setup-section" id="setup-section">
            <h2 class="Setup-title mb-5 text-center">
                How To Setup Website
            </h2>
            <div class="row mb-5">
                <div class="col-md-3 col-sm-6 mb-4">
                    <a href="/login" class="text-decoration-none">
                        <div class="card setup-card cursor-pointer">
                            <div class="card-body text-start p-4">
                                <img alt="Icon representing purchase template" class="icon mb-3" height="80"
                                    src="{{ asset('assets/img/setup_1.png') }}" width="80" />
                                <h4 class="card-title">Purchase Plans</h4>
                                <p class="card-text">
                                    We provide graphics and visual identity design services.
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3 col-sm-6 mb-4">
                    <a href="/login" class="text-decoration-none">
                        <div class="card setup-card cursor-pointer">
                            <div class="card-body text-start p-4">
                                <img alt="Icon representing add services" class="icon mb-3" height="80"
                                    src="{{ asset('assets/img/setup_2.png') }}" width="80" />
                                <h5 class="card-title">Select Services</h5>
                                <p class="card-text">
                                    We provide graphics and visual identity design services.
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3 col-sm-6 mb-4">
                    <a href="/login" class="text-decoration-none">
                        <div class="card setup-card cursor-pointer">
                            <div class="card-body text-start p-4">
                                <img alt="Icon representing setup website" class="icon mb-3" height="80"
                                    src="{{ asset('assets/img/setup_3.png') }}" width="80" />
                                <h5 class="card-title">Setup Website</h5>
                                <p class="card-text">
                                    We provide graphics and visual identity design services.
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3 col-sm-6 mb-4">
                    <a href="/login" class="text-decoration-none">
                        <div class="card setup-card cursor-pointer">
                            <div class="card-body text-start p-4">
                                <img alt="Icon representing launch website" class="icon mb-3" height="80"
                                    src="{{ asset('assets/img/setup_4.png') }}" width="80" />
                                <h5 class="card-title">Launch Website</h5>
                                <p class="card-text">
                                    We provide graphics and visual identity design services.
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>


    <!-- Modern Template Section -->
    <section class="project section_3">
        <div class="container">
            <div class="container text-center">
                <p class="Template-text"> Creative & User Friendly Design</p>
                <h2 class="Setup-title mb-5  ">
                    See Our Modern Template
                </h2>
            </div>
            <div class="container">
                <div class="row" id="temp-container">
                    <div class="col-12 aos-init aos-animate temp-item" data-aos="fade-up">
                        <div class="card text-center mb-4">
                            <!-- Entire Container Inside One Card -->
                            <div class="card-body">
                                <div class="row p-">
                                    {{-- TEMP-1 --}}
                                    <div class="col-lg-4 col-sm-6 mb-4">
                                        <div class="temp-container">
                                            <img class="temp-img" src="assets/img/temp_img_1.png" alt="Demo Image">
                                        </div>
                                        <h4 class="card-title">
                                            Corporate
                                        </h4>
                                    </div>
                                    {{-- TEMP-2 --}}
                                    <div class="col-lg-4 col-sm-6 mb-4">
                                        <div class="temp-container">
                                            <img class="temp-img" src="assets/img/temp_img_2.png" alt="Demo Image">
                                        </div>
                                        <h4 class="card-title">
                                            Business
                                        </h4>
                                    </div>
                                    {{-- TEMP-3 --}}
                                    <div class="col-lg-4 col-sm-6 mb-4">
                                        <div class="temp-container">
                                            <img class="temp-img" src="assets/img/temp_img_3.png" alt="Demo Image">
                                        </div>
                                        <h4 class="card-title">
                                            Agency
                                        </h4>
                                    </div>
                                </div>
                                <a href="/templates" class="btn trial-btn">Load More</a>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Pricing Section -->
    <section class="project section_4 mt-5 mb-5">
        <div class="container">
            <div class="row">
                <!-- Pricing Text Section (Left Side) -->
                <div class="col-lg-6 col-md-12 mb-4">
                    <div class="pricing-container">
                        <div class="pricing-text">
                            <h2>
                                Choose Our Pricing Plan
                            </h2>
                            <p>
                                Curabitur non nulla sit amet nisl tempus lectus Nulla porttitor accumsan tincidunt.
                            </p>
                            <div class="btn">
                                <a class="btn monthly-pricingbtn" href="subscription-plans">
                                    Monthly
                                </a>
                                <a class="btn yearly-pricingbtn" href="subscription-plans">
                                    Yearly
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image Section (Right Side) -->
                <div class="col-lg-6 col-md-12">
                    <div class="image-pricing">
                        <img class="pricing-img" src="assets/img/prising_img.png" alt="Demo Image">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Footer Block -->
    <section class="container py-5">
        <div class="row align-items-center footer_blade footer_price">
            <!-- Content Section -->
            <div class="col-lg-10 col-12 mb-3 mb-lg-0">
                <div class="footer_bladecontain">
                    <h2 class="section-heading mb-5 mt-2">Setup Your Website in Few Clicks</h2>
                    <p class="footersection-text">
                        InstaWP is an all-in-one developer's toolbox that lets people get started on WordPress in an
                        instant.
                    </p>
                    <p class="footersection-text">
                        Build the site, and migrate the site to a hosting provider.
                    </p>
                </div>
            </div>
            <!-- Button Section -->
            <div class="col-lg-2 col-12 text-lg-end text-center footer_price">
                <a href="subscription-plans" class="custom-button w-100 w-lg-auto text-decoration-none">
                    Get Started
                </a>
            </div>


        </div>
    </section>



    {{-- //FOOTER LAST --}}
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
                        <p>We are an award-winning multinational Company. We believe in quality and standards worldwide.
                        </p>
                    </div>

                    <!-- Useful Links -->
                    <div class="col-12 col-md-3 mb-4 mt-5 text-center text-md-start">
                        <h5 class="mb-4">Useful Links</h5>
                        <ul class="list-unstyled">
                            <li><a href="/" class="text-decoration-none" style="color: inherit;">Home</a></li>
                            <li><a href="/about" class="text-decoration-none" style="color: inherit;">About Us</a>
                            </li>
                            <li><a href="/terms" class="text-decoration-none" style="color: inherit;">Terms &
                                    Conditions</a></li>
                            <li><a href="/templates" class="text-decoration-none"
                                    style="color: inherit;">Templates</a></li>
                            <li><a href="/services" class="text-decoration-none" style="color: inherit;">Services</a>
                            </li>
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
                        <p class="copyright">Copyright © 2024 All Rights Reserved Terms of Use and Privacy Policy</p>
                    </div>
                </div>
            </div>
        </div>
    </section>





    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const clientsSection = document.querySelector(".clients-section");

            // Clone the images dynamically
            const slides = Array.from(clientsSection.children);
            slides.forEach((slide) => {
                const clone = slide.cloneNode(true); // Clone each slide
                clientsSection.appendChild(clone); // Append clone
            });
        });
    </script>

   


    {{-- Modern Template CSS HOVERSHOW --}}
    <style>
        .card-image {
            position: relative;
            overflow: hidden;
        }

        .temp-container {
            position: relative;
            overflow: hidden;
            height: 500px;
        }

        .temp-img {
            width: 100%;
            height: auto;
            transform: translateY(0);
            transition: transform 10s linear;
        }

        .temp-container:hover .temp-img {
            transform: translateY(-1800px);
        }

        .hover-show {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .card:hover .hover-show {
            display: block;
            opacity: 1;
        }

        .card-title {
            margin-top: 20px;
            /* Added margin */
            font-size: 1.5rem;
            font-weight: bold;
        }

        .pagination .page-link.active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }
    </style>


</body>

</html>
