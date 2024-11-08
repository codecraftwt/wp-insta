@extends('layouts.app')

@section('content')
    <div class="main">

        <div class="hero-background-pattern">
            <div class="hero-section bgcolors">
                <div class="hero-title">GET IN TOUCH</div>
                <div class="hero-line"></div>
                <div class="hero-subtitle">We Would Love to Hear from You</div>
            </div>
        </div>

        <!-- Contact Section -->
        <section class="py-5">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Contact Form Section -->
                    <div class="col-12 col-lg-6 mb-4">
                        <div class="border rounded shadow-lg p-4">
                            <form action="#!">
                                <div class="row gy-4 gy-xl-5">
                                    <div class="col-12">
                                        <label for="fullname" class="form-label text-primary">Full Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="fullname" name="fullname" required>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="email" class="form-label text-primary">Email <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text text-white">
                                                <i class="bi bi-envelope"></i>
                                            </span>
                                            <input type="email" class="form-control" id="email" name="email"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="phone" class="form-label text-primary">Phone Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text text-white">
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
                    <div class="col-12 col-lg-6 mb-4">
                        <div class="row justify-content-center">
                            <!-- First Row (2 items) -->
                            <div class="col-12 col-sm-6 mb-4">
                                <div class="text-center">
                                    <div class="mb-3 text-primary">
                                        <i class="bi bi-geo-alt contact-icon"></i>
                                    </div>
                                    <h5 class="fw-bold text-dark">Our Office Location</h5>
                                    <p class="text-muted">1234 Street Name, City, Country</p>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 mb-4">
                                <div class="text-center">
                                    <div class="mb-3 text-primary">
                                        <i class="bi bi-telephone contact-icon"></i>
                                    </div>
                                    <h5 class="fw-bold text-dark">Call Us</h5>
                                    <p class="text-muted">+1 (800) 123-4567</p>
                                </div>
                            </div>

                            <!-- Second Row (2 items) -->
                            <div class="col-12 col-sm-6 mb-4">
                                <div class="text-center">
                                    <div class="mb-3 text-primary">
                                        <i class="bi bi-envelope contact-icon"></i>
                                    </div>
                                    <h5 class="fw-bold text-dark">Email Us</h5>
                                    <p class="text-muted">contact@company.com</p>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 mb-4">
                                <div class="text-center">
                                    <div class="mb-3 text-primary">
                                        <i class="bi bi-chat-dots contact-icon"></i>
                                    </div>
                                    <h5 class="fw-bold text-dark">Live Chat</h5>
                                    <p class="text-muted">chat@company.com</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
    <style>
        .bgcolors {
            background: linear-gradient(135deg, #d9ffdc 0%, #e0f7fa 100%);

        }

        body {}

        .hero-section {
            text-align: center;
            padding: 1em;
        }

        .hero-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 5rem;
            font-weight: bold;
            word-spacing: 5px;
            letter-spacing: 4px;
        }

        .hero-subtitle {
            font-family: 'Open Sans', sans-serif;
            font-size: 18px;
            margin-top: 10px;
            font-weight: 600;
            color: #333;
            word-spacing: 5px;
            letter-spacing: 2px;    
        }

        .hero-line {
            width: 50px;
            height: 2px;
            background-color: #000000;
            margin: 20px auto;
        }


        .contact-icon {
            font-size: 40px;
            color: #ff4d4d;
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

        /* Adjustments for responsiveness */
        @media (max-width: 575.98px) {
            .hero-title {
                font-size: 36px;
            }

            .hero-subtitle {
                font-size: 16px;
            }

            .contact-icon {
                font-size: 30px;
            }

            .btn-primary {
                font-size: 16px;
                padding: 0.8rem 1rem;
            }
        }
    </style>
@endsection
