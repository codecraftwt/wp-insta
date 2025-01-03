@extends('layouts.app')

@section('content')
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



    <!-- Hero Section -->
    <section class="hero" style="background: linear-gradient(135deg, #d9ffdc 0%, #e0f7fa 100%);">
        <div class="container">
            <h3 class="heading-about">About Us</h3>


        </div>
    </section>

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


@endsection
