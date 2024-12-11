@extends('structures.main')

@section('content')
    <div class="container">
        <h1 class="my-4 text-center">Manage Sites</h1>

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
                    <div class="card-header mb-2 bg-primary text-white">
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
                    <div class="card-header mb-2 bg-warning text-dark">
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
                    <div class="card-header mb-2 bg-dark text-white">
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
                    <div class="card-header mb-2 bg-success text-white">
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
