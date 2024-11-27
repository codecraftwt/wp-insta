@extends('structures.main')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div id="notification">
        @php
            // Retrieve the notification from the cache
            $notification = Cache::get('subscription_notification_' . auth()->user()->id);
        @endphp

        @if ($notification && auth()->check() && auth()->user()->role->name !== 'superadmin')
            <div class="alert alert-warning alert-dismissible fade show" role="alert" id="subscription-notification">
                <button type="button" class="btn-close" id="close-notification-btn" aria-label="Close"></button>
                {{ $notification }}
            </div>
        @endif
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
                                <div class="card border border-2 border-success rounded-3">
                                    <div class="card-body text-center">
                                        <p class="card-text fs-4"><strong><i class="bi bi-currency-rupee"></i>
                                                5000/Year</strong></p>
                                        <small>Best value for your investment!</small>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="monthly" role="tabpanel" aria-labelledby="monthly-tab">
                                <div class="card border border-2 border-primary rounded-3 ">
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



    @if (auth()->check() && auth()->user()->role->name === 'superadmin')
        <x-admin-card />
    @elseif (auth()->check() && auth()->user()->role->name === 'user')
        <x-user-card />
    @endif



    <div class="container mt-3">
        <!-- Modal -->
        <div class="modal fade" id="siteCreationModal" tabindex="-1" aria-labelledby="siteCreationModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content shadow-lg border-0">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="siteCreationModalLabel">Create Your First Site</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body bg-light">
                        <form id="siteCreationFormone" method="POST">
                            <!-- Step 1: Basic Information -->
                            <div id="step1" class="form-step">
                                <div class="row g-4">
                                    <input type="text" name="version" id="version" class="d-none">
                                    <div class="col-md-6">
                                        <label for="siteName" class="form-label fw-semibold">Site Name</label>
                                        <input type="text" class="form-control border border-primary shadow-sm"
                                            id="siteName" name="siteName" placeholder="Leave blank for a surprise"
                                            required autocomplete="off">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="user_name" class="form-label fw-semibold">User Name</label>
                                        <input type="text" class="form-control border border-primary shadow-sm"
                                            id="user_name" name="user_name" placeholder="Leave blank for a surprise"
                                            required autocomplete="off">
                                    </div>
                                </div>
                                <div class="row g-4 mt-3">
                                    <div class="col-md-6">
                                        <label for="password" class="form-label fw-semibold">Password</label>
                                        <input type="password" class="form-control border border-primary shadow-sm"
                                            id="password" name="password" placeholder="Leave blank for a surprise"
                                            required autocomplete="off">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="wpVersion" class="form-label fw-semibold">WordPress Version</label>
                                        <select class="form-select border border-primary shadow-sm" id="wpVersion"
                                            name="wpVersion" required>
                                            <option value="6.6.2">6.6.2</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="text-end mt-4">
                                    <button type="button" class="btn btn-primary px-4 py-2 shadow-sm next-step"
                                        id="next-btn">NEXT</button>
                                </div>
                            </div>
                        </form>

                        <form id="siteCreationFormtwo" action="">
                            <!-- Step 2: Plugin Selection -->
                            <div id="step2" class="form-step d-none">
                                <div class="row g-4">
                                    <!-- Plugin Categories -->
                                    <div class="col-lg-2 col-md-3 col-sm-4">
                                        <div class="border border-primary rounded p-3 bg-white shadow-sm">
                                            <h6 class="text-primary text-center">Categories</h6>
                                            <div id="pluginCategoriesContainer">
                                                <p class="text-muted">No categories available yet.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Plugin List Container -->
                                    <div class="col-lg-6 col-md-5 col-sm-8">
                                        <div class="border border-primary rounded p-3 bg-white shadow-sm">
                                            <h6 class="text-primary">Plugins List</h6>
                                            <div id="pluginList" class="plugin-list">
                                                <p class="text-muted">No plugins available in this category.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Selected Plugins -->
                                    <div class="col-lg-4 col-md-4">
                                        <div class="border border-primary rounded p-3 bg-white shadow-sm">
                                            <h6 class="text-primary">Selected Plugins</h6>
                                            <div id="selectedPluginsContainer" class="d-flex flex-wrap">
                                                <p class="text-muted">No plugins selected yet.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button"
                                        class="btn btn-secondary px-4 py-2 shadow-sm prev-step">BACK</button>
                                    <div>

                                        <button type="submit" class="btn btn-primary px-4 py-2 shadow-sm next-step2"
                                            id="next-step2">NEXT</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <form id="siteCreationFormthree" action="">
                            <!-- Step 3: Themes Selection -->
                            <div id="step3" class="form-step d-none">
                                <div class="row g-4">
                                    <!-- Themes  -->
                                    <div class="col-12">
                                        <div class="border border-primary rounded p-3 bg-white shadow-sm">
                                            <h6 class="text-primary">Select Themes</h6>
                                            <div id="all-themes">
                                                <p class="text-muted">No themes available yet.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button"
                                        class="btn btn-secondary px-4 py-2 shadow-sm prev-step2">BACK</button>
                                    <div>
                                        <button type="button"
                                            class="btn btn-success px-4 py-2 shadow-sm me-2 download-themes">
                                            <i class="bi bi-download"></i> Download
                                        </button>
                                        <button type="button" class="btn btn-primary px-4 py-2 shadow-sm next-step3"
                                            id="next-step3">Finish</button>
                                    </div>
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
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">

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
                    // Validate fields in Step 1
                    var siteName = document.getElementById('siteName').value.trim();
                    var userName = document.getElementById('user_name').value.trim();
                    var password = document.getElementById('password').value.trim();
                    var wpVersion = document.getElementById('wpVersion').value;

                    // Check if any field is empty
                    if (!siteName || !userName || !password || !wpVersion) {
                        Swal.fire({
                            icon: 'error',
                            title: 'All fields in Step 1 are required!',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                        return; // Stop the navigation to Step 2
                    }

                    // If validation passes, move to Step 2
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
                    document.getElementById('step2').classList.add('d-none');
                });
            });
            document.querySelectorAll('.prev-step2').forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('step3').classList.add('d-none');
                    document.getElementById('step2').classList.remove('d-none');
                });
            });



            //ACTIVE USES

            $.ajax({
                url: '/countUsers', // The route where the user data is fetched
                method: 'GET',
                success: function(response) {
                    // Update the displayed counts dynamically
                    $('#users_count').text(response.active + response.inactive); // Total users count
                    $('#active_uses').text(response.active); // Active users count
                    $('#inactive_uses').text(response.inactive); // Inactive users count
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", error);
                }
            });
        });
    </script>


    {{-- //UPGRADE paln --}}

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

    <script>
        // Handle the close button click event
        $('#close-notification-btn').on('click', function() {
            // Hide the notification
            $('#subscription-notification').fadeOut();

            // Store that the user has dismissed the notification using AJAX
            $.ajax({
                url: '{{ route('dismissNotification') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // Add CSRF token for security
                },
                success: function(data) {
                    if (data.status === 'success') {
                        // You can perform any other actions here after successful dismissal.
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error); // Handle errors here
                }
            });
        });
    </script>







    <script src="assets/js/create-wordpress.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/home.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <script>
        var authRole = "{{ auth()->user()->role->name }}"; // Assuming 'name' is the role attribute
    </script>
    <style>
        /* Custom scrollbar styles */
        #pluginCategoriesContainer::-webkit-scrollbar,
        #pluginList::-webkit-scrollbar,
        #selectedPluginsContainer::-webkit-scrollbar {
            width: 3px;
            height: 8px;
        }

        #pluginCategoriesContainer::-webkit-scrollbar-track,
        #pluginList::-webkit-scrollbar-track,
        #selectedPluginsContainer::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        #pluginCategoriesContainer::-webkit-scrollbar-thumb,
        #pluginList::-webkit-scrollbar-thumb,
        #selectedPluginsContainer::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        #pluginCategoriesContainer::-webkit-scrollbar-thumb:hover,
        #pluginList::-webkit-scrollbar-thumb:hover,
        #selectedPluginsContainer::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
@endsection
