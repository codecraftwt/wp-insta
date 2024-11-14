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
                    aria-controls="deleted" aria-selected="false">DELETED Sites</a>
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
                                    <th class="bg-info text-white">Remaining Days</th>
                                    <th class="bg-info text-white">Actions</th>
                                    <th class="bg-info text-white">Actions</th>
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
                                    <th class="bg-info text-white">Remaining Days</th>
                                    <th class="bg-info text-white">Actions</th>
                                    <th class="bg-info text-white">Actions</th>
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
                                    <th class="bg-info text-white">Remaining Days</th>
                                    <th class="bg-info text-white">Actions</th>
                                    <th class="bg-info text-white">Actions</th>
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
                                    <th class="bg-info text-white">Remaining Days</th>
                                    <th class="bg-info text-white">Actions</th>
                                    <th class="bg-info text-white">Actions</th>
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
                            <div class="row g-3 border-top pt-3">
                                <div class="col-md-6">
                                    <label class="form-label">PHP Version</label>
                                    <select class="form-select" style="max-width: 120px;">
                                        <option>8.0</option>
                                        <option>7.4</option>
                                        <option>7.3</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">max_execution_time (seconds)</label>
                                    <input type="number" class="form-control" value="120">
                                </div>
                            </div>

                            <div class="row g-3 border-top pt-3">
                                <div class="col-md-6">
                                    <label class="form-label">max_input_time (seconds)</label>
                                    <input type="number" class="form-control" value="60">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">max_input_vars</label>
                                    <input type="number" class="form-control" value="5000">
                                </div>
                            </div>

                            <div class="row g-3 border-top pt-3">
                                <div class="col-md-6">
                                    <label class="form-label">memory_limit (mb)</label>
                                    <input type="number" class="form-control" value="128">
                                </div>
                                <div class="col-md-6 ">
                                    <label class="form-label me-3 mb-0">allow_url_fopen</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" checked>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 border-top pt-3">
                                <div class="col-md-6">
                                    <label class="form-label">post_max_size (mb)</label>
                                    <input type="number" class="form-control" value="256">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">upload_max_filesize (mb)</label>
                                    <input type="number" class="form-control" value="256">
                                </div>
                            </div>

                            <div class="row g-3 border-top pt-3">
                                <div class="col-md-6">
                                    <label class="form-label">session.gc_maxlifetime (seconds)</label>
                                    <input type="number" class="form-control" value="1440">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">output_buffering (bytes)</label>
                                    <input type="number" class="form-control" value="4096">
                                </div>
                            </div>

                            <div class="row g-3 border-top pt-3">
                                <div class="col-md-6">
                                    <label class="form-label">pm.max_children (PHP worker)</label>
                                    <input type="number" class="form-control" value="2">
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



    {{-- <script>
        $(document).ready(function() {
            let allSitesData = [];

            // Fetch all site data once
            $.ajax({
                url: '{{ route('sites-data') }}',
                method: 'GET',
                success: function(data) {
                    allSitesData = data; // Store all data
                    initializeTables();
                }
            });

            function initializeTables() {
                // Running Sites DataTable
                $('#runningTable').DataTable({
                    processing: true,
                    serverSide: false,
                    data: Object.values(allSitesData.RUNNING).map(siteData => {

                        return {
                            site_name: siteData.site.site_name,
                            subscription_type: siteData.subscription_type,
                            start_date: siteData.start_date,
                            end_date: siteData.end_date,

                            status: 'Running'
                        };
                    }),
                    columns: [{
                            data: 'site_name'
                        },
                        {
                            data: 'subscription_type'
                        },
                        {
                            data: 'start_date'
                        },
                        {
                            data: 'end_date'
                        },

                        {
                            data: 'status'
                        }
                    ]
                });

                // Stopped Sites DataTable
                $('#stoppedTable').DataTable({
                    processing: true,
                    serverSide: false,
                    data: Object.values(allSitesData.STOP).map(siteData => ({
                        site_name: siteData.site.site_name,
                        subscription_type: siteData.subscription_type,
                        start_date: siteData.start_date,
                        end_date: siteData.end_date,
                        // No remaining time for stopped sites
                        status: 'Stopped'
                    })),
                    columns: [{
                            data: 'site_name'
                        },
                        {
                            data: 'subscription_type'
                        },
                        {
                            data: 'start_date'
                        },
                        {
                            data: 'end_date'
                        },

                        {
                            data: 'status'
                        }
                    ]
                });

                // DELETED Sites DataTable
                $('#deletedTable').DataTable({
                    processing: true,
                    serverSide: false,
                    data: allSitesData.DELETED.map(siteData => ({
                        site_name: siteData.site.site_name,
                        subscription_type: siteData.subscription_type,
                        start_date: siteData.start_date,
                        end_date: siteData.end_date,
                        // No remaining time for deleted sites
                        status: 'DELETED'
                    })),
                    columns: [{
                            data: 'site_name'
                        },
                        {
                            data: 'subscription_type'
                        },
                        {
                            data: 'start_date'
                        },
                        {
                            data: 'end_date'
                        },

                        {
                            data: 'status'
                        }
                    ]
                });

                // All Sites DataTable (combined)
                $('#allSitesTable').DataTable({
                    processing: true,
                    serverSide: false,
                    data: [
                        ...Object.values(allSitesData.RUNNING).map(siteData => {

                            return {
                                site_name: siteData.site.site_name,
                                subscription_type: siteData.subscription_type,
                                start_date: siteData.start_date,
                                end_date: siteData.end_date,

                                status: 'Running'
                            };
                        }),
                        ...Object.values(allSitesData.STOP).map(siteData => ({
                            site_name: siteData.site.site_name,
                            subscription_type: siteData.subscription_type,
                            start_date: siteData.start_date,
                            end_date: siteData.end_date,

                            status: 'Stopped'
                        })),
                        ...allSitesData.DELETED.map(siteData => ({
                            site_name: siteData.site.site_name,
                            subscription_type: siteData.subscription_type,
                            start_date: siteData.start_date,
                            end_date: siteData.end_date,

                            status: 'DELETED'
                        }))
                    ],
                    columns: [{
                            data: 'site_name'
                        },
                        {
                            data: 'subscription_type'
                        },
                        {
                            data: 'start_date'
                        },
                        {
                            data: 'end_date'
                        },

                        {
                            data: 'status'
                        }
                    ]
                });
            }
        });
    </script> --}}

    <script>
        $(document).ready(function() {
            let allSitesData = [];

            // Fetch all site data once
            $.ajax({
                url: '{{ route('sites-data') }}',
                method: 'GET',
                success: function(data) {
                    allSitesData = data; // Store all data
                    initializeTables();



                }
            });

            function initializeTables() {


                // Running Sites DataTable
                $('#runningTable').DataTable({
                    processing: true,
                    serverSide: false,
                    data: Object.values(allSitesData.RUNNING).map(siteData => {
                        return {
                            site_name: siteData.site.site_name,
                            subscription_type: siteData.subscription_type,
                            start_date: siteData.start_date,
                            end_date: siteData.end_date,
                            status: 'Running',
                            actionButtons: generateActionButtons(
                                'Running') // Call function to generate buttons
                        };
                    }),
                    columns: [{
                            data: 'site_name'
                        },
                        {
                            data: 'subscription_type'
                        },
                        {
                            data: 'start_date'
                        },
                        {
                            data: 'end_date'
                        },
                        {
                            data: 'status'
                        },
                        {
                            data: 'actionButtons',
                            orderable: false,
                            searchable: false
                        } // Add action buttons column
                    ]
                });

                // Stopped Sites DataTable
                $('#stoppedTable').DataTable({
                    processing: true,
                    serverSide: false,
                    data: Object.values(allSitesData.STOP).map(siteData => ({
                        site_name: siteData.site.site_name,
                        subscription_type: siteData.subscription_type,
                        start_date: siteData.start_date,
                        end_date: siteData.end_date,
                        status: 'Stopped',
                        actionButtons: generateActionButtons('Stopped')
                    })),
                    columns: [{
                            data: 'site_name'
                        },
                        {
                            data: 'subscription_type'
                        },
                        {
                            data: 'start_date'
                        },
                        {
                            data: 'end_date'
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

                // Ensure DELETED is an array before mapping it
                const deletedSites = Array.isArray(allSitesData.DELETED) ? allSitesData.DELETED : Object.values(
                    allSitesData.DELETED);

                console.log(deletedSites);

                // DELETED Sites DataTable
                $('#deletedTable').DataTable({
                    processing: true,
                    serverSide: false,
                    data: deletedSites.map(siteData => ({
                        site_name: siteData.site.site_name,
                        subscription_type: siteData.subscription_type,
                        start_date: siteData.start_date,
                        end_date: siteData.end_date,
                        status: 'DELETED',
                        actionButtons: generateActionButtons(
                            'DELETED') // This will disable the action buttons
                    })),
                    columns: [{
                            data: 'site_name'
                        },
                        {
                            data: 'subscription_type'
                        },
                        {
                            data: 'start_date'
                        },
                        {
                            data: 'end_date'
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
                        ...Object.values(allSitesData.RUNNING).map(siteData => ({
                            site_name: siteData.site.site_name,
                            subscription_type: siteData.subscription_type,
                            start_date: siteData.start_date,
                            end_date: siteData.end_date,
                            status: 'Running',
                            actionButtons: generateActionButtons('Running')
                        })),
                        ...Object.values(allSitesData.STOP).map(siteData => ({
                            site_name: siteData.site.site_name,
                            subscription_type: siteData.subscription_type,
                            start_date: siteData.start_date,
                            end_date: siteData.end_date,
                            status: 'Stopped',
                            actionButtons: generateActionButtons('Stopped')
                        })),
                        ...deletedSites.map(siteData => ({
                            site_name: siteData.site.site_name,
                            subscription_type: siteData.subscription_type,
                            start_date: siteData.start_date,
                            end_date: siteData.end_date,
                            status: 'DELETED',
                            actionButtons: generateActionButtons('DELETED')
                        }))
                    ],
                    columns: [{
                            data: 'site_name'
                        },
                        {
                            data: 'subscription_type'
                        },
                        {
                            data: 'start_date'
                        },
                        {
                            data: 'end_date'
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
            }
            // Function to generate action buttons based on the status of the site
            function generateActionButtons(status) {
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
                                <button type="button" class="btn btn-outline-warning" title="Stop">
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
                                        <button class="dropdown-item" type="button">
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
                                <button type="button" class="btn btn-outline-secondary" title="Magical Login">
                                    <i class="bi bi-box-arrow-in-right" style="font-size: 1em;"></i>
                                </button>
                                <button type="button" class="btn btn-outline-primary" title="Run">
                                    <i class="bi bi-play-circle" style="font-size: 1em;"></i>
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
                                        <button class="dropdown-item" type="button">
                                            <i class="bi bi-file-earmark-text" style="font-size: 1.25rem;"></i> Login Details
                                        </button>
                                    </li>
                                </ul>
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
                                    location.reload();
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

        });
    </script>
@endsection
