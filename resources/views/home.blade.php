@extends('structures.main')

@section('content')
    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div id="notification">

    </div>

    <div class="modal fade" id="paymentmodel" tabindex="-1" aria-labelledby="paymentmodelLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 rounded-3 ">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title mb-0" id="paymentmodelLabel">
                        🎉 Upgrade Your Plan!
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ url('/payment') }}" method="POST" id="payment-form">
                        @csrf
                        <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="yearly-tab" data-bs-toggle="tab" href="#yearly"
                                    role="tab" aria-controls="yearly" aria-selected="true"
                                    onclick="selectOption('yearly')">🚀 Pro Yearly</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="monthly-tab" data-bs-toggle="tab" href="#monthly" role="tab"
                                    aria-controls="monthly" aria-selected="false" onclick="selectOption('monthly')">💡 Pro
                                    Monthly</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="yearly" role="tabpanel"
                                aria-labelledby="yearly-tab">
                                <div class="card border border-2 border-success rounded-3 p-3 mb-4">
                                    <div class="card-body text-center">
                                        <p class="card-text fs-4"><strong><i class="bi bi-currency-rupee"></i>
                                                5000/Year</strong></p>
                                        <small>Best value for your investment!</small>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="monthly" role="tabpanel" aria-labelledby="monthly-tab">
                                <div class="card border border-2 border-primary rounded-3 p-3 mb-4">
                                    <div class="card-body text-center">
                                        <p class="card-text fs-4"><strong><i class="bi bi-currency-rupee"></i>
                                                700/Month</strong></p>
                                        <small>Flexible and affordable!</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h3 class="text-center mb-3">Developer Tools</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-group list-group-flush text-center">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>✔️ 9 staging sites</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>✔️ 3 migrations / month</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>✔️ 5 templates</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-group list-group-flush text-center">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>✔️ 5 GB disk space</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>✔️ 300 events for 2-way sync</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>✔️ 24/7 Support</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <input type="hidden" name="amount" id="selectedAmount" value="">
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-info" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-info btn-lg" type="submit" id="payment-submit">🚀 Confirm
                                Selection</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="container m-4 border-1">
        <div class="text-end">
            <button id="createSiteButton" type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                data-bs-target="#siteCreationModal">
                Add New Site
            </button>
            <button type="button" class="btn payment mb-3" data-bs-toggle="modal" data-bs-target="#paymentmodel">
                <i class="bi bi-lock"></i> Upgrade Plan
            </button>
        </div>
    </div>



    {{-- CARDS DETAIL --}}
    <div class="row text-center">
        <!-- Staging Sites Card -->
        <div class="col-md-4 mb-3">
            <div class="card border-0 p-1 rounded-3 shadow-sm hover:shadow-lg hover:scale-105">
                <div class="card-body d-flex align-items-center justify-content-center">
                    <div class="icon-container bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                        style="width: 45px; height: 45px;">
                        <i class="fas fa-clipboard" style="font-size: 22px;"></i>
                    </div>
                    <div>
                        <h6 class="card-title mb-1" style="font-size: 1.1rem;">
                            <a href="/sites-info" class="text-decoration-none text-dark">
                                Staging Sites
                            </a>
                        </h6>

                        <h6 class="fw-bold mb-0" id="staging_count" style="font-size: 1.3rem;">0</h6>
                    </div>
                </div>
            </div>
        </div>

        <!-- Plugins Card -->
        <div class="col-md-4 mb-3">
            <div class="card border-0 p-1 rounded-3 shadow-sm hover:shadow-lg hover:scale-105">
                <div class="card-body d-flex align-items-center justify-content-center">
                    <div class="icon-container bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                        style="width: 45px; height: 45px;">
                        <i class="bi bi-plugin" style="font-size: 22px;"></i>
                    </div>
                    <div>
                        <h6 class="card-title mb-1" style="font-size: 1.1rem;">
                            <a href="/plugins" class="text-decoration-none text-dark">
                                Plugins
                            </a>
                        </h6>

                        <h6 class="fw-bold mb-0" id="plugin" style="font-size: 1.3rem;">0</h6>
                    </div>
                </div>
            </div>
        </div>

        <!-- Themes Card -->
        <div class="col-md-4 mb-3">
            <div class="card border-0 p-1 rounded-3 shadow-sm hover:shadow-lg hover:scale-105">
                <div class="card-body d-flex align-items-center justify-content-center">
                    <div class="icon-container bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                        style="width: 45px; height: 45px;">
                        <i class="bi bi-images" style="font-size: 22px;"></i>
                    </div>
                    <div>
                        <h6 class="card-title mb-1" style="font-size: 1.1rem;">
                            <a href="/themes" class="text-decoration-none text-dark">
                                Templets / Themes
                            </a>
                        </h6>
                        <h6 class="fw-bold mb-0" id="themes" style="font-size: 1.3rem;">0</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- GRAPH --}}
    <div class="row justify-content-center">
        <!-- Wrapper for Centered Cards -->
        <div class="col-md-10">
            <div class="row">
                <!-- Site Status Chart Card -->
                <div class="col-md-6 mb-3">
                    <div class="card border-0 rounded bg-light p-3">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center">
                            <canvas id="siteStatusChart" width="100" height="100"></canvas>
                        </div>
                    </div>
                </div>

                <!-- User Chart Card -->
                <div class="col-md-6 mb-3">
                    <div class="card border-0 rounded bg-light p-3">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center">
                            <canvas id="subscriptionChart" width="100" height="100"></canvas>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    {{-- GRAPH USRD PREDICTION --}}
    <div class="col-md-12 mb-3">
        <div class="card border-0 rounded bg-light p-3">
            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                <canvas id="userChart" style="max-height: 500px; width: 100%;" height="127" width="100"></canvas>
            </div>
        </div>
    </div>










    <div class="container">
        {{-- <button id="createSiteButton" type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
            data-bs-target="#siteCreationModal">
            Create Your First Site
        </button> --}}
        <div class="card p-4  rounded" id="detailofwordpress" style="background: #f5f5f5;">
            <h2 class="text-center mb-4" style="">Subscribers</h2>
            <div class="responsive">
                <table id="userDetailsTable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Email</th>
                            <th>URL</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be populated here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>




    <div class="container mt-3">
        <!-- Modal -->
        <div class="modal fade" id="siteCreationModal" tabindex="-1" aria-labelledby="siteCreationModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="siteCreationModalLabel">Create Your First Site</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="siteCreationFormone" method="POST">
                            <!-- Step 1: Basic Information -->
                            <div id="step1" class="form-step">
                                <div class="row">
                                    <input type="text" name="version" id="version" class="d-none">
                                    <div class="col-md-6 mb-3">
                                        <label for="siteName" class="form-label">Site Name</label>
                                        <input type="text" class="form-control" id="siteName" name="siteName"
                                            placeholder="Leave blank for a surprise" required autocomplete="off">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="user_name" class="form-label">User Name</label>
                                        <input type="text" class="form-control" id="user_name" name="user_name"
                                            placeholder="Leave blank for a surprise" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="Leave blank for a surprise" required autocomplete="off">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="wpVersion" class="form-label">WordPress Version</label>
                                        <select class="form-select" id="wpVersion" name="wpVersion" required>
                                            <option value="6.6.2">6.6.2</option>
                                        </select>

                                    </div>

                                </div>
                                <button type="button" class="btn btn-primary next-step" id="next-btn">NEXT</button>
                            </div>
                        </form>

                        <form id="siteCreationFormtwo" action="">
                            <!-- Step 2: Plugin Selection -->
                            <div id="step2" class="form-step d-none">
                                <div class="row">
                                    <!-- Plugin Categories -->
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-12 mb-3">
                                        <h6>Select Plugins</h6>
                                        <div id="pluginCategoriesContainer">
                                            <p>No categories available yet.</p>
                                        </div>
                                    </div>

                                    <!-- Plugin List Container -->
                                    <div class="col-lg-6 col-md-5 col-sm-8 col-12 mb-3">
                                        <div class="border border-secondary p-3 " style="border-radius: 20px;">
                                            <h6>Plugins List</h6>
                                            <div id="pluginList" class="plugin-list">
                                                <p>No plugins available in this category.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Selected Plugins -->
                                    <div class="col-lg-4 col-md-4 col-12 mb-3">
                                        <div class="border border-secondary p-3 " style="border-radius: 20px;">
                                            <h6>Selected Plugins</h6>
                                            <div id="selectedPluginsContainer" class="d-flex flex-wrap">
                                                <p>No plugins selected yet.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-5">
                                    <button type="button" class="btn btn-secondary prev-step">BACK</button>
                                    <button type="submit" class="btn btn-success"><i
                                            class="bi bi-download"></i></button>
                                    <button type="button" class="btn btn-primary next-step2"
                                        id="next-step2">NEXT</button>
                                </div>
                            </div>
                        </form>
                        <form id="siteCreationFormthree" action="">
                            <!-- Step 3: Themes Selection -->
                            <div id="step3" class="form-step d-none">
                                <div class="row">
                                    <!-- Themes  -->
                                    <div class="col-lg-12 col-md-6 col-sm-12 mb-3">
                                        <h6>Select Themes</h6>
                                        <div id="all-themes">
                                            <p>No Themes available yet.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-5">
                                    <button type="button" class="btn btn-secondary prev-step2">BACK</button>
                                    <button type="button" class="btn btn-success download-themes"><i
                                            class="bi bi-download"></i></button>
                                    <button type="button" class="btn btn-primary next-step3"
                                        id="next-step3">NEXT</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>





    </div>




    {{-- //loader --}}
    <div class="modal fade" id="loaderModal" tabindex="-1" aria-labelledby="loaderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-body d-flex justify-content-center align-items-center">
                    <div class="loader"></div>
                </div>
                <div class="modal-body d-flex justify-content-center align-items-center">
                    <p class="mt-2">Downloading WordPress <i class="bi bi-wordpress"></i>. Please wait a moment.</p>

                </div>

            </div>
        </div>
    </div>



    <script>
        $(document).ready(function() {


            // Next step from Step 1 to Step 2
            document.querySelectorAll('.next-step').forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('step1').classList.add('d-none');
                    document.getElementById('step2').classList.remove('d-none');
                });
            });

            // Next step from Step 2 to Step 3
            document.querySelectorAll('.next-step2').forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('step2').classList.add('d-none');
                    document.getElementById('step3').classList.remove('d-none');
                });
            });

            // Navigate back from Step 2 to Step 1
            document.querySelectorAll('.prev-step').forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('step2').classList.add('d-none');
                    document.getElementById('step1').classList.remove('d-none');
                });
            });

            // Navigate back from Step 3 to Step 2
            document.querySelectorAll('.next-step3').forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('step3').classList.add('d-none');
                    document.getElementById('step2').classList.remove('d-none');
                });
            });
            document.querySelectorAll('.prev-step2').forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('step3').classList.add('d-none');
                    document.getElementById('step2').classList.remove('d-none');
                });
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const paymentModal = document.getElementById('paymentmodel');

            paymentModal.addEventListener('show.bs.modal', function() {
                selectOption('yearly');
                highlightCard('yearlyCard', 'monthlyCard');
            });
        });

        function selectOption(plan) {
            const amountInput = document.getElementById('selectedAmount');

            if (plan === 'yearly') {
                amountInput.value = 5000;
                highlightCard('yearlyCard', 'monthlyCard');
            } else {
                amountInput.value = 700;
                highlightCard('monthlyCard', 'yearlyCard');
            }
        }

        function highlightCard(selectedCardId, otherCardId) {
            // Add Bootstrap 'border-primary' class for the selected card, and remove from the other
            document.getElementById(selectedCardId).classList.add('border-primary');
            document.getElementById(otherCardId).classList.remove('border-primary');
        }
    </script>



    <script src="assets/js/create-wordpress.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/home.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
