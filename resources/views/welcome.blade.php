<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>InstaWP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f8fb;
        }

        /* Navbar */
        .navbar-brand img {
            height: 40px;
        }

        .nav-link {
            font-weight: 500;
        }

        .btn-primary,
        .btn-outline-primary {
            padding: 10px 20px;
            font-size: 16px;
        }

        /* Hero Section */
        .hero-section {
            text-align: center;
            padding: 100px 20px;
            background: linear-gradient(135deg, #004d40 0%, #00897b 100%);
            color: #fff;
        }

        .hero-section h1 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .hero-section p {
            font-size: 18px;
            color: #cfd8dc;
            margin-bottom: 30px;
        }

        /* Carousel Image Styling */
        .carousel-item img {
            max-height: 500px;
            width: auto;
            object-fit: contain;
            margin: auto;
            background-color: #f4f8fb;
        }

        /* Card Section */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }

        .card img {
            height: 50px;
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 22px;
            font-weight: 500;
            color: #333;
        }

        .card-text {
            font-size: 16px;
            color: #6c757d;
        }

        .card .btn-link {
            font-weight: 500;
            color: #004d40;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="assets/img/logo.png" alt="InstaWP Logo" class="img-fluid" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="btn btn-primary me-2" href="/login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-primary" href="/register-page">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
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


    <!-- Hero Section -->
    <section class="hero-section">

        <div class="container">
            <h1>We Make WordPress Easy</h1>
            <p>The Easiest Cloud Platform for WordPress Professionals and Companies</p>
            <a class="btn btn-primary" href="/register-page">Start Your Free Trial</a>
        </div>
    </section>


    <section class="container my-5">
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3"
                    aria-label="Slide 4"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4"
                    aria-label="Slide 5"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="5"
                    aria-label="Slide 6"></button>
            </div>
            <div class="carousel-inner">
                <!-- Slide 1 -->
                <div class="carousel-item active">
                    <img src="assets/img/img-1.png" class="d-block w-100" alt="Slide 1">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Running sites </h5>
                        <p>Build Running sites for client projects or even a quick test site. Completely free! </p>
                    </div>
                </div>
                <!-- Slide 2 -->
                <div class="carousel-item">
                    <img src="assets/img/img-2.png" class="d-block w-100" alt="Slide 2">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Plugins Select</h5>
                        <p>Auto select plugins to install, data center, PHP version, WP Version and Create site</p>
                    </div>
                </div>
                <!-- Slide 3 -->
                <div class="carousel-item">
                    <img src="assets/img/img-3.png" class="d-block w-100" alt="Slide 3">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Themes Select</h5>
                        <p>Auto select <b> One</b> Themes to install, data center, PHP version, WP Version and Create
                            site</p>
                    </div>
                </div>
                <!-- Slide 4 -->
                <div class="carousel-item">
                    <img src="assets/img/img-4.png" class="d-block w-100" alt="Slide 4">
                    <div class="carousel-caption d-none d-md-block">
                        <h5 class="text-black"F>Site Created</h5>
                        <p class="text-black">Site is created within seconds and our “ONE CLICK” takes you to wp-admin
                            automatically.</p>
                    </div>
                </div>
                <!-- Slide 5 -->
                <div class="carousel-item">
                    <img src="assets/img/img-5.png" class="d-block w-100" alt="Slide 5">
                    <div class="carousel-caption d-none d-md-block">
                        <h5 class="text-black">WP Site is Created</h5>
                        <p class="text-black">One Click TO Dashboard</p>
                    </div>
                </div>
                <!-- Slide 6 -->
                <div class="carousel-item">
                    <img src="assets/img/img-6.png" class="d-block w-100" alt="Slide 6">
                    <div class="carousel-caption d-none d-md-block">
                        <h5 class="text-black">WordPress website Ready</h5>
                        <p class="text-black">Your WordPress website is ready for you to bring Ideas to life!</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>


    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
