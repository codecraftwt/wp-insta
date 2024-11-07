<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('assets/img/WT-fav-logo.png') }}">
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

        .footer {
            background-color: #e9ffdd;
            padding: 50px 0;
            width: 100%;
        }

        .footer .logo {
            font-size: 24px;
            font-weight: bold;
            color: #000;
        }

        .footer .logo span {
            color: #ff5e5e;
        }

        .footer p {
            color: #6c757d;
        }

        .footer h5 {
            font-size: 18px;
            font-weight: bold;
            color: #000;
        }

        .footer a {
            color: #ff5e5e;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .footer .contact-info i {
            font-size: 20px;
            color: #fff;
            background-color: #ff5e5e;
            padding: 10px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .footer .social-icons a {
            color: #ff5e5e;
            font-size: 20px;
            margin: 0 10px;
        }

        .footer .newsletter input[type="email"] {
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 10px;
            width: 80%;
        }

        .footer .newsletter button {
            background-color: #ff5e5e;
            border: none;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            margin-left: -5px;
        }

        .footer .back-to-top {
            background-color: #ff5e5e;
            color: #fff;
            font-size: 20px;
            padding: 10px;
            border-radius: 50%;
            position: fixed;
            bottom: 20px;
            right: 20px;
        }

        .footer .back-to-top:hover {
            color: #fff;
            text-decoration: none;
        }

        .footer .copyright {
            text-align: center;
            color: #6c757d;
            margin-top: 20px;
        }

        .footer .social-icons {
            margin-top: 20px;
        }

        .footer .contact-info {
            margin-bottom: 20px;
        }

        .footer .social-icons a {
            color: #ff5e5e;
            font-size: 24px;
            margin: 0 10px;
        }

        .footer .social-icons a:hover {
            color: #333;
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
                        <div class="d-flex w-100 justify-content-around align-items-center">
                            <!-- Centered Links with Equal Spacing -->
                            <a class="btn nav-link" href="/">Home</a>
                            <a class="btn nav-link" href="/about">About</a>
                            <a class="btn nav-link" href="/terms">Terms of Service</a>
                            <a class="btn nav-link" href="/templates">Templates</a>
                            <a class="btn nav-link" href="/services">Services</a>
                            <a class="btn nav-link" href="/contact">Contact</a>

                            <!-- Right-Aligned Buttons -->
                            <a class="btn btn-primary login" href="/login">Login</a>
                            <a class="btn register" href="/register-page">
                                Get Started <i class="fa fa-star ms-2"></i>
                            </a>
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
        <section class="project section_1">
            <div class="footer">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 p-5">
                            <div class="logo">
                                <span>B</span> Businesso
                            </div>
                            <p>We are an award-winning multinational Company. We Believe in quality and
                                standards
                                worldwide.</p>
                        </div>
                        <div class="col-md-3">
                            <h5>Useful Links</h5>
                            <ul class="list-unstyled">
                                <li><a href="#">Our Blogs</a></li>
                                <li><a href="#">Contact Us</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Terms & Conditions</a></li>
                                <li><a href="#">About Us</a></li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <h5>Contact Us</h5>
                            <div class="contact-info">
                                <p><i class="fas fa-map-marker-alt"></i> House - 44, Road - 03, Sector - 11,
                                    Uttara,
                                    Dhaka | Dhanmondi, Dhaka | Mohammadpur, Dhaka</p>
                                <p><i class="fas fa-phone-alt"></i> 237237237 , 72372332</p>
                                <p><i class="fas fa-envelope"></i> contact@example.com , support@example.com ,
                                    query@example.com</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <h5>Newsletter</h5>
                            <p>Get the latest updates first</p>
                            <div class="newsletter">
                                <input type="email" placeholder="Enter Your Email">
                                <button><i class="fas fa-paper-plane"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            <div class="social-icons">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                                <a href="#"><i class="fab fa-dribbble"></i></a>
                            </div>
                            <p class="copyright">Copyright © 2023. All rights reserved by Businesso.</p>
                        </div>
                    </div>
                </div>
                <a href="#" class="back-to-top"><i class="fas fa-chevron-up"></i></a>
            </div>
        </section>
    @endif
    </div>
</body>

</html>
