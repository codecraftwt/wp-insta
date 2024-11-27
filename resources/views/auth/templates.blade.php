@extends('layouts.app')

@section('content')
    <!-- Main Container -->
    <div class="hero-background-pattern">
        <div class="templet-hero-section bgcolors p-5"
            style="background: linear-gradient(135deg, #d9ffdc 0%, #e0f7fa 100%); display: flex; flex-direction: column; align-items: center; justify-content: center; ">
            <div class="templet-hero-title text-center">Templates</div>

        </div>
    </div>


    <section class="py-5 bg-light">
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
                <div class="col-lg-4 col-sm-6 aos-init aos-animate temp-item" data-aos="fade-up">
                    <div class="card text-center mb-4">
                        <div class="card-image">
                            <div class="temp-container">
                                <img class="temp-img" src="assets/img/temp_img_4.png" alt="Demo Image">
                            </div>
                        </div>
                        <h4 class="card-title">
                            IT (Light)
                        </h4>
                    </div>
                </div>
                {{-- TEMP-5 --}}
                <div class="col-lg-4 col-sm-6 aos-init aos-animate temp-item" data-aos="fade-up">
                    <div class="card text-center mb-4">
                        <div class="card-image">
                            <div class="temp-container">
                                <img class="temp-img" src="assets/img/temp_img_5.png" alt="Demo Image">
                            </div>
                        </div>
                        <h4 class="card-title">
                            Lawer
                        </h4>
                    </div>
                </div>
                {{-- TEMP-6 --}}
                <div class="col-lg-4 col-sm-6 aos-init aos-animate temp-item" data-aos="fade-up">
                    <div class="card text-center mb-4">
                        <div class="card-image">
                            <div class="temp-container">
                                <img class="temp-img" src="assets/img/temp_img_6.png" alt="Demo Image">
                            </div>
                        </div>
                        <h4 class="card-title">
                            IT (Dark)
                        </h4>
                    </div>
                </div>
                {{-- TEMP-7 --}}
                <div class="col-lg-4 col-sm-6 aos-init aos-animate temp-item" data-aos="fade-up">
                    <div class="card text-center mb-4">
                        <div class="card-image">
                            <div class="temp-container">
                                <img class="temp-img" src="assets/img/temp_img_7.png" alt="Demo Image">
                            </div>
                        </div>
                        <h4 class="card-title">
                            Course
                        </h4>
                    </div>
                </div>
                {{-- TEMP-8 --}}
                <div class="col-lg-4 col-sm-6 aos-init aos-animate temp-item" data-aos="fade-up">
                    <div class="card text-center mb-4">
                        <div class="card-image">
                            <div class="temp-container">
                                <img class="temp-img" src="assets/img/temp_img_8.png" alt="Demo Image">
                            </div>
                        </div>
                        <h4 class="card-title">
                            Industry
                        </h4>
                    </div>
                </div>
                {{-- TEMP-9 --}}
                <div class="col-lg-4 col-sm-6 aos-init aos-animate temp-item" data-aos="fade-up">
                    <div class="card text-center mb-4">
                        <div class="card-image">
                            <div class="temp-container">
                                <img class="temp-img" src="assets/img/temp_img_9.png" alt="Demo Image">
                            </div>
                        </div>
                        <h4 class="card-title">
                            Hotel
                        </h4>
                    </div>
                </div>
                {{-- TEMP-10 --}}
                <div class="col-lg-4 col-sm-6 aos-init aos-animate temp-item" data-aos="fade-up">
                    <div class="card text-center mb-4">
                        <div class="card-image">
                            <div class="temp-container">
                                <img class="temp-img" src="assets/img/temp_img_10.png" alt="Demo Image">
                            </div>
                        </div>
                        <h4 class="card-title">
                            Space
                        </h4>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <button id="load-more" class="btn btn-primary">Load More</button>
            </div>

        </div>
    </section>

    <!-- Style -->
    <style>
        /* Apply Poppins font */


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

        .templet-hero-section {
            font-family: 'Montserrat', sans-serif;
            font-size: 5rem;
            font-weight: bold;
            word-spacing: 5px;
            letter-spacing: 4px;
            font-family: 'Montserrat', sans-serif;

        }

        #load-more {
            font-size: 1em;
            font-weight: 400;
            line-height: 1.5;
            letter-spacing: 0.031em;
            word-spacing: 0.0625em;
            background-color: #B8364C;
            border-style: solid;
            border-width: 0.0625em;
            border-color: #B8364C;
            border-radius: 0.5em;
            box-shadow: 0 0 0 0.125em #B8364C;
            padding: 0.625em 1.25em;
            color: white;
            text-align: center;
            display: inline-block;
            transition: all 0.3s;
        }
    </style>

    <!-- Pagination Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let items = Array.from(document.querySelectorAll('.temp-item')); // All items
            const itemsPerPage = 6; // Number of items to show per click
            let visibleItems = itemsPerPage; // Number of items initially visible

            // Function to show items
            function showItems() {
                items.forEach((item, index) => {
                    if (index < visibleItems) {
                        item.style.display = 'block'; // Show the item
                    } else {
                        item.style.display = 'none'; // Hide the item
                    }
                });

                // Hide "Load More" button if all items are visible
                if (visibleItems >= items.length) {
                    document.getElementById('load-more').style.display = 'none';
                }
            }

            // Initial display
            showItems();

            // Add event listener to "Load More" button
            document.getElementById('load-more').addEventListener('click', function() {
                visibleItems += itemsPerPage; // Increase visible items count
                showItems(); // Update displayed items
            });
        });
    </script>
@endsection
