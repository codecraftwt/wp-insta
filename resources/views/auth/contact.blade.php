@extends('layouts.app')

@section('content')
    <!-- Main Container -->
    <div class="hero-background-pattern">
        <div class="hero-section bgcolors">
            <div class="hero-title">GET IN TOUCH</div>
            <div class="hero-line"></div>
            <div class="hero-subtitle">We Would Love to Hear from You</div>
        </div>
    </div>

    <!-- Contact Section -->
    <section class="py-5 bgcolors">
        <div class="container">
            <div class="row gy-4 gy-md-5 align-items-center">

                <!-- Contact Form Section -->
                <div class="col-12 col-lg-6">
                    <div class="border border-success rounded shadow-lg">
                        <form action="#!">
                            <div class="row gy-4 gy-xl-5 p-4 p-xl-5">
                                <div class="col-12">
                                    <label for="fullname" class="form-label text-primary">Full Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="fullname" name="fullname" required>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="email" class="form-label text-primary">Email <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-success text-white">
                                            <i class="bi bi-envelope"></i>
                                        </span>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="phone" class="form-label text-primary">Phone Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-success text-white">
                                            <i class="bi bi-telephone"></i>
                                        </span>
                                        <input type="tel" class="form-control" id="phone" name="phone">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label text-primary">Message <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button class="btn btn-primary btn-lg" type="submit">Send Message</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Contact Details Section -->
                <div class="col-12 col-lg-6">
                    <div class="row justify-content-xl-center">
                        <!-- First Row (2 items) -->
                        <div class="col-12 col-md-6 mb-4 mb-md-5">
                            <div class="mb-3 text-primary">
                                <i class="bi bi-geo-alt contact-icon"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark">Our Office Location</h5>
                                <p class="text-muted">1234 Street Name, City, Country</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-4 mb-md-5">
                            <div class="mb-3 text-primary">
                                <i class="bi bi-telephone contact-icon"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark">Call Us</h5>
                                <p class="text-muted">+1 (800) 123-4567</p>
                            </div>
                        </div>

                        <!-- Second Row (2 items) -->
                        <div class="col-12 col-md-6 mb-4 mb-md-5">
                            <div class="mb-3 text-primary">
                                <i class="bi bi-envelope contact-icon"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark">Email Us</h5>
                                <p class="text-muted">contact@company.com</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-4 mb-md-5">
                            <div class="mb-3 text-primary">
                                <i class="bi bi-chat-dots contact-icon"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark">Live Chat</h5>
                                <p class="text-muted">chat@company.com</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <style>
        .bgcolors {
            background: linear-gradient(135deg, #f1fdf6 0%, #f7f7f7 100%);
        }

        .hero-section {
            text-align: center;
            padding: 100px 0;
        }

        .hero-title {
            font-family: 'Poppins', sans-serif;
            font-size: 48px;
            font-weight: bold;
            color: #ff4d4d;
        }

        .hero-subtitle {
            font-family: 'Open Sans', sans-serif;
            font-size: 18px;
            margin-top: 10px;
            font-weight: 600;
            color: #333;
        }

        .hero-line {
            width: 50px;
            height: 2px;
            background-color: #ff4d4d;
            margin: 20px auto;
        }

        .hero-background-pattern {
            background-image: url('https://placehold.co/1920x1080/1a1a1a/1a1a1a.png?text=+');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        .contact-icon {
            font-size: 40px;
            color: #ff4d4d;
        }

        .border-success {
            border-width: 2px !important;
        }

        .form-label {
            font-weight: 600;
            color: #007bff;
        }

        .form-control {
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .input-group-text {
            background-color: #4CAF50;
            color: white;
        }

      

        .btn-primary:hover {
            background-color: #45a049;
            border-color: #5dcc62;
        }

        .fw-bold {
            font-weight: 700;
        }
    </style>
@endsection
