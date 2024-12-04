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
            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="subscription-notification">
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

            @if (auth()->check() && auth()->user()->role->name == 'user')
                <a href="renew-plans" class="btn payment mb-3" id="renewplanButton"><i class="bi bi-lock"></i> Renew
                    Plan</a>
            @endif
        </div>
    </div>






    @if (auth()->check() && auth()->user()->role->name === 'superadmin')
        <x-admin-card />
    @elseif (auth()->check() && auth()->user()->role->name === 'user')
        <x-user-card />
    @endif



    <div class="container mt-3">
        <!-- Modal -->
        <div class="modal fade" id="siteCreationModal" tabindex="-1" aria-labelledby="label" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content shadow-lg border-0">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="siteCreationModalLabel">Create Your First Site</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body bg-light">
                        <!-- Step 1: site Creation Formone -->
                        <form id="siteCreationFormone" method="POST">
                            <!-- Step 1: Basic Information -->
                            <div id="step1" class="form-step">
                                <div class="row g-4">
                                    <input type="text" name="version" id="version" class="d-none">
                                    <div class="col-md-6">
                                        <label for="siteName" class="form-label fw-semibold">Site Name</label>
                                        <input type="text" class="form-control border border-primary shadow-sm"
                                            id="siteName" name="siteName" placeholder="Leave blank for a surprise" required
                                            autocomplete="off">
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
                                            id="password" name="password" placeholder="Leave blank for a surprise" required
                                            autocomplete="off">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="wpVersion" class="form-label fw-semibold">WordPress Version</label>
                                        <select class="form-select border border-primary shadow-sm" id="wpVersion"
                                            name="wpVersion" required>
                                            <option value="6.6.2">6.6.2</option>
                                            <option value="6.7.1">6.7.1</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="text-end mt-4">
                                    <button type="button" class="btn btn-primary px-4 py-2 shadow-sm next-step"
                                        id="next-btn">NEXT</button>
                                </div>
                            </div>
                        </form>
                        <!-- Step 2: Plugin Selection -->
                        <form id="siteCreationFormtwo" action="">
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
                        <!-- Step 3: Themes Selection  and Finish -->
                        <form id="siteCreationFormthree">
                            <div id="step3" class="form-step d-none">
                                <div class="row g-4">
                                    <div class="col-lg-3 col-md-3 col-sm-4">
                                        <div class="border border-primary rounded p-3 bg-white shadow-sm">
                                            <h6 class="text-primary">Select Themes Category</h6>

                                            <div id="all-categories">
                                                <p class="text-muted">No plugins selected yet.</p>
                                            </div>
                                            <!-- Categories will be dynamically loaded here -->
                                        </div>
                                    </div>
                                    <div class="col-9">
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

                                        <button type="button" class="btn btn-primary px-4 py-2 shadow-sm next-step3"
                                            id="next-step3">Finish</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- Step 4: Login Details -->
                        <form id="siteCreationFormfour">
                            <div id="step4" class="form-step d-none">
                                <div class="modal-body">
                                    <div class="container">
                                        <div class="text-center">

                                            <div class="mb-4">
                                                <i class="fas fa-check-circle"
                                                    style="font-size: 60px; color: #28a745;"></i>
                                            </div>
                                            <h5 class="card-title mb-3 text-success">WP Details</h5>
                                            <p id="login_url_display">
                                                <a href="#" target="_blank"
                                                    class="text-decoration-none text-primary fw-bold">
                                                    <i class="bi bi-box-arrow-up-right"></i> Loading...
                                                </a>
                                            </p>

                                            <!-- Username and Password Fields in 2 columns -->
                                            <div class="row g-3 mb-4">
                                                <div class="col-12 col-md-6">
                                                    <div class="mb-2">
                                                        <h6 class="card-title text-success">
                                                            <i class="bi bi-person-fill"></i> Username
                                                        </h6>
                                                        <p id="user_name_display" class="fw-bold text-muted">
                                                            Loading...</p>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6">
                                                    <div class="mb-2">
                                                        <h6 class="card-title text-danger">
                                                            <i class="bi bi-lock-fill"></i> Password
                                                        </h6>
                                                        <p id="password_display" class="fw-bold text-muted">Loading...
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
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
            $.ajax({
                url: '/upgradeplans',
                type: 'GET',
                success: function(data) {
                    if (data.length > 0 && data[0] === "1") {

                        $('#renewplanButton').hide();

                    } else {

                        $('#renewplanButton').show();

                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error); // Handle errors here
                }
            });
            // Next step from Step 1 to Step 2
            document.querySelectorAll('.next-step').forEach(button => {
                button.addEventListener('click', function() {
                    var siteName = document.getElementById('siteName').value.trim();
                    var userName = document.getElementById('user_name').value.trim();
                    var password = document.getElementById('password').value.trim();
                    var wpVersion = document.getElementById('wpVersion').value;

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

                    document.getElementById('step1').classList.add('d-none');
                    document.getElementById('step2').classList.remove('d-none');
                    $('#siteCreationModalLabel').text('Select  Plugins');
                });
            });

            // Next step from Step 2 to Step 3
            document.querySelectorAll('.next-step2').forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('step2').classList.add('d-none');
                    document.getElementById('step3').classList.remove('d-none');
                    $('#siteCreationModalLabel').text('Select  Themes');
                });
            });

            // Next step from Step 3 to Step 4
            document.querySelectorAll('.next-step3').forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('step3').classList.add('d-none');
                    document.getElementById('step4').classList.remove('d-none');
                    $('#siteCreationModalLabel').text('Login Credentials');
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
            document.querySelectorAll('.prev-step2').forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('step3').classList.add('d-none');
                    document.getElementById('step2').classList.remove('d-none');
                });
            });

            // Navigate back from Step 4 to Step 3
            document.querySelectorAll('.prev-step3').forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('step4').classList.add('d-none');
                    document.getElementById('step3').classList.remove('d-none');
                });
            });

            // Fetch active users count
            $.ajax({
                url: '/countUsers',
                method: 'GET',
                success: function(response) {
                    $('#users_count').text(response.active + response.inactive);
                    $('#active_uses').text(response.active);
                    $('#inactive_uses').text(response.inactive);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", error);
                }
            });



        });
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
        /* Custom scrollbar styles for all containers */
        #pluginCategoriesContainer::-webkit-scrollbar,
        #pluginList::-webkit-scrollbar,
        #selectedPluginsContainer::-webkit-scrollbar,
        #all-categories::-webkit-scrollbar {
            width: 3px;
            height: 8px;
        }

        #pluginCategoriesContainer::-webkit-scrollbar-track,
        #pluginList::-webkit-scrollbar-track,
        #selectedPluginsContainer::-webkit-scrollbar-track,
        #all-categories::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        #pluginCategoriesContainer::-webkit-scrollbar-thumb,
        #pluginList::-webkit-scrollbar-thumb,
        #selectedPluginsContainer::-webkit-scrollbar-thumb,
        #all-categories::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        #pluginCategoriesContainer::-webkit-scrollbar-thumb:hover,
        #pluginList::-webkit-scrollbar-thumb:hover,
        #selectedPluginsContainer::-webkit-scrollbar-thumb:hover,
        #all-categories::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .icon-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .icon-container i {
            font-size: 40px;
            color: #28a745;
        }
    </style>
@endsection
