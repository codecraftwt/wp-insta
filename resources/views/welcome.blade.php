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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">


    <link href="{{ asset('assets/css/subscription.css') }}" rel="stylesheet">



    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" rel="stylesheet" />

    <link href="assets/landing-css/landingstyle.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

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


    <!-- Navbar -->
    {{-- <nav class="navbar navbar-expand-lg navbar-light"
        style="background: linear-gradient(135deg, #d9ffdc 0%, #e0f7fa 100%);">
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
                <div class="d-flex w-100 justify-content-around align-items-center">
                    <!-- Centered Links with Equal Spacing -->
                    <a class="btn nav-link" href="/">Home</a>
                    <a class="btn nav-link" href="/about">About US</a>
                    <a class="btn nav-link" href="/terms">Terms & Conditions</a>
                    <a class="btn nav-link" href="/templates">Templates</a>
                    <a class="btn nav-link" href="/services">Services</a>
                    <a class="btn nav-link" href="/contact">Contact </a>

                    <!-- Right-Aligned Buttons -->
                    <a class="btn btn-primary login" href="/login">Login</a>
                    <a class="btn register" href="/register-page">
                        Get Started <i class="fa fa-star ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav> --}}

    <nav class="navbar navbar-expand-lg navbar-light"
        style="background: linear-gradient(135deg, #d9ffdc 0%, #e0f7fa 100%);">
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
    <section class="hero" style="background: linear-gradient(135deg, #d9ffdc 0%, #e0f7fa 100%);">
        <div class="container">
            <h1 class="heading-hero">We make it easy <br> to use WordPress</h1>
            <div class="subtitile-head">
                <p>Easiest Cloud Platform for WordPress Professionals and Companies</p>
            </div>
            <div>
                <a href="#" class="btn"
                    style="background-color: #005e54; border-color: #4c8e87; border-radius: 8px; padding: 10px 20px; color: white; text-align: center; transition: background-color 0.3s, box-shadow 0.3s;"
                    onmouseover="this.style.backgroundColor='#004d47'; this.style.boxShadow='0 0 0 2px #004d47';"
                    onmouseout="this.style.backgroundColor='#005e54'; this.style.boxShadow='none';">
                    Start 30 Days Trial
                </a>
                <a href="#" class="btn view_price">View Pricing <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </section>


    <!-- project-section -->
    <section class="project section_1">
        <div class="container text-center mt-5 project-section">
            <div class="project-text">
                Our Great Achievement Proved Us!
            </div>
            <div class="project-heading">
                We Completed 500+ Projects <br>With Clients Satisfaction
            </div>

            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel"
                data-bs-interval="3000">
                <div class="carousel-inner">
                    <!-- First Slide -->
                    <div class="carousel-item active">
                        <div class="carousel-images d-flex justify-content-center gap-3">
                            <img class="d-block small-image" src="{{ asset('assets/img/img_1.png') }}"
                                alt="First slide">
                            <img class="d-block medium-image" src="{{ asset('assets/img/img_2.png') }}"
                                alt="Second slide">
                            <img class="d-block large-image" src="{{ asset('assets/img/img_3.png') }}"
                                alt="Third slide">
                            <img class="d-block medium-image" src="{{ asset('assets/img/img_4.png') }}"
                                alt="Fourth slide">
                        </div>
                    </div>
                    <!-- Second Slide -->
                    <div class="carousel-item">
                        <div class="carousel-images d-flex justify-content-center gap-3">
                            <img class="d-block small-image" src="{{ asset('assets/img/img_1.png') }}"
                                alt="First slide">
                            <img class="d-block medium-image" src="{{ asset('assets/img/img_2.png') }}"
                                alt="Second slide">
                            <img class="d-block large-image" src="{{ asset('assets/img/img_3.png') }}"
                                alt="Third slide">
                            <img class="d-block medium-image" src="{{ asset('assets/img/img_4.png') }}"
                                alt="Fourth slide">
                        </div>
                    </div>
                </div>

                <!-- Carousel controls (Next and Previous buttons) -->
                <button class="carousel-control-prev btnc" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bi bi-arrow-left btnc" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next btnc" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon bi bi-arrow-right btnc" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>

                <!-- Pagination (dots) at the bottom) -->
                <div
                    class="swiper-pagination position-absolute bottom-0 w-100 swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-horizontal aos-init aos-animate">
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
    <section class="project section_1">
        <div class="container">
            <div class="container text-center">
                <p class="Template-text"> Creative & User Friendly Design</p>
                <h2 class="Setup-title mb-5  ">
                    See Our Modern Template
                </h2>
            </div>
            <div class="container">
                <div class="row" id="temp-container">
                    {{-- TEMP-1 --}}
                    <div class="col-lg-4 col-sm-6 aos-init aos-animate temp-item" data-aos="fade-up">
                        <div class="card text-center mb-4">
                            <div class="card-image">
                                <div class="temp-container">
                                    <img class="temp-img" src="assets/img/temp_img_1.png" alt="Demo Image">
                                </div>
                            </div>
                            <h4 class="card-title">
                                Corporate
                            </h4>
                        </div>
                    </div>
                    {{-- TEMP-2 --}}
                    <div class="col-lg-4 col-sm-6 aos-init aos-animate temp-item" data-aos="fade-up">
                        <div class="card text-center mb-4">
                            <div class="card-image">
                                <div class="temp-container">
                                    <img class="temp-img" src="assets/img/temp_img_2.png" alt="Demo Image">
                                </div>
                            </div>
                            <h4 class="card-title">
                                Business
                            </h4>
                        </div>
                    </div>
                    {{-- TEMP-3 --}}
                    <div class="col-lg-4 col-sm-6 aos-init aos-animate temp-item" data-aos="fade-up">
                        <div class="card text-center mb-4">
                            <div class="card-image">
                                <div class="temp-container">
                                    <img class="temp-img" src="assets/img/temp_img_3.png" alt="Demo Image">
                                </div>
                            </div>
                            <h4 class="card-title">
                                Agency
                            </h4>
                        </div>
                    </div>
                    {{-- TEMP-4 --}}


                </div>
    </section>

    <!-- pricing  Section -->
    <section class="project section_1">
        <div class="container">
            <div class="container text-center mt-5" pricing>
                <h1 class="">
                    Choose Our Pricing Plan</h1>

                <p class="Template-text">Curabitur non nulla sit amet nisl tempus lectus Nulla porttitor accumsan
                    tincidunt.
                </p>
            </div>
            <div class="d-flex justify-content-center mb-4">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="monthly-tab" data-value="month" role="tab"
                            aria-controls="monthly" aria-selected="true" onclick="changeTab(this)">Monthly</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="yearly-tab" data-value="year" role="tab"
                            aria-controls="yearly" aria-selected="false" onclick="changeTab(this)">Yearly</button>
                    </li>
                </ul>
            </div>

        </div>


        <section class="pricing-section">
            <div class="container">
                <div class="row" id="pricing-plans">
                    <!-- Pricing cards will be injected here -->
                </div>
            </div>
        </section>
    </section>

    <!-- pricing  foooter block -->

    <section class="container py-2">
        <div class="row justify-content-center content-box">
            <div class="col-lg-8 col-md-10 col-12 text-center footer_block">
                <h1>Setup Your Website in Few Clicks</h1>
                <p>InstaWP is an all-in-one developer's toolbox that lets people get started on WordPress in an instant,
                    build the site, and migrate the site to a hosting provider.</p>
            </div>
            <div class="col-12 text-center">
                <button class="register">Get Started</button>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    {{-- <section class="project section_1">
        <div class="footer">
            <div class="container">
                <div class="row">
                    <!-- Logo and Company Info -->
                    <div class="col-md-4 p-5">
                        <div class="logo">
                            <a class="navbar-brand" href="{{ url('/') }}">
                                <img src="{{ asset('assets/img/walstarLogo.png') }}" alt="Walstar Logo"
                                    class="img-fluid fimg" >
                            </a>
                        </div>
                        <p>We are an award-winning multinational Company. We believe in quality and standards worldwide.
                        </p>
                    </div>

                    <!-- Useful Links -->
                    <div class="col-md-4 text-center" >
                        <h5>Useful Links</h5>
                        <ul class="list-unstyled">
                            <li><a href="/">Home</a></li>
                            <li><a href="/about">About Us</a></li>
                            <li><a href="/terms">Terms & Conditions</a></li>
                            <li><a href="/templates">Templates</a></li>
                            <li><a href="/services">Services</a></li>
                        </ul>
                    </div>

                    <!-- Contact Information -->
                    <div class="col-md-4">
                        <h5>Contact Us</h5>
                        <div class="contact-info">
                            <p><i class="fas fa-map-marker-alt"></i> 2103/47 E, Rukmini Nagar, Front Of Datta
                                Mandir, Kolhapur, Maharashtra 416005</p>
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
                        <p class="copyright">Copyright © 2024 All Rights Reserved Terms of Use and Privacy Policy
                        </p>
                    </div>
                </div>
            </div>

            <!-- Back to Top Button -->
            <a href="#" class="back-to-top"><i class="fas fa-chevron-up"></i></a>
        </div>
    </section> --}}

    <section class="project section_1">
        <div class="footer"
            style="background-color: {{ isset($siteSetting) ? $siteSetting->footer_background : '#333' }}; color: {{ isset($siteSetting) ? $siteSetting->footer_text : '#fff' }};">

            <div class="container">
                <div class="row">
                    <!-- Logo and Company Info -->
                    <div class="col-md-4 p-5">
                        <div class="logo">
                            <a class="navbar-brand" href="{{ url('/') }}">
                                <img src="{{ asset(isset($siteSetting) && $siteSetting->logo ? $siteSetting->logo : 'assets/img/walstarLogo.png') }}"
                                    alt="Walstar Logo" class="img-fluid fimg">
                            </a>
                        </div>
                        <p style="color: {{ isset($siteSetting) ? $siteSetting->footer_text : '#fff' }}">We are an
                            award-winning multinational Company. We believe in quality and standards worldwide.
                        </p>
                    </div>

                    <!-- Useful Links -->
                    <div class="col-md-3">
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
                    <div class="col-md-5">
                        <h5>Contact Us</h5>
                        <div class="contact-info">
                            <p><i class="fas fa-map-marker-alt"></i>
                                2103/47 E, Rukmini Nagar, Front Of Datta Mandir, Kolhapur, Maharashtra 416005
                            </p>
                            <p><i class="fas fa-phone-alt"></i> +91 777 503 2331</p>
                            <p><i class="fas fa-envelope"></i>info@walstartechnologies.com</p>
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

            <!-- Back to Top Button -->
            <a href="#" class="back-to-top">
                <i class="bi bi-chevron-up" "></i> <!-- Adjust the size using inline CSS or bootstrap size classes -->
            </a>
            
            

        </div>
    </section>




    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script crossorigin="anonymous" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+e7iDZIiD6jz7f6eGm5t5p5hb5g1y"
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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
        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            position: relative;
            transition: transform 1s ease-in-out;
        }

        .card:hover {
            transform: translateY(-10px);
        }

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
