@extends('layouts.app')

@section('content')
    <link href="{{ asset('assets/css/subscription.css') }}" rel="stylesheet">
    <link href="assets/landing-css/landingstyle.css" rel="stylesheet">
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
            <h3 class="heading-about">A Team That's Making Magic Happen</h3>
            <div class="subtitile-head">
                <p>If you want a team that works with efficiency and expertise our specialists are the right people for
                    the job. Highly trained and passionate, they will work tirelessly on the task at hand until the job
                    gets done right.</p>
            </div>

        </div>
    </section>

    <section class="Team">
        <div class="container text-center pt-2">
            <h3 class="heading-about pt-4">Meet Our Team</h3>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="team-member">
                        <img alt="Portrait of Vikas Singhal" height="150"
                            src="https://storage.googleapis.com/a1aa/image/tXsgiUQNd6YTMpsxeFIKeoIGeqFsUZi5xIVk03crEVOe0M6OB.jpg"
                            width="150" />
                        <h5>
                            Vikas Singhal
                        </h5>
                        <p>
                            Founder of InstaWP
                        </p>
                        <div class="social-icons">
                            <a href="#">
                                <i class="fab fa-facebook-f">
                                </i>
                            </a>

                            <a href="#">
                                <i class="fab fa-linkedin-in">
                                </i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team-member">
                        <img alt="Portrait of Sunakshi A" height="150"
                            src="https://storage.googleapis.com/a1aa/image/vEQ3V72SSV5nOtja5IhOVjLaaETofeQr2tM9d3yWN5AONjuTA.jpg"
                            width="150" />
                        <h5>
                            Sunakshi A
                        </h5>
                        <p>
                            HR Head
                        </p>
                        <div class="social-icons">
                            <a href="#">
                                <i class="fab fa-facebook-f">
                                </i>
                            </a>

                            <a href="#">
                                <i class="fab fa-linkedin-in">
                                </i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team-member">
                        <img alt="Portrait of Abhishek Garg" height="150"
                            src="https://storage.googleapis.com/a1aa/image/FfMeM62kcMtfuoruWieCRaBidWCvNjtNcEgKZEXPFik00M6OB.jpg"
                            width="150" />
                        <h5>
                            Abhishek Garg
                        </h5>
                        <p>
                            Marketing Head
                        </p>
                        <div class="social-icons">
                            <a href="#">
                                <i class="fab fa-facebook-f">
                                </i>
                            </a>

                            <a href="#">
                                <i class="fab fa-linkedin-in">
                                </i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>


    <section class="container">
        <div class="main-container">
            <div class="content-box">
                <h1>Setup Your Website in Few Clicks</h1>
                <p>InstaWP is an all-one-in developers toolbox which lets people get started on WordPress in an instant,
                    build the site and migrate the site to a hosting provider.</p>
                <button class="btn">Get Started</button>

            </div>
        </div>
    </section>
@endsection
