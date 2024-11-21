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




    <nav class="navbar navbar-expand-lg navbar-light navbar-section" id='nav-section'>
        <div class="container">
            <!-- Logo Section -->
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('assets/img/walstarLogo.png') }}" alt="Walstar Logo" width="150" height="50" />
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
                        <a class="nav-link" href="/terms">Terms & Conditions</a>
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
                    @if (Auth::check())
                        <!-- If authenticated, show Logout button as a form -->
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-primary login">Logout</button>
                        </form>
                        <li class="nav-item">
                            <a class="btn register" href="/home">Dashboard</a>
                        </li>
                    @else
                        <!-- If not authenticated, show Login button -->
                        <li class="nav-item">
                            <a class="btn btn-primary login" href="/login">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn register" href="/register-page">
                                Get Started <i class="fa fa-star ms-2"></i>
                            </a>
                        </li>
                    @endif
                </ul>
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
                <a href="#" class="btn trial-btn">
                    Start 30 Days Trial
                </a>
                <a href="#" class="btn view_price">View Pricing <i class="fas fa-arrow-right"></i></a>
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
                        <div>
                            <img class="card-img-top small-image" src="{{ asset('assets/img/img_1.png') }}"
                                alt="First slide">
                        </div>
                    </div>
                    <div class="card">
                        <div class="img-container">
                            <img class="card-img-top small-image" src="{{ asset('assets/img/img_2.png') }}"
                                alt="Second slide">
                        </div>
                    </div>
                    <div class="card">
                        <div>
                            <img class="card-img-top small-image" src="{{ asset('assets/img/img_3.png') }}"
                                alt="Third slide">
                        </div>
                    </div>
                    <div class="card">
                        <div>
                            <img class="card-img-top small-image" src="{{ asset('assets/img/img_4.png') }}"
                                alt="Fourth slide">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




    <!--Setup  Website -->
    <section class="Setup section_1" style="padding-top: 100px;">
        <div class="container setup-section" id="setup-section">
            <h2 class="Setup-title mb-5  text-center">
                How To Setup Website
            </h2>
            <div class="row mb-5">
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card setup-card ">
                        <div class="card-body text-center p-4">
                            <img alt="Icon representing purchase template" class="icon mb-3" height="80"
                                src="{{ asset('assets/img/setup_1.png') }}" width="80" />
                            <h4 class="card-title">Purchase Template</h4>
                            <p class="card-text">
                                We provide graphics and visual identity design services.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card setup-card">
                        <div class="card-body text-center p-4">
                            <img alt="Icon representing add services" class="icon mb-3" height="80"
                                src="{{ asset('assets/img/setup_2.png') }}" width="80" />
                            <h5 class="card-title">Add Services</h5>
                            <p class="card-text">
                                We provide graphics and visual identity design services.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card setup-card">
                        <div class="card-body text-center p-4">
                            <img alt="Icon representing setup website" class="icon mb-3" height="80"
                                src="{{ asset('assets/img/setup_3.png') }}" width="80" />
                            <h5 class="card-title">Setup Website</h5>
                            <p class="card-text">
                                We provide graphics and visual identity design services.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card setup-card">
                        <div class="card-body text-center p-4">
                            <img alt="Icon representing launch website" class="icon mb-3" height="80"
                                src="{{ asset('assets/img/setup_4.png') }}" width="80" />
                            <h5 class="card-title">Launch Website</h5>
                            <p class="card-text">
                                We provide graphics and visual identity design services.
                            </p>
                        </div>
                    </div>
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
                                <a class="btn monthly-pricingbtn" href="/register-page">
                                    Monthly
                                </a>
                                <a class="btn yearly-pricingbtn" href="/register-page">
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
        <div class="row align-items-center footer_blade p-4">
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
            <div class="col-lg-2 col-12 text-lg-end text-center">
                <button class="custom-button w-100 w-lg-auto">Get Started</button>
            </div>
        </div>
    </section>



    {{-- //FOOTER LAST --}}
    <section class="project section_5">
        <div class="footer"
            style="background-color: {{ isset($siteSetting) ? $siteSetting->footer_background : '#333' }}; color: {{ isset($siteSetting) ? $siteSetting->footer_text : '#fff' }};">
            <div class="container">
                <div class="row">
                    <!-- Logo and Company Info -->
                    <div class="col-md-4 mb-4 mb-md-0">
                        <div class="logo">
                            <a class="footer-brand" href="{{ url('/') }}">
                                <img src="{{ asset(isset($siteSetting) && $siteSetting->logo ? $siteSetting->logo : 'assets/img/walstarLogo.png') }}"
                                    alt="Walstar Logo" class="img-fluid fimg">
                            </a>
                        </div>
                        <p style="color: {{ isset($siteSetting) ? $siteSetting->footer_text : '#fff' }}">
                            We are an award-winning multinational Company. We believe in quality and standards
                            worldwide.
                        </p>
                    </div>

                    <!-- Useful Links -->
                    <div class="col-md-4 mb-4 mb-md-0">
                        <h5>Useful Links</h5>
                        <ul class="list-unstyled">
                            <li><a href="/"
                                    style="color: {{ isset($siteSetting) ? $siteSetting->footer_text : '#fff' }}">Home</a>
                            </li>
                            <li><a href="/about"
                                    style="color: {{ isset($siteSetting) ? $siteSetting->footer_text : '#fff' }}">About
                                    Us</a></li>
                            <li><a href="/terms"
                                    style="color: {{ isset($siteSetting) ? $siteSetting->footer_text : '#fff' }}">Terms
                                    & Conditions</a></li>
                            <li><a href="/templates"
                                    style="color: {{ isset($siteSetting) ? $siteSetting->footer_text : '#fff' }}">Templates</a>
                            </li>
                            <li><a href="/services"
                                    style="color: {{ isset($siteSetting) ? $siteSetting->footer_text : '#fff' }}">Services</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Contact Information -->
                    <div class="col-md-4 mb-4 mb-md-0">
                        <h5>Contact Us</h5>
                        <div class="contact-info">
                            <p><i class="fas fa-map-marker-alt"></i> 2103/47 E, Rukmini Nagar, Front Of Datta Mandir,
                                Kolhapur, Maharashtra 416005</p>
                            <p><i class="fas fa-phone-alt"></i> +91 777 503 2331</p>
                            <p><i class="fas fa-envelope"></i> info@walstartechnologies.com</p>
                        </div>
                    </div>
                </div>

                <!-- Social Icons and Footer Text -->
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="social-icons">
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
        function changeTab(tabElement) {
            const selectedPlanType = tabElement.getAttribute('data-value');

            $('.nav-link').removeClass('active');
            $(tabElement).addClass('active');

            $.ajax({
                url: '/getSubscriptiondetail',
                method: 'GET',
                data: {
                    type: selectedPlanType
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token
                },
                success: function(data) {
                    let plansHtml = '';
                    data.forEach(function(plan) {
                        if (plan.plan_type === selectedPlanType) {
                            plansHtml += `
                                <div class="col-md-4 mb-4">
                                    <div class="price-card">
                                        <h2 class="plan-title">${plan.plain_title}</h2>
                                        <p class="plan-description">${plan.plan_description}</p>
                                        <p class="price"><span>${plan.plan_price}</span>/ ${plan.plan_type.charAt(0).toUpperCase() + plan.plan_type.slice(1)}</p>
                                        <ul class="pricing-features">
                                            ${plan.plan_details}
                                        </ul>
                                       <a href="/register-page" class="btn btn-primary">Register Now</a>
                                    </div>
                                </div>
                            `;
                        }
                    });
                    $('#pricing-plans').html(plansHtml);
                },
                error: function() {
                    alert('Failed to fetch subscription details.');
                }
            });
        }

        $(document).ready(function() {
            changeTab(document.getElementById('monthly-tab'));
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
