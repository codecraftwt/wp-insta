<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/welcome.css" rel="stylesheet">
    <title>Home Page</title>
    <!-- font-awesome cdn -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- font-family cdn -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@100..800&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Sora:wght@100..800&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Sora:wght@100..800&family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <!-- end font-family cdn -->

    <!-- cdn for slick slider -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/jquery.slick/1.4.1/slick.css" />
    <!-- slick slider cdn -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />

    <!-- end cdn for slick slider -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>




</head>

<body>

    <header class="header-color" id="header-sticky">
        <!-- Navbar -->
        <div class="nav-bar-div" id="stickyheader">
            <div class="container">
                <nav class="navbar navbar-expand-lg ">
                    <div class="container-fluid">
                        <!-- Brand Logo -->
                        <a class="navbar-brand text-white" href="/">
                            <img src="assets/img/Instant website logo-17 (1) 1.png" alt="Logo">
                        </a>

                        <!-- Toggle Button -->
                        <button class="navbar-toggler" type="button" aria-controls="navbarNav" aria-expanded="false"
                            aria-label="Toggle navigation" data-target="#navbarNav">
                            <i class="fa-solid fa-bars" style="color: black;"></i>
                        </button>

                        <!-- Collapsible Menu -->
                        <div class="collapse navbar-collapse " id="navbarNav">
                            <ul class="navbar-nav mx-auto navbar-links">
                                <li class="nav-item">
                                    <a class="nav-link active"
                                        {{ request()->is('/') || request()->is('home') ? 'active' : '' }}
                                        href="/">Home</a>
                                </li>
                                <li class="nav-item dropdown">

                                    <a class="nav-link" {{ request()->is('templates') ? 'active' : '' }}
                                        href="templates">Templates</a>
                                </li>

                                </li>
                                <li class="nav-item dropdown">

                                    <a class="nav-link"{{ request()->is('services') ? 'active' : '' }}
                                        href="services">Services</a>
                                </li>
                                <a class="nav-link"{{ request()->is('pricing') ? 'active' : '' }}
                                    href="pricing">Pricing</a>
                            </ul>

                            <!-- Login and Get Started Buttons -->
                            <div class="headder-btn">




                                @if (Auth::check())
                                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-login btn-1 btn-login-1"
                                            id="login">Logout</button>
                                    </form>
                                    <a class="btn btn btn-login btn-1 btn-login-1" href="/dashboard">Dashboard</a>
                                @else
                                    <a class="btn btn-login btn-1 btn-login-1" href="/login" id="login">Login</a>
                                    <a class="btn btn-primary btn-space-two" href="subscription-plans">
                                        Get Started Free →
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </nav>

            </div>
        </div>

    </header>

    <!-- banner section -->
    <section class="banner d-flex align-items-center header-color"
        style="background-image: url('assets/img/bannerbg.png'); padding-top: 30px; background-size: cover; background-repeat: no-repeat;">
        <div class="container d-flex justify-content-center">
            <div class="row d-flex align-items-center ">
                <diV>
                    <h1 class="banner-header"> Your Free Instant <span class="wordpress-text"> WordPress </span> </h1>
                    <h1 class="banner-header"> Development Suite</h1>
                    <p class="text-white header-font pt-3 pb-4" style="margin:0px">Easiest Cloud Platform for
                        WordPress
                        Professionals and Companies</p>
                    <a href="/subscription-plans" id="get__started"
                        class="btn btn-1 text-white rounded btn-space-two align-items-center ">Get Started Now <i
                            class="fa-solid fa-arrow-right ps-2" style="color: #ffffff;"></i></a>
                    <div class="row d-flex">
                        <div class="col-lg-6 col-md-6 col-sm-6 border-color rating-img">
                            <img src="assets/img/customer-rate.png" alt=""
                                style="height: 32.77px; width: 96.87px;">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 rating-star">
                            <img src="assets/img/star.png" alt="star-rating">
                            <p class="rating-txt">Trusted by 30.000+ users!</p>
                        </div>
                    </div>
                </diV>
            </div>
        </div>
    </section>
    <!-- end banner section -->
    <!-- gif section -->
    <section class="header-color gif-back" style="background-image: url('assets/img/Line animation.png');">
        <div class="container gif-div-1">
            <div class="">
                <img src="assets/img/animation-slider.gif" alt="Animated Gif" class="gif-image gifdiv">
            </div>
        </div>
    </section>
    <!-- end gif section -->




    <section class="logo-slider"style="padding-bottom: 0px;">
        <div class="container ps-4 pe-4">
            <div class="row logos-con">
                <!-- Slider Container -->
                <div class="col-12 logos-slider-container">
                    <div class="logos-slider">
                        <div><img data-lazy="assets/img/img-1.png" alt="Logo 1"></div>
                        <div><img data-lazy="assets/img/img-2.png" alt="Logo 2"></div>
                        <div><img data-lazy="assets/img/img-3.png" alt="Logo 3"></div>
                        <div><img data-lazy="assets/img/img-4.png" alt="Logo 4"></div>
                        <div><img data-lazy="assets/img/img-5.png" alt="Logo 5"></div>
                        <div><img data-lazy="assets/img/img-6.png" alt="Logo 6"></div>
                        <div><img data-lazy="assets/img/img-1.png" alt="Logo 1"></div>
                        <div><img data-lazy="assets/img/img-2.png" alt="Logo 2"></div>
                        <div><img data-lazy="assets/img/img-3.png" alt="Logo 3"></div>
                        <div><img data-lazy="assets/img/img-4.png" alt="Logo 4"></div>
                        <div><img data-lazy="assets/img/img-5.png" alt="Logo 5"></div>
                        <div><img data-lazy="assets/img/img-6.png" alt="Logo 6"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- cards section -->
    <section>
        <div class="container">
            <div class="row justify-content-center card-con">
                <div class="col-lg-4 col-md-6 col-sm-12 mt-3 ps-2 pe-2 d-flex justify-content-center">
                    <div class="card-back position-relative"
                        style=" background: 
                linear-gradient(to bottom, #0094DE, #51A9D4), 
                url('assets/img/cardback1.png'); ">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-sm-12">
                                <p class="hundread">100+</p>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <p class="card-tittle">Manage Website</p>
                            </div>
                        </div>
                        <p class="text-white header-font1 pt-3 pb-4 text-align-center" style="margin:0px">Manage 100s
                            of WordPress
                            websites easily.</p>
                        <img src="assets/img/cardimg.png" alt="" class="cardimg position-absolute"
                            style="background: url(assets/img/Ellipse-ambar.png);
    background-size: cover;">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 mt-3 ps-2 pe-2 d-flex justify-content-center">
                    <div class="card-back position-relative"
                        style=" background:  
          url('assets/img/card-active.png');  background-size: cover ">

                        <div class="row align-items-center">
                            <img src="assets/img/WORDPRESS.png" alt=""
                                style="max-width: 80%; object-fit: cover; margin: 0 auto;">
                            <div class="card-tittle pt-5">Most trusted WordPress platform</div>
                            <p class="text-white card-font pt-2 pb-2 text-align-start">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                            </p>
                            <a href="subscription-plans" class="text-white card-font mb-2 mt-2 card-bt1"
                                style="text-decoration: none;font: weight 300;font-size: 13px;"> Create A Free Account
                                &rarr;</a>
                        </div>

                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 mt-3 ps-2 pe-2 d-flex justify-content-center">

                    <div class="card-back position-relative"
                        style=" background: 
          linear-gradient(to bottom, #0094DE, #51A9D4), 
          url('assets/img/card-back3.png');">
                        <div
                            style="background: url('assets/img/card-back3.png');background-size: cover;background-position: center;">

                            <div class="card-tittle p-0">One click import WordPress</div>
                            <p class="text-white card-font pt-2 pb-2 mb-2 text-align-start">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                            </p>
                            <div>
                                <a href="#" class="text-white card-font mt-2 mb-2 card-bt2"
                                    style="text-decoration: none;font: weight 300;
              "> Learn More
                                    &rarr;</a>
                            </div>

                            <div class="card-img-div mt-6 pt-4">
                                <img src="assets/img/card-img3.png" alt=""
                                    class="cardimg cardimg-3 position-absolute ">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end cards sectin  -->

    <!-- WordPress pages section  -->

    <section>
        <div class="container text-align-center">
            <h3 class="sec-tittle">Meet Incredible <br> & <span class="dif-color">Creative WordPress Pages</span></h3>
            <p class=" text-dark header-font pt-3 pb-4" style="margin:0px">Let our AI assist with most time consuming
                to write
                blog. articles, product <br> descriptions and more</p>
            <div class="row wordprss-con">
                <div class="col-12 logos-slider-container">
                    <div class="image-slider">
                        <div class="col-lg-4 col-md-4 col-sm-12 mt-3 ps-2 pe-2 d-flex justify-content-center mb-3"><img
                                src="assets/img/sc1.png" alt="" class="imgstyle"></div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mt-3 ps-2 pe-2 d-flex justify-content-center mb-3">
                            <img src="assets/img/sc2.png" alt="" class="imgstyle">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mt-3 ps-2 pe-2 d-flex justify-content-center mb-3"><img
                                src="assets/img/sc3.png" alt="" class="imgstyle"></div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mt-3 ps-2 pe-2 d-flex justify-content-center mb-3"><img
                                src="assets/img/sc1.png" alt="" class="imgstyle"></div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mt-3 ps-2 pe-2 d-flex justify-content-center mb-3">
                            <img src="assets/img/sc2.png" alt="" class="imgstyle">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mt-3 ps-2 pe-2 d-flex justify-content-center mb-3"><img
                                src="assets/img/sc3.png" alt="" class="imgstyle"></div>


                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- end WordPress pages section  -->
    <!-- services section -->
    <section
        style="background-image: url('assets/img/blue-bg (1).png'); background-position: center;  background-size: cover;"
        class="serv-div">
        <!-- <img src="assets/img/ser-op-img.png" alt="" class="serv-top-img"> -->
        <div class="container">
            <h2 class="serv-tittle">Our Services</h2>
            <p class=" text-white header-font2 pt-3 pb-4" style="margin:0px;">Let our AI assist with most time
                consuming to
                write blog. articles, <br>product descriptions and more</p>
            <div class="row  services-cards">
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mt-3 justify-content-center ">
                    <div class="card">
                        <div class="card-ellips-img position-relative"> <img src="" alt="">
                        </div>
                        <div class="card-abs-img z-1 position-absolute"><img src="assets/img/build-new.png"
                                alt=""> </div>
                        <div class="card-heading pt-5">Build & Deploy</div>
                        <div class="card-text">Build dev sites from scratch or from a template.</div>
                        <a href="/subscription-plans" class="card-link">Learn More &nbsp; &rarr;</a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mt-3 justify-content-center">
                    <div class="card">
                        <div class="card-ellips-img position-relative"> <img src="" alt="">
                        </div>
                        <div class="card-abs-img z-1 position-absolute"><img src="assets/img/host-new.png"
                                alt=""> </div>
                        <div class="card-heading pt-5">Host Websites</div>
                        <div class="card-text">Host Your Websites now & earn up to $500 credits.</div>
                        <a href="/subscription-plans" class="card-link">Learn More &nbsp; &rarr;</a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mt-3 justify-content-center">
                    <div class="card">
                        <div class="card-ellips-img position-relative"> <img src="" alt="">
                        </div>
                        <div class="card-abs-img z-1 position-absolute"><img src="assets/img/manage (1).png"
                                alt=""> </div>
                        <div class="card-heading pt-5">Manage Websites</div>
                        <div class="card-text">Manage 100s of WordPress websites easily.</div>
                        <a href="/subscription-plans" class="card-link">Learn More &nbsp; &rarr;</a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mt-3 justify-content-center">
                    <div class="card">
                        <div class="card-ellips-img position-relative"> <img src="" alt="">
                        </div>
                        <div class="card-abs-img z-1 position-absolute"><img src="assets/img/sell (1).png"
                                alt=""> </div>
                        <div class="card-heading pt-5">Sell Websites</div>
                        <div class="card-text">Sell pre-configured websites and make money!</div>
                        <a href="/subscription-plans" class="card-link">Learn More &nbsp; &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- <img src="assets/img/serv-img.png" class="serv-btm-img" alt=""> -->
    </section>
    <!-- end services section  -->

    <!-- instruct to AI section  -->
    <section>
        <div class="container">
            <h3 class="sec-tittle">Instruct To Our AI <br> Writing <span class="dif-color">Generate WordPress</span>
            </h3>
            <p class=" text-dark header-font2 pt-3 pb-4" style="margin:0px">Let our AI assist with most time consuming
                to
                write blog. articles, product descriptions <br> and more</p>
            <div class=" d-flex flex-column gap-5 Ai-con">
                <div class="step-div step-div-1 d-flex align-items-center">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="stp-no mb-2" style="color: #DADAFF">01</div>
                            <div class="stp-tittle mb-4">Choose the template that best fits</div>
                            <p class="stp-dis mb-4">Please choose the template that best fits your needs from the
                                available options.
                                You can review the different templates and select the one that aligns with your
                                requirements or design
                                preferences.</p>
                            <a href="/subscription-plans"
                                class="btn btn-1 text-white rounded btn-space-two align-items-center  mb-4">Get Started
                                Now <i class="fa-solid fa-arrow-right ps-2" style="color: #ffffff;"></i></a>
                        </div>
                        <div class="col-lg-6 align-items-center">
                            <img src="assets/img/step-img.png" alt="" class="stp-img">
                        </div>
                    </div>
                </div>
                <div class="step-div step-div-2 d-flex align-items-center">
                    <div class="row AI-row">
                        <div class="col-lg-6 ">
                            <img src="assets/img/step-img.png" alt="" class="stp-img">
                        </div>
                        <div class="col-lg-6  align-items-center">
                            <div class="stp-no mb-2" style="color: #FFD7EF">02</div>
                            <div class="stp-tittle mb-4">Choose the template that best fits</div>
                            <p class="stp-dis mb-4">Please choose the template that best fits your needs from the
                                available options.
                                You can review the different templates and select the one that aligns with your
                                requirements or design
                                preferences.</p>
                            <a href="/subscription-plans"
                                class="btn btn-1 text-white rounded btn-space-two align-items-center  mb-4">Get Started
                                Now <i class="fa-solid fa-arrow-right ps-2" style="color: #ffffff;"></i></a>
                        </div>
                    </div>
                </div>
                <div class="step-div step-div-3 d-flex align-items-center">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="stp-no mb-2" style="color: #DAF1F1">03</div>
                            <div class="stp-tittle mb-4">Choose the template that best fits</div>
                            <p class="stp-dis mb-4">Please choose the template that best fits your needs from the
                                available options.
                                You can review the different templates and select the one that aligns with your
                                requirements or design
                                preferences.</p>
                            <a href="/subscription-plans"
                                class="btn btn-1 text-white rounded btn-space-two align-items-center  mb-4">Get Started
                                Now <i class="fa-solid fa-arrow-right ps-2" style="color: #ffffff;"></i></a>
                        </div>
                        <div class="col-lg-6  align-items-center">
                            <img src="assets/img/step-img.png" alt="" class="stp-img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- instruct to AI section  -->

    <!-- best plan section  -->
    <section>
        <div class="container">
            <div class="pricingcontainer">
                <h3 class="sec-tittle">Our Best <span class="dif-color"> Plan For You</span></h3>
                <p class=" text-dark header-font pt-3 pb-4" style="margin:0px">Amet minim mollit non deserunt ullamco.
                </p>

                <!-- progress bar  -->
                <div class="container progress-bar-con ">
                    <div class="custom-progress-wrapper">
                        <!-- Tooltip for showing current value -->
                        <div class="tooltip-container">
                            <span class="tooltip">200 GB</span>
                        </div>

                        <!-- Range slider -->
                        <input type="range" class="custom-range" min="0" max="100" step="25"
                            value="50">

                        <!-- Labels and tick marks -->
                        <div class="label-container">
                            <div class="tick label-0"></div>
                            <span class="label label-0">0 GB</span>

                            <div class="tick label-1"></div>
                            <span class="label label-1">100 GB</span>

                            <div class="tick label-2"></div>
                            <span class="label label-2">200 GB</span>

                            <div class="tick label-3"></div>
                            <span class="label label-3">300 GB</span>

                            <div class="tick label-4"></div>
                            <span class="label label-4">400 GB</span>
                        </div>
                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
                <script>
                    const rangeInput = document.querySelector('.custom-range');
                    const tooltip = document.querySelector('.tooltip');
                    const labels = document.querySelectorAll('.label');

                    rangeInput.addEventListener('input', (e) => {
                        const value = parseInt(e.target.value, 10);
                        const percentage = (value / rangeInput.max) * 100;

                        // Adjust tooltip position and text
                        tooltip.style.left = `calc(${percentage}% - 10px)`;
                        tooltip.textContent = `${value * 4} GB`;

                        // Show or hide labels based on slider value
                        labels.forEach((label, index) => {
                            const labelValue = index * 25; // Values: 0, 25, 50, 75, 100
                            if (value === labelValue) {
                                label.style.display = 'block';
                            } else {
                                label.style.display = 'none';
                            }
                        });
                    });

                    // Trigger initial update
                    rangeInput.dispatchEvent(new Event('input'));
                </script>

                <!-- progres bar code end -->

                <div class="row plan-sec">
                    <div class="col-lg-4 col-md-6 justify-content-center mt-3">
                        <div class="plan-card"
                            style="border: 2.16px solid;
            border-image-source: linear-gradient(86.73deg, #0094DE 3.13%, #035D94 95.46%);
            border-image-slice: 1; 
           ">
                            <p class="plan-text">Personal</p>
                            <p class="plan-rate">$19 <span class="plan-text">/month</span></p>
                            <p class="plan-text">All the basic features to boost your freelance career</p>
                            <div class="divider"></div>
                            <ul class="list-group">
                                <li class="list-group-item border-0 d-flex align-items-center"><img
                                        src="assets/img/check.png" alt="" class="list-icon-img">
                                    <p class="plan-text" style="padding: 0px 35px 0px 15px;">Full Access to
                                        Landingfolio</p> <img src="assets/img/info.png" alt=""
                                        class="list-icon-img">
                                </li>
                                <li class="list-group-item border-0 d-flex align-items-center"><img
                                        src="assets/img/check.png" alt="" class="list-icon-img">
                                    <p class="plan-text" style="padding: 0px 35px 0px 15px;">100 GB Free Storage</p>
                                    <img src="assets/img/info.png" alt="" class="list-icon-img">
                                </li>
                                <li class="list-group-item border-0 d-flex align-items-center"><img
                                        src="assets/img/check.png" alt="" class="list-icon-img">
                                    <p class="plan-text" style="padding: 0px 35px 0px 15px;">Unlimited Visitors</p>
                                </li>
                                <li class="list-group-item border-0 d-flex align-items-center"><img
                                        src="assets/img/check.png" alt="" class="list-icon-img">
                                    <p class="plan-text" style="padding: 0px 35px 0px 15px;">10 Agents</p>
                                </li>
                                <li class="list-group-item border-0 d-flex align-items-center"><img
                                        src="assets/img/check.png" alt="" class="list-icon-img">
                                    <p class="plan-text" style="padding: 0px 35px 0px 15px;">Live Chat Support</p><img
                                        src="assets/img/info.png" alt="">
                                </li>
                            </ul>
                            <div class="d-flex flex-column align-items-center pt-3 pb-3"><a href="#"
                                    class=" btn plan-btn-1">Get 14
                                    Days Free Trial</a></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 justify-content-center mt-3">
                        <div class="plan-card active-plan-card"
                            style="
            background: #0094DE; 
            border-radius: 8px !important;">
                            <p class="plan-text Professional">Professional</p>
                            <p class="plan-rate">$49 <span class="plan-text">/month</span></p>
                            <p class="plan-text">All the basic features to boost your freelance career</p>
                            <div class="divider"></div>
                            <ul class="list-group">
                                <li class="list-group-item border-0 d-flex align-items-center"><img
                                        src="assets/img/white-checkmar.png" alt="" class="list-icon-img">
                                    <p class="plan-text" style="padding: 0px 35px 0px 15px;">Full Access to
                                        Landingfolio</p> <img src="assets/img/exclamation-circle.png" alt=""
                                        class="list-icon-img">
                                </li>
                                <li class="list-group-item border-0 d-flex align-items-center"><img
                                        src="assets/img/white-checkmar.png" alt="" class="list-icon-img">
                                    <p class="plan-text" style="padding: 0px 35px 0px 15px;">100 GB Free Storage</p>
                                    <img src="assets/img/exclamation-circle.png" alt=""
                                        class="list-icon-img">
                                </li>
                                <li class="list-group-item border-0 d-flex align-items-center"><img
                                        src="assets/img/white-checkmar.png" alt="" class="list-icon-img">
                                    <p class="plan-text" style="padding: 0px 35px 0px 15px;">Unlimited Visitors</p>
                                </li>
                                <li class="list-group-item border-0 d-flex align-items-center"><img
                                        src="assets/img/white-checkmar.png" alt="" class="list-icon-img">
                                    <p class="plan-text" style="padding: 0px 35px 0px 15px;">10 Agents</p>
                                </li>
                                <li class="list-group-item border-0 d-flex align-items-center"><img
                                        src="assets/img/white-checkmar.png" alt="" class="list-icon-img">
                                    <p class="plan-text" style="padding: 0px 35px 0px 15px;">Live Chat Support</p><img
                                        src="assets/img/exclamation-circle.png" alt="">
                                </li>
                            </ul>
                            <div class="d-flex flex-column align-items-center pt-3 pb-3"><a href="#"
                                    class=" btn plan-btn-2 text-white">Get 14 Days Free Trial</a></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 justify-content-center mt-3">
                        <div class="plan-card"
                            style="border: 2.16px solid;
            border-image-source: linear-gradient(86.73deg, #6FD3FE 3.13%, #7F61F9 95.46%);
            border-image-slice: 1; 
            border-radius: 8px !important;">
                            <p class="plan-text">Business</p>
                            <p class="plan-rate">$99 <span class="plan-text">/month</span></p>
                            <p class="plan-text">All the basic features to boost your freelance career</p>
                            <div class="divider"></div>
                            <ul class="list-group">
                                <li class="list-group-item border-0 d-flex align-items-center"><img
                                        src="assets/img/check.png" alt="" class="list-icon-img">
                                    <p class="plan-text" style="padding: 0px 35px 0px 15px;">Full Access to
                                        Landingfolio</p> <img src="assets/img/info.png" alt=""
                                        class="list-icon-img">
                                </li>
                                <li class="list-group-item border-0 d-flex align-items-center"><img
                                        src="assets/img/check.png" alt="" class="list-icon-img">
                                    <p class="plan-text" style="padding: 0px 35px 0px 15px;">100 GB Free Storage</p>
                                    <img src="assets/img/info.png" alt="" class="list-icon-img">
                                </li>
                                <li class="list-group-item border-0 d-flex align-items-center"><img
                                        src="assets/img/check.png" alt="" class="list-icon-img">
                                    <p class="plan-text" style="padding: 0px 35px 0px 15px;">Unlimited Visitors</p>
                                </li>
                                <li class="list-group-item border-0 d-flex align-items-center"><img
                                        src="assets/img/check.png" alt="" class="list-icon-img">
                                    <p class="plan-text" style="padding: 0px 35px 0px 15px;">10 Agents</p>
                                </li>
                                <li class="list-group-item border-0 d-flex align-items-center"><img
                                        src="assets/img/check.png" alt="" class="list-icon-img">
                                    <p class="plan-text" style="padding: 0px 35px 0px 15px;">Live Chat Support</p><img
                                        src="assets/img/info.png" alt="">
                                </li>
                            </ul>
                            <div class="d-flex flex-column align-items-center pt-3 pb-3"><a href="#"
                                    class=" btn plan-btn-1">Get 14
                                    Days Free Trial</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- end best plan section  -->

    <!-- prmium plugin section  -->
    <section
        style="background-image: url('assets/img/theme-free.png'); background-repeat: no-repeat; position: relative; background-size: cover;"
        class="free-theme">
        <img src="assets/img/priminum-top.png" alt="" class="primium-top">
        <img src="assets/img/primium-abs.png" alt="" class="primium-abs">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 plugin-img-con">
                    <img src="assets/img/plugin.png" alt="" class="plugin-img">
                </div>
                <div class="col-lg-6 plugin-img-con">
                    <h3 class="sec-tittle-1 mb-3 text-white text-align-start">$100-Worth Of Premium Plugins And
                        <span class="dif-color">Theme for Free!</span>
                    </h3>
                    <p class="plain-text mb-2 text-white" style="color: #A4A1A7;">With our service, you can
                        effortlessly create a fully
                        functional WordPress site in no time, all with just a single click, simplifying the entire
                        process for you.
                    </p> <br>
                    <p class="plain-text mb-5 text-white" style="color: #A4A1A7;">With our service, you can
                        effortlessly create a fully
                        functional WordPress site in no time, all with just a single click, simplifying the entire
                        process for you.
                    </p>
                    <a href="/subscription-plans"
                        class="btn btn-1 text-white rounded btn-space-two align-items-center mt-2">Get
                        Started Now <i class="fa-solid fa-arrow-right ps-2" style="color: #ffffff;"></i></a>
                </div>
            </div>
        </div>
        <img src="assets/img/priminum-botom.png" alt="" class="primium-botom">
    </section>
    <!--  end prmium plugin section  -->

    <!-- FAQ sectin  -->
    <section>
        <div class="container">
            <h3 class="sec-tittle">Frequently <span class="dif-color"> Asked Questions </span></h3>
            <p class=" text-dark header-font pt-3 pb-4" style="margin:0px">We`re happy to answer your questions</p>
            <div class="acc-div">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <span class="acc-tittle">What is Team Newsify? What does the technology work?</span>
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p class="plain-text" style="color: #6B6573;">
                                    It is almost completely automated as a system. You can schedule, plan, and create
                                    calendars for your
                                    upcoming emails. You can use AI analyzer, tracker, AI reporter, and AI to create a
                                    smooth business
                                    plan for you and your teammates with one click!
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <span class="acc-tittle">How is the team Newsify? What does the technology work?</span>
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p class="plain-text" style="color: #6B6573;">
                                    It is almost completely automated as a system. You can schedule, plan, and create
                                    calendars for your
                                    upcoming emails. You can use AI analyzer, tracker, AI reporter, and AI to create a
                                    smooth business
                                    plan for you and your teammates with one click!
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <span class="acc-tittle">How is the team Newsify? What does the technology work?</span>
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p class="plain-text" style="color: #6B6573;">
                                    It is almost completely automated as a system. You can schedule, plan, and create
                                    calendars for your
                                    upcoming emails. You can use AI analyzer, tracker, AI reporter, and AI to create a
                                    smooth business
                                    plan for you and your teammates with one click!
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                <span class="acc-tittle">What makes Newsify unique in the market?</span>
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p class="plain-text" style="color: #6B6573;">
                                    It is almost completely automated as a system. You can schedule, plan, and create
                                    calendars for your
                                    upcoming emails. You can use AI analyzer, tracker, AI reporter, and AI to create a
                                    smooth business
                                    plan for you and your teammates with one click!
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Accordion Item 5 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                <span class="acc-tittle">What are the key features of Newsify?</span>
                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p class="plain-text" style="color: #6B6573;">
                                    It is almost completely automated as a system. You can schedule, plan, and create
                                    calendars for your
                                    upcoming emails. You can use AI analyzer, tracker, AI reporter, and AI to create a
                                    smooth business
                                    plan for you and your teammates with one click!
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Accordion Item 6 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSix">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                <span class="acc-tittle">What are the key features of Newsify?</span>
                            </button>
                        </h2>
                        <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p class="plain-text" style="color: #6B6573;">
                                    It is almost completely automated as a system. You can schedule, plan, and create
                                    calendars for your
                                    upcoming emails. You can use AI analyzer, tracker, AI reporter, and AI to create a
                                    smooth business
                                    plan for you and your teammates with one click!
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- end FAQ section  -->

    <!-- testimonial sction  -->
    <section>
        <div class="container">
            <h3 class="sec-tittle">What Our Client <span class="dif-color"> Say About Us </span></h3>
            <p class=" text-dark header-font pt-3 pb-4" style="margin:0px">We`re happy to answer your questions</p>
            <div class="row test-con">
                <div class="col-lg-4 col-md-4 mb-3">
                    <div class="test-card"
                        style="background-image: url(assets/img/test-back.png); background-repeat: no-repeat;">
                        <img src="assets/img/star-rate.png" alt="" style="height: 19px; width: 120px;">
                        <p class="plain-text pt-3 pb-3" style="color: #6B6573;"> "The user interface is intuitive,
                            making transactions a
                            breeze. Whether I'm making purchases or managing my diverse portfolio of digital
                            currencies."The user
                            interface is intuitive, making transactions a breeze. Whether I'm making purchases or
                            managing </p>
                        <div class="row">
                            <div class="col-lg-6">
                                <p class="cutomer-nm text-dark">Mahmud Niloy</p>
                                <p class="custoer-desg">Super Web Designer</p>
                            </div>
                            <div class="col-lg-6"> <img src="assets/img/client-logo.png" alt=""
                                    class="cutome-logo">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 mb-3">
                    <div class="test-card"
                        style="background-image: url(assets/img/test-back.png); background-repeat: no-repeat;">
                        <img src="assets/img/star-rate.png" alt="" style="height: 19px; width: 120px;">
                        <p class="plain-text pt-3 pb-3" style="color: #6B6573;"> "The user interface is intuitive,
                            making transactions a
                            breeze. Whether I'm making purchases or managing my diverse portfolio of digital
                            currencies."The user
                            interface is intuitive, making transactions a breeze. Whether I'm making purchases or
                            managing </p>
                        <div class="row">
                            <div class="col-lg-6">
                                <p class="cutomer-nm text-dark">Mahmud Niloy</p>
                                <p class="custoer-desg">Super Web Designer</p>
                            </div>
                            <div class="col-lg-6"> <img src="assets/img/client-logo.png" alt=""
                                    class="cutome-logo">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 mb-3">
                    <div class="test-card"
                        style="background-image: url(assets/img/test-back.png); background-repeat: no-repeat;">
                        <img src="assets/img/star-rate.png" alt="" style="height: 19px; width: 120px;">
                        <p class="plain-text pt-3 pb-3" style="color: #6B6573;"> "The user interface is intuitive,
                            making transactions a
                            breeze. Whether I'm making purchases or managing my diverse portfolio of digital
                            currencies."The user
                            interface is intuitive, making transactions a breeze. Whether I'm making purchases or
                            managing </p>
                        <div class="row">
                            <div class="col-lg-6">
                                <p class="cutomer-nm text-dark">Mahmud Niloy</p>
                                <p class="custoer-desg">Super Web Designer</p>
                            </div>
                            <div class="col-lg-6"> <img src="assets/img/client-logo.png" alt=""
                                    class="cutome-logo">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end testimonial section  -->

    <!-- contact section  -->
    <section class="contact-sec">
        <div class="container contact-div d-flex justify-content-center ">
            <div class="row align-items-center">
                <div class="col-lg-6 center-box">
                    <h3 class="sec-tittle-1 mb-3 text-white text-align-start text-capitalize">Centralize your treasury,
                        the
                        modern way.</h3>
                    <p class="plain-text text-white">Lorem Ipsum is simply dummy text of the printing and typesetting
                        industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>

                </div>
                <div class="col-lg-6 d-flex center-but schedule-demo"><a href="#"
                        class=" btn contact-btn cutomer-nm text-white">Schedule a demo <i
                            class="fa-solid fa-arrow-right ps-2" style="color: #ffffff;"></i></a></div>
            </div>
        </div>

    </section>
    <!-- end contact section  -->

  



    <footer
        style="background-image: url('assets/img/Footer.png'); background-repeat: no-repeat; position: relative; background-size: cover;">
        <div class="container">
            <div class="row footer-con">

                <div class="col-lg-4 col-md-12 mb-4 text-center text-lg-start">
                    <div class="footer-first">
                        <img src="assets/img/Instant website logo-17 (1) 1.png" alt="" class="footer-logo">
                        <p class="plain-text footer-content mb-4" style="color: #FFFFFF99;">
                            With our service, you can effortlessly create a fully functional WordPress site in no time,
                            all with just a
                            single click, simplifying the entire process for you.
                        </p>
                        <div class="icon-box d-flex justify-content-center justify-content-lg-start gap-2">
                            <a href="#"><img class="link-icon" src="assets/img/Link.png" alt=""></a>
                            <a href="#"><img class="link-icon" src="assets/img/Link (1).png"
                                    alt=""></a>
                            <a href="#"><img class="link-icon" src="assets/img/Link (2).png"
                                    alt=""></a>
                            <a href="#"><img class="link-icon" src="assets/img/Link (3).png"
                                    alt=""></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-6 mb-4">
                    <p class="footer-tittle">Product</p>
                    <div class="divider-linear"></div>
                    <ul class="list-unstyled">
                        <li><a href="#" class="footer-list ">About Us</a></li>
                        <li><a href="#" class="footer-list  ">Features</a></li>
                        <li><a href="#" class="footer-list  ">Blogs</a></li>
                        <li><a href="#" class="footer-list  ">Reviews</a></li>
                        <li><a href="#" class="footer-list  ">Pricing</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-6 mb-4">
                    <p class="footer-tittle">Company</p>
                    <div class="divider-linear"></div>
                    <ul class="list-unstyled">
                        <li><a href="#" class="footer-list ">Integrations</a></li>
                        <li><a href="#" class="footer-list  ">Careers</a></li>
                        <li><a href="#" class="footer-list  ">Contact us</a></li>
                        <li><a href="#" class="footer-list  ">FAQ’s</a></li>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-6 mb-4">
                    <p class="footer-tittle">Resources</p>
                    <div class="divider-linear"></div>
                    <ul class="list-unstyled">
                        <li><a href="#" class="footer-list ">Changelog</a></li>
                        <li><a href="#" class="footer-list ">Cookie Policy</a></li>
                        <li><a href="#" class="footer-list ">Coming Soon</a></li>
                        <li><a href="#" class="footer-list ">Error 404</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6 mb-4">
                    <p class="footer-tittle">Utilities</p>
                    <div class="divider-linear"></div>
                    <ul class="list-unstyled">
                        <li><a href="#" class="footer-list ">Privacy Policy</a></li>
                        <li><a href="#" class="footer-list ">Licensing</a></li>
                        <li><a href="#" class="footer-list ">Terms & Conditions</a></li>
                        <li><a href="#" class="footer-list">Password</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Bottom Section -->
        <div class="container-fluid" style="border-top: 1px solid #FFFFFF99;font-weight: 200px;">
            <p class="plain-text py-2  text-center" style="color: #FFFFFF99;font-weight: 300;">
                Copyright © 2025 <a href="https://walstartechnologies.com/"
                    style="color: #FFFFFF99; text-decoration: none;">Walstar</a>. All rights reserved.
            </p>
        </div>
    </footer>

    <!-- JavaScript to Control the Slider -->


    <!-- end script for slick slider -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script>
        $(document).ready(function() {
            $('.logos-slider').slick({
                infinite: true, // Enables infinite looping (ensures continuous loop)
                slidesToShow: 6, // Show 5 slides at a time on desktop
                slidesToScroll: 1, // Scroll one slide at a time
                arrows: true, // Enable previous/next arrows
                dots: false, // Disable navigation dots (set to true if needed)
                autoplay: true, // Enable autoplay
                autoplaySpeed: 2000, // Set auto-slide delay to 2000ms
                prevArrow: '<button class="slick-prev">&#10094;</button>', // Custom previous button
                nextArrow: '<button class="slick-next">&#10095;</button>', // Custom next button
                pauseOnHover: true, // Pause autoplay when hovering over the slider
                focusOnSelect: true, // Focus on the selected slide when clicked
                lazyLoad: 'ondemand', // Lazy load images to improve performance
                responsive: [{
                        breakpoint: 1024, // On screens smaller than 1024px (Tablets and small laptops)
                        settings: {
                            slidesToShow: 4, // Show 4 slides at a time
                            slidesToScroll: 1,
                            arrows: true,
                            dots: false
                        }
                    },
                    {
                        breakpoint: 768, // On screens smaller than 768px (Mobile Landscape)
                        settings: {
                            slidesToShow: 2, // Show 2 slides at a time
                            slidesToScroll: 1,
                            arrows: true,
                            dots: false, // Enable dots for mobile navigation
                        }
                    },
                    {
                        breakpoint: 480, // On screens smaller than 480px (Mobile Portrait)
                        settings: {
                            slidesToShow: 1, // Show 1 slide at a time
                            slidesToScroll: 1,
                            arrows: false, // Hide arrows on very small screens
                            dots: false, // Enable dots for navigation on mobile
                        }
                    }
                ]
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.image-slider').slick({
                infinite: true, // Enables infinite looping (ensures continuous loop)
                slidesToShow: 3, // Show 5 slides at a time on desktop
                slidesToScroll: 1, // Scroll one slide at a time
                arrows: true, // Enable previous/next arrows
                dots: false, // Disable navigation dots (set to true if needed)
                autoplay: true, // Enable autoplay
                autoplaySpeed: 2000, // Set auto-slide delay to 2000ms
                prevArrow: '<button class="slick-prev">&#10094;</button>', // Custom previous button
                nextArrow: '<button class="slick-next">&#10095;</button>', // Custom next button
                pauseOnHover: true, // Pause autoplay when hovering over the slider
                focusOnSelect: true, // Focus on the selected slide when clicked
                lazyLoad: 'ondemand', // Lazy load images to improve performance
                responsive: [{
                        breakpoint: 1024, // On screens smaller than 1024px (Tablets and small laptops)
                        settings: {
                            slidesToShow: 2, // Show 4 slides at a time
                            slidesToScroll: 1,
                            arrows: true,
                            dots: false
                        }
                    },
                    {
                        breakpoint: 768, // On screens smaller than 768px (Mobile Landscape)
                        settings: {
                            slidesToShow: 2, // Show 2 slides at a time
                            slidesToScroll: 1,
                            arrows: true,
                            dots: false, // Enable dots for mobile navigation
                        }
                    },
                    {
                        breakpoint: 480, // On screens smaller than 480px (Mobile Portrait)
                        settings: {
                            slidesToShow: 1, // Show 1 slide at a time
                            slidesToScroll: 1,
                            arrows: false, // Hide arrows on very small screens
                            dots: false, // Enable dots for navigation on mobile
                        }
                    }
                ]
            });
        });
    </script>
    <script>
        // Ensure the toggle works smoothly
        document.addEventListener('DOMContentLoaded', function() {
            const toggler = document.querySelector('.navbar-toggler');
            const navbarCollapse = document.querySelector('.navbar-collapse');

            toggler.addEventListener('click', function() {
                navbarCollapse.classList.toggle('show');
            });
        });
    </script>
    <script>
        window.onscroll = function() {
            myFunction()
        };

        var header = document.getElementById("header-sticky");
        var sticky = header.offsetTop;

        function myFunction() {
            if (window.pageYOffset > sticky) {
                header.classList.add("sticky");
            } else {
                header.classList.remove("sticky");
            }
        }
    </script>

</body>

</html>
