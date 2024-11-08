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
                            Industry
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
                            Industry
                        </h4>
                    </div>
                </div>
            </div>

            <!-- Pagination Controls -->
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center" id="pagination-controls">
                    <!-- Page buttons will be inserted here -->
                </ul>
            </nav>

        </div>
    </section>

    <!-- Style -->
    <style>
        /* Apply Poppins font */
        body {
            font-family: 'Poppins', sans-serif;
        }

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
    </style>

    <!-- Pagination Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentPage = 1;
            const itemsPerPage = 6;
            const totalItems = document.querySelectorAll('.temp-item').length;
            const totalPages = Math.ceil(totalItems / itemsPerPage);

            const items = Array.from(document.querySelectorAll('.temp-item'));
            const paginationControls = document.getElementById('pagination-controls');

            // Function to show items based on the current page
            function showItems() {
                items.forEach((item, index) => {
                    const page = Math.ceil((index + 1) / itemsPerPage);
                    item.style.display = (page === currentPage) ? 'block' : 'none';
                });

                // Update the active page number
                const pageLinks = document.querySelectorAll('.page-link');
                pageLinks.forEach(link => link.classList.remove('active'));
                pageLinks[currentPage - 1].classList.add('active');
            }

            // Function to generate pagination buttons
            function generatePagination() {
                paginationControls.innerHTML = ''; // Clear existing pagination

                // Generate buttons
                for (let i = 1; i <= totalPages; i++) {
                    const li = document.createElement('li');
                    li.classList.add('page-item');

                    const a = document.createElement('a');
                    a.classList.add('page-link');
                    a.href = '#';
                    a.innerText = i;
                    a.addEventListener('click', function(e) {
                        e.preventDefault();
                        currentPage = i;
                        showItems();
                    });

                    li.appendChild(a);
                    paginationControls.appendChild(li);
                }
            }

            // Initialize the page
            generatePagination();
            showItems();
        });
    </script>
@endsection
