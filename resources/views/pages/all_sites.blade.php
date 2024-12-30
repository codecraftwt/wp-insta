@extends('structures.main')

@section('content')
<div class="container">
    <h1 class="my-4 text-center">Manage Sites</h1>


    <div class="container m-4 border-1">
        <div class="text-end">
            <button id="createSiteButton" type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                data-bs-target="#siteCreationModal">
                Add New Site
            </button>
        </div>
    </div>

    {{-- //MODEL --}}
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

                                    <!-- Site Name and User Name -->
                                    <div class="col-md-6">
                                        <label for="siteName" class="form-label fw-semibold">Site Name</label>
                                        <input type="text" class="form-control border border-primary shadow-sm" id="siteName" name="siteName" placeholder="Enter Your Site Name" required autocomplete="off">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="user_name" class="form-label fw-semibold">User Name</label>
                                        <input type="text" class="form-control border border-primary shadow-sm" id="user_name" name="user_name" placeholder="Enter Your User Name" required autocomplete="off">
                                    </div>
                                </div>

                                <div class="row g-4 mt-3">
                                    <!-- Password and WordPress Version -->
                                    <div class="col-md-6">
                                        <label for="password" class="form-label fw-semibold">Password</label>
                                        <input type="password" class="form-control border border-primary shadow-sm" id="password" name="password" placeholder="Enter Your User Password" required autocomplete="off">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="wpVersion" class="form-label fw-semibold">WordPress Version</label>
                                        <select class="form-select border border-primary shadow-sm" id="wpVersion" name="wpVersion" required>
                                            <option value="6.6.2">6.6.2</option>
                                            <option value="6.7.1">6.7.1</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row g-4 mt-3">
                                    <!-- Domain Name and Storage Information -->
                                    <div class="col-md-6">
                                        <label for="folder_name" class="form-label fw-semibold">Domain Name</label>
                                        <input type="text" class="form-control border border-primary shadow-sm" id="folder_name" name="folder_name" placeholder="Enter Your User Domain Name" required autocomplete="off">
                                    </div>

                                    <div class="col-md-6 ">
                                        <div class="row mt-1">
                                            <!-- Total Usage, Storage Limit, Number of Sites -->
                                            <div class="col-md-4">
                                                <label for="total_usage"><strong>Total Usage:</strong></label>
                                                <input type="text" id="total_usage" value="{{ $userStorage['totalusages'] }}" class="form-control" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="storage_limit"><strong>Storage Limit:</strong></label>
                                                <input type="text" id="storage_limit" value="{{ $userStorage['storage'] }}" class="form-control" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="usersite"><strong>Number of Sites:</strong></label>
                                                <input type="text" id="usersite" value="{{ $userStorage['usersite'] }}" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Next Button -->
                                <div class="text-end mt-4">
                                    <button type="button" class="btn btn-primary px-4 py-2 shadow-sm next-step" id="next-btn">NEXT</button>
                                </div>
                            </div>
                        </form>

                        <!-- Step 2: Plugin Selection -->
                        <form id="siteCreationFormtwo" action="">
                            <div id="step2" class="form-step d-none">
                                <div class="row g-4">
                                    <!-- Plugin Categories -->
                                    <div class="col-lg-3 col-md-3 col-sm-4">
                                        <div class="border border-primary rounded p-3 bg-white shadow-sm">
                                            <h6 class="text-primary text-center">Select Plugins Category</h6>
                                            <div id="pluginCategoriesContainer">
                                                <p class="text-muted">No categories available yet.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Plugin List Container -->
                                    <div class="col-lg-5 col-md-5 col-sm-8">
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
                                                <p class="text-muted">No Theme selected yet.</p>
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
                                                        <p id="user_name_displayl" class="fw-bold text-muted">
                                                            Loading...</p>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6">
                                                    <div class="mb-2">
                                                        <h6 class="card-title text-danger">
                                                            <i class="bi bi-lock-fill"></i> Password
                                                        </h6>
                                                        <p id="password_displayl" class="fw-bold text-muted">
                                                            Loading...
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
    <div class="modal custom-loader-modal" id="loaderModal" tabindex="-1" aria-labelledby="loaderModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 100%; margin: 0;">
            <div class="modal-content"
                style="background: rgba(255, 255, 255, 0.57); border: none; backdrop-filter: blur(10px);">
                <div class="modal-body d-flex justify-content-center align-items-center flex-column"
                    style="height: 100vh; color: black;">
                    <!-- Dot Floating Loader -->
                    <div class="dot-floating-loader">
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                    </div>
                    <!-- Text -->
                    <p class="mt-3 text-dark loader-text"> Downloading <i class="bi bi-wordpress"></i> . Please
                        wait a moment.</p>
                </div>
            </div>
        </div>
    </div>



    <!-- Tabs for different site statuses -->
    <ul class="nav nav-tabs mb-5" id="siteTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="all-sites-tab" data-bs-toggle="tab" href="#all-sites" role="tab"
                aria-controls="all-sites" aria-selected="true">All Sites</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="running-tab" data-bs-toggle="tab" href="#running" role="tab"
                aria-controls="running" aria-selected="false">Running Sites</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="stopped-tab" data-bs-toggle="tab" href="#stopped" role="tab"
                aria-controls="stopped" aria-selected="false">Stopped Sites</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="deleted-tab" data-bs-toggle="tab" href="#deleted" role="tab"
                aria-controls="deleted" aria-selected="false">Deleted Sites</a>
        </li>

    </ul>

    <div class="tab-content" id="siteTabContent">
        <!-- Running Sites Table -->
        <div class="tab-pane fade" id="running" role="tabpanel" aria-labelledby="running-tab">
            <div class="card">
                <div class="card-header mb-2 table_headercolor text-white">
                    <h5 class="mb-0">Running Sites</h5>
                </div>
                <div class="card-body">
                    <table id="runningTable" class="table table-striped table-bordered" style="width: 100%">
                        <thead>
                            <tr>
                                <th class="bg-info text-white">Site Name</th>
                                <th class="bg-info text-white">Subscription Type</th>
                                <th class="bg-info text-white">Pack Type </th>
                                <th class="bg-info text-white">Remaining Days</th>
                                <th class="bg-info text-white">Site Status</th>
                                <th class="bg-info text-white">Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Stopped Sites Table -->
        <div class="tab-pane fade" id="stopped" role="tabpanel" aria-labelledby="stopped-tab">
            <div class="card">
                <div class="card-header mb-2 table_headercolor text-white">
                    <h5 class="mb-0">Stopped Sites</h5>
                </div>
                <div class="card-body">
                    <table id="stoppedTable" class="table table-striped table-bordered" style="width: 100%">
                        <thead>
                            <tr>
                                <th class="bg-info text-white">Site Name</th>
                                <th class="bg-info text-white">Subscription Type</th>
                                <th class="bg-info text-white">Pack Type </th>
                                <th class="bg-info text-white">Remaining Days</th>
                                <th class="bg-info text-white">Site Status</th>
                                <th class="bg-info text-white">Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- DELETED Sites Table -->
        <div class="tab-pane fade" id="deleted" role="tabpanel" aria-labelledby="deleted-tab">
            <div class="card">
                <div class="card-header mb-2 table_headercolor text-white">
                    <h5 class="mb-0">DELETED Sites</h5>
                </div>
                <div class="card-body">
                    <table id="deletedTable" class="table table-striped table-bordered" style="width: 100%">
                        <thead>
                            <tr>
                                <th class="bg-info text-white">Site Name</th>
                                <th class="bg-info text-white">Subscription Type</th>
                                <th class="bg-info text-white">Pack Type </th>
                                <th class="bg-info text-white">Remaining Days</th>
                                <th class="bg-info text-white">Site Status</th>
                                <th class="bg-info text-white">Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- All Sites Table (Including Running, Stopped, DELETED) -->
        <div class="tab-pane fade show active" id="all-sites" role="tabpanel" aria-labelledby="all-sites-tab">
            <div class="card">
                <div class="card-header mb-2 table_headercolor text-white">
                    <h5 class="mb-0">All Sites</h5>
                </div>
                <div class="card-body">
                    <table id="allSitesTable" class="table table-striped table-bordered" style="width: 100%">
                        <thead>
                            <tr>
                                <th class="bg-info text-white">Site Name</th>
                                <th class="bg-info text-white">Subscription Type</th>
                                <th class="bg-info text-white">Pack Type </th>
                                <th class="bg-info text-white">Remaining Days</th>
                                <th class="bg-info text-white">Site Status</th>
                                <th class="bg-info text-white">Actions</th>
                                <th class="bg-info text-white">Storage Usage</th>

                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {{-- Configure PHP MODEL --}}

    <div class="modal fade" id="phpConfigModal" tabindex="-1" aria-labelledby="phpConfigModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="phpConfigModalLabel">PHP Config</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">Configure your PHP settings and limits.</p>
                    <form>
                        <div class="row g-3  pt-3">
                            <div class="col-md-6">
                                <label class="form-label">Php Version</label>
                                <input type="text" class="form-control" name="php_version" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">max_execution_time (seconds)</label>
                                <input type="number" class="form-control" name="max_execution_time">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">max_input_time (seconds)</label>
                                <input type="number" class="form-control" name="max_input_time">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label ">pm_max_children</label>

                                <input type="number" class="form-control" name="pm_max_children" value="0">

                            </div>
                        </div>
                        <div class="row g-3  pt-3">
                            <div class="col-md-6">
                                <label class="form-label">max_input_vars</label>
                                <input type="number" class="form-control" name="max_input_vars">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">memory_limit (mb)</label>
                                <input type="number" class="form-control" name="memory_limit">
                            </div>
                        </div>
                        <div class="row g-3  pt-3">
                            <div class="col-md-6">
                                <label class="form-label">post_max_size (mb)</label>
                                <input type="number" class="form-control" name="post_max_size">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">upload_max_filesize (mb)</label>
                                <input type="number" class="form-control" name="upload_max_filesize">
                            </div>
                        </div>
                        <div class="row g-3  pt-3">
                            <div class="col-md-6">
                                <label class="form-label">session.gc_maxlifetime (seconds)</label>
                                <input type="number" class="form-control" name="session_gc_maxlifetime">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">output_buffering (bytes)</label>
                                <input type="number" class="form-control" name="output_buffering">
                            </div>
                        </div>
                        <div class="row g-3 pt-3">
                            <div class="col-md-6">
                                <label class="form-label" for="allow_url_fopen">Allow URL fopen</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="allow_url_fopen"
                                        name="allow_url_fopen">

                                </div>
                            </div>
                        </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Login Details -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow-lg">
            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="loginModalLabel">
                    <i class="bi bi-person-circle"></i> Login Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <div class="container">

                    <!-- Login URL Section -->
                    <div class="mb-4">
                        <h6 class="card-title text-primary">
                            <i class="bi bi-link-45deg"></i> Login URL
                        </h6>
                        <p id="login_url_display">
                            <a href="#" target="_blank" class="text-decoration-none text-primary fw-bold">
                                <i class="bi bi-box-arrow-up-right"></i> Click here to login
                            </a>
                        </p>
                    </div>

                    <!-- Username and Password Section -->
                    <div class="row justify-content-between">
                        <div class="col-md-5 mb-3">
                            <h6 class="card-title text-success">
                                <i class="bi bi-person-fill"></i> Username
                            </h6>
                            <p id="user_name_display" class="fw-bold text-muted">Loading...</p>
                        </div>
                        <div class="col-md-5 mb-3">
                            <h6 class="card-title text-danger">
                                <i class="bi bi-lock-fill"></i> Password
                            </h6>
                            <p id="password_display" class="fw-bold text-muted">Loading...</p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>





<script>
    $(document).ready(function() {
        let allSitesData = [];

        // Fetch all site data once
        $.ajax({
            url: '/sites-data',
            method: 'GET',
            success: function(data) {
                allSitesData = data; // Store all data
                initializeTables();



            }
        });

        function getSubscriptionPeriod(startDate, endDate) {
            const start = new Date(startDate);
            const end = new Date(endDate);

            const diffMonths = (end.getFullYear() - start.getFullYear()) * 12 + (end.getMonth() - start
                .getMonth());

            // If difference is around 12 months, treat it as yearly, otherwise as monthly
            return diffMonths >= 12 ? "Yearly" : "Monthly";
        }

        function calculateRemainingTime(endDate) {
            const now = new Date();
            const end = new Date(endDate);
            const diffMs = end - now;

            if (diffMs <= 0) {
                return "Expired";
            }

            const daysInMonth = getDaysInMonth(end.getMonth(), end.getFullYear());
            const days = Math.floor(diffMs / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diffMs % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diffMs % (1000 * 60 * 60)) / (1000 * 60));

            return `${days} days, ${hours} hours, ${minutes} minutes remaining`;

            // Function to determine the number of days in a specific month of a year
            function getDaysInMonth(month, year) {
                // February (Month 1) - check if it's a leap year
                if (month === 1) {
                    return (year % 4 === 0 && (year % 100 !== 0 || year % 400 === 0)) ? 29 : 28;
                }
                // April, June, September, November (Month 3, 5, 8, 10) - 30 days
                else if (month === 3 || month === 5 || month === 8 || month === 10) {
                    return 30;
                }
                // All other months - 31 days
                return 31;
            }
        }


        function formatSiteData(sites, status) {
            return sites.map(siteData => {
                const formattedData = {
                    site_name: siteData.site.site_name,
                    subscription_type: siteData.subscription_type,
                    storage_usage: siteData.storage_usage,
                    start_end_date: getSubscriptionPeriod(siteData.start_date, siteData.end_date),
                    status: status,
                    actionButtons: generateActionButtons(status)
                };

                // Add remaining_time only if the status is not 'Running'
                if (status !== 'Running') {
                    formattedData.remaining_time = calculateRemainingTime(siteData.end_date);
                }

                return formattedData;
            });
        }


        function initializeTables() {
            function formatSiteData(sites, status) {
                return sites.map(siteData => {
                    // Calculate the remaining time
                    let remainingTime = calculateRemainingTime(siteData.end_date);

                    // If the status is 'DELETED', override remaining_time
                    if (status === 'DELETED') {
                        remainingTime = "Site has been deleted";
                    }

                    return {
                        site_name: siteData.site.site_name,
                        subscription_type: siteData.subscription_type,
                        storage_usage: siteData.storage_usage,
                        start_end_date: getSubscriptionPeriod(siteData.start_date, siteData.end_date),
                        remaining_time: remainingTime, // Use the updated remaining time
                        status: status,
                        actionButtons: generateActionButtons(status, siteData.subscription_status)
                    };
                });
            }

            // Running Sites DataTable
            $('#runningTable').DataTable({
                processing: true,
                serverSide: false,
                data: formatSiteData(Object.values(allSitesData.RUNNING), 'Running'),
                columns: [{
                        data: 'site_name'
                    },
                    {
                        data: 'subscription_type'
                    },
                    {
                        data: 'start_end_date'
                    },
                    {
                        data: 'remaining_time'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'actionButtons',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Stopped Sites DataTable
            $('#stoppedTable').DataTable({
                processing: true,
                serverSide: false,
                data: formatSiteData(Object.values(allSitesData.STOP), 'Stopped'),
                columns: [{
                        data: 'site_name'
                    },
                    {
                        data: 'subscription_type'
                    },
                    {
                        data: 'start_end_date'
                    },
                    {
                        data: 'remaining_time'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'actionButtons',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // DELETED Sites DataTable
            $('#deletedTable').DataTable({
                processing: true,
                serverSide: false,
                data: formatSiteData(Object.values(allSitesData.DELETED), 'DELETED'),
                columns: [{
                        data: 'site_name'
                    },
                    {
                        data: 'subscription_type'
                    },
                    {
                        data: 'start_end_date'
                    },
                    {
                        data: 'remaining_time'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'actionButtons',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // All Sites DataTable (combined)
            $('#allSitesTable').DataTable({
                processing: true,
                serverSide: false,
                data: [
                    ...formatSiteData(Object.values(allSitesData.RUNNING), 'Running'),
                    ...formatSiteData(Object.values(allSitesData.STOP), 'Stopped'),
                    ...formatSiteData(Object.values(allSitesData.DELETED), 'DELETED')
                ],
                columns: [{
                        data: 'site_name'
                    },
                    {
                        data: 'subscription_type'
                    },
                    {
                        data: 'start_end_date'
                    },
                    {
                        data: 'remaining_time'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'actionButtons',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'storage_usage',

                    }
                ]
            });

            // Update remaining time every minute
            setInterval(() => {
                $('#runningTable, #stoppedTable, #deletedTable, #allSitesTable').DataTable().rows()
                    .every(function() {
                        const data = this.data();
                        data.remaining_time = calculateRemainingTime(data.end_date);
                        this.data(data);
                    }).draw(false);
            }, 60000); // Refresh every 60 seconds
        }

        function generateActionButtons(status, subscriptionStatus) {

            if (subscriptionStatus === '0') {
                return `
                       <div class="btn-actions">
                             <div class="btn-group dropend">
                                    <button type="button" class="btn btn-outline-primary">
                                        <i class="bi bi-arrow-repeat" style="font-size: 1em;"></i>  Session Has Been Expired
                                    </button>
                                </div>
                        </div>
                    `;
            }
            if (status === 'DELETED') {
                return `
            <div class="btn-actions">
                <div class="btn-group dropend">
                    <button type="button" class="btn btn-outline-secondary" disabled>
                        <i class="bi bi-archive" style="font-size: 1em;"></i> Site has been deleted
                    </button>
                </div>
            </div>
        `;
            }

            if (status === 'Running') {
                return `
            <div class="btn-actions">
                <div class="btn-group dropend">
                    <button type="button" class="btn btn-outline-secondary" title="Magical Login">
                        <i class="bi bi-box-arrow-in-right" style="font-size: 1em;"></i>
                    </button>
                    <button type="button" class="btn btn-outline-warning" title="Stop" id="stop-btn">
                        <i class="bi bi-stop-circle" style="font-size: 1em;"></i>
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-delete" title="Delete">
                        <i class="bi bi-trash" style="font-size: 1em;"></i>
                    </button>
                    <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu mt-5">
                        <li>
                            <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#phpConfigModal">
                                <i class="fab fa-php" style="font-size: 1.25rem; color: #8A2BE2;"></i> PHP Config
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item login-detail" type="button">
                                <i class="bi bi-file-earmark-text" style="font-size: 1.25rem;"></i> Login Details
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        `;
            }

            if (status === 'Stopped') {
                return `
            <div class="btn-actions">
                <div class="btn-group dropend">
                    <button type="button" class="btn btn-outline-primary" title="Run" id="run-btn">
                        <i class="bi bi-play-circle" style="font-size: 1em;"></i> Run
                    </button>
                    <span class="text-muted ms-2">Click on RUN to RESUME SITE</span>
                </div>
            </div>
        `;
            }
        }


        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            const row = $(this).closest('tr'); // Get the row containing the clicked button
            const siteName = row.find('td').first()
                .text(); // Get the site name (first column of the row)

            // Flatten allSitesData into a single array
            const allSitesArray = [
                ...Object.values(allSitesData.RUNNING),
                ...Object.values(allSitesData.STOP),
                ...Object.values(allSitesData.DELETED)
            ];

            // Find the site object based on the siteName
            const site = allSitesArray.find(s => s.site.site_name === siteName);

            if (site) {
                const siteId = site.site.id; // Get the site ID from the matched site object
                console.log('Site ID:', siteId); // Log the site ID for confirmation

                // Show a confirmation dialog
                Swal.fire({
                    title: `Are you sure you want to delete the site: ${siteName}?`,
                    text: "Please Confirm Once's.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Make the AJAX request to delete the site using siteId
                        $.ajax({
                            url: '/delete-site/' + siteId, // Pass the siteId in the URL
                            type: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr(
                                    'content'), // CSRF token
                            },
                            success: function(response) {
                                Swal.fire('DELETED!', 'The site has been deleted.',
                                    'success');
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);
                            },
                            error: function(xhr, status, error) {
                                Swal.fire('Error!',
                                    'There was an error deleting the site.',
                                    'error');
                            }
                        });
                    }
                });
            } else {
                console.log('Site not found');
            }
        });

        $(document).on('click', '.login-detail', function(e) {
            const row = $(this).closest('tr'); // Get the row containing the clicked button
            const siteName = row.find('td').first()
                .text(); // Get the site name (first column of the row)

            // Assuming that `allSitesData` is accessible and contains the sites info
            const allSitesArray = [
                ...Object.values(allSitesData.RUNNING),
                ...Object.values(allSitesData.STOP),
                ...Object.values(allSitesData.DELETED)
            ];

            // Find the specific site object from the array
            const site = allSitesArray.find(site => site.site.site_name === siteName);

            if (site) {
                const userName = site.site.user_name;
                const password = site.site.password;
                const loginUrl = site.site.login_url;

                // Update modal with data
                $('#login_url_display a')
                    .attr('href', loginUrl + '/wp-login.php')
                    .text(loginUrl + '/wp-login.php');
                $('#user_name_display').text(userName);
                $('#password_display').text(password);

                // Show the modal
                $('#loginModal').modal('show');
            } else {
                alert('Site not found!');
            }
        });



        $(document).on('click', '#stop-btn', function(e) {
            e.preventDefault();
            const row = $(this).closest('tr'); // Get the row containing the clicked button
            const siteName = row.find('td').first()
                .text(); // Get the site name (first column of the row)

            // Flatten allSitesData into a single array
            const allSitesArray = [
                ...Object.values(allSitesData.RUNNING),
                ...Object.values(allSitesData.STOP),
                ...Object.values(allSitesData.DELETED)
            ];

            // Find the site object based on the siteName
            const site = allSitesArray.find(s => s.site.site_name === siteName);

            if (site) {
                const siteId = site.site.id;
                console.log('Site ID:', siteId);

                // AJAX call to send the site ID to the backend
                $.ajax({
                    url: '/stop-site', // Change to your actual route
                    type: 'POST',
                    data: {
                        id: siteId,
                        _token: $('meta[name="csrf-token"]').attr(
                            'content') // Include CSRF token if needed
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            confirmButtonText: 'OK'
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 1000);


                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.error || 'An error occurred',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Site not found',
                    text: 'The specified site could not be found.',
                    confirmButtonText: 'OK'
                });
            }
        });


        $(document).on('click', '#run-btn', function(e) {
            e.preventDefault();
            const row = $(this).closest('tr'); // Get the row containing the clicked button
            const siteName = row.find('td').first()
                .text(); // Get the site name (first column of the row)

            // Flatten allSitesData into a single array
            const allSitesArray = [
                ...Object.values(allSitesData.RUNNING),
                ...Object.values(allSitesData.STOP),
                ...Object.values(allSitesData.DELETED)
            ];

            // Find the site object based on the siteName
            const site = allSitesArray.find(s => s.site.site_name === siteName);

            if (site) {
                const siteId = site.site.id;
                console.log('Site ID:', siteId);

                // AJAX call to send the site ID to the backend
                $.ajax({
                    url: '/resume-site', // Change to your actual route
                    type: 'POST',
                    data: {
                        id: siteId,
                        _token: $('meta[name="csrf-token"]').attr(
                            'content') // Include CSRF token if needed
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            confirmButtonText: 'OK'
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 1000);

                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.error || 'An error occurred',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Site not found',
                    text: 'The specified site could not be found.',
                    confirmButtonText: 'OK'
                });
            }
        });



    });
</script>
<script>
    $(document).ready(function() {
        // Fetch PHP configuration when the modal is opened
        $('#phpConfigModal').on('show.bs.modal', function() {
            $.ajax({
                url: '/php-config',
                method: 'GET',
                success: function(data) {
                    $('[name="max_execution_time"]').val(data.max_execution_time);
                    $('[name="php_version"]').val(data.php_version);
                    $('[name="max_input_time"]').val(data.max_input_time);
                    $('[name="max_input_vars"]').val(data.max_input_vars);
                    $('[name="memory_limit"]').val(data.memory_limit.replace('M', ''));
                    $('[name="post_max_size"]').val(data.post_max_size.replace('M', ''));
                    $('[name="upload_max_filesize"]').val(data.upload_max_filesize.replace(
                        'M', ''));
                    $('[name="session_gc_maxlifetime"]').val(data.session_gc_maxlifetime);
                    $('[name="pm_max_children"]').val(data.pm_max_children);
                    $('[name="output_buffering"]').val(data.output_buffering);
                    $('.form-check-input').prop('checked', data.allow_url_fopen === "1");
                },
                error: function() {
                    alert('Failed to fetch PHP configuration.');
                }
            });
        });


    });
</script>
@endsection