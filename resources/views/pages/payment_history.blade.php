@extends('structures.main')

@section('content')
    <div class="container">
        <h1 class="text-center p-2 mb-4">Payment History</h1>
    </div>
    <div class="container-fluid px-4 mt-5">
        <div class="card shadow-sm border-light rounded w-100">
            <div class="card-header table_headercolor text-white">
                <h5 class="mb-0">Payment History</h5>
            </div>
            <div class="card-body">
                <!-- Filters Section -->
                <div class="row mb-4 mt-3">
                    <!-- Filter: Name -->
                    <div class="col-md-3 mb-3">
                        <label for="filtername" class="form-label fw-bold">Name</label>
                        <input type="text" class="form-control" id="filtername" placeholder="Enter name">
                    </div>
                    <!-- Filter: Email -->
                    <div class="col-md-3 mb-3">
                        <label for="filteremail" class="form-label fw-bold">Email</label>
                        <input type="email" class="form-control" id="filteremail" placeholder="Enter email">
                    </div>
                    <!-- Filter: Start Date -->
                    <div class="col-md-3 mb-3">
                        <label for="start_date" class="form-label fw-bold">Start Date</label>
                        <input type="date" class="form-control" id="start_date">
                    </div>
                    <!-- Filter: End Date -->
                    <div class="col-md-3 mb-3">
                        <label for="end_date" class="form-label fw-bold">End Date</label>
                        <input type="date" class="form-control" id="end_date">
                    </div>
                </div>

                <!-- Payment History Table Section -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover text-center mt-3" id="get-paymenthistory">
                        <thead class="table-primary">
                            <tr>
                                <th>SR</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Amount</th>
                                @if (auth()->check() && auth()->user()->role && auth()->user()->role->name === 'superadmin')
                                    <th>Payment ID</th>
                                @endif
                                <th>VIEW</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be dynamically populated via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Section -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content shadow-lg rounded-3 border border-primary">
                <div class="modal-header" style="background: linear-gradient(90deg, #007bff, #6f42c1); color: white;">
                    <h5 class="modal-title" id="paymentModalLabel">Payment Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Modal Info Cards -->
                        <div class="col-md-6 mb-3">
                            <div class="card border-primary ">
                                <div class="card-body text-center p-3">
                                    <h5 class="text-primary fw-bold"><i class="bi bi-person-fill"></i> Name:</h5>
                                    <p class="card-text" id="modalName"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card border-success ">
                                <div class="card-body text-center p-3">
                                    <h5 class="text-success fw-bold"><i class="bi bi-envelope-fill"></i> Email:</h5>
                                    <p class="card-text" id="modalEmail"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card border-warning ">
                                <div class="card-body text-center p-3">
                                    <h5 class="text-warning fw-bold"><i class="bi bi-cash-coin"></i> Amount:</h5>
                                    <p class="card-text fw-bold" id="modalAmount"></p>
                                </div>
                            </div>
                        </div>
                        @if (auth()->check() && auth()->user()->role && auth()->user()->role->name === 'superadmin')
                            <div class="col-md-6 mb-3">
                                <div class="card border-danger ">
                                    <div class="card-body text-center p-3">
                                        <h5 class="text-danger fw-bold"><i class="bi bi-exclamation-circle-fill"></i>
                                            Subscription ID:</h5>
                                        <p class="card-text" id="SubscriptionID"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card border-muted ">
                                    <div class="card-body text-center p-3">
                                        <h5 class="text-muted fw-bold"><i class="bi bi-calendar-event"></i> Created Date:
                                        </h5>
                                        <p class="card-text" id="modalCreatedAt"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card border-dark ">
                                    <div class="card-body text-center p-3">
                                        <h5 class="text-dark fw-bold"><i class="bi bi-check-circle-fill"></i> Status:</h5>
                                        <p class="card-text" id="modalStatus"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="card border-info ">
                                    <div class="card-body text-center p-3">
                                        <h5 class="text-info fw-bold"><i class="bi bi-credit-card-fill"></i> Payment ID:
                                        </h5>
                                        <p class="card-text" id="modalPaymentId"></p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer" style="background-color: #f8f9fa;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <style>
        table th,
        table td {
            border: 2px solid #23bcf9;
            /* Sky blue border */
            padding: 12px;
            /* Padding for cells */
        }

        table th {
            background-color: #87CEEB;
            /* Header background color */
            color: #fff;
            /* Header text color */
        }

        table td {
            background-color: #E0F7FA;
            /* Light blue background for table rows */
            vertical-align: middle;
            /* Center table cell content */
        }
    </style>

    <!-- Script Section -->
    <script>
        $(document).ready(function() {
            // Initialize the DataTable
            var table = $('#get-paymenthistory').DataTable({
                processing: true,
                serverSide: false,
                searching: false,
                ajax: {
                    url: '/get-paymenthistory', // The endpoint to fetch data
                    type: 'GET',
                    data: function(d) {
                        // Send additional filters as parameters
                        d.name = $('#filtername').val(); // Name filter
                        d.email = $('#filteremail').val(); // Email filter
                        d.start_date = $('#start_date').val(); // Start date filter
                        d.end_date = $('#end_date').val(); // End date filter
                    }
                },
                columns: [{
                        data: null,
                        render: (data, type, row, meta) => meta.row + 1
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'amount',
                        name: 'amount',
                        render: function(data, type, row) {
                            return '₹' + data; // Prepend '₹' to the amount
                        }
                    },
                    @if (auth()->check() && auth()->user()->role && auth()->user()->role->name === 'superadmin')
                        {
                            data: 'payment_id',
                            name: 'payment_id'
                        },
                    @endif {
                        data: null,
                        render: function(data, type, row) {
                            return `<button class="btn btn-info view-btn" data-id="${row.id}" data-name="${row.name}" data-email="${row.email}" data-amount="${row.amount}" data-payment-id="${row.payment_id}" data-subscription-id="${row.payment_intent}" data-created-at="${row.created_at}" data-status="${row.status}"><i class="fas fa-eye"></i></button>`;
                        }
                    },
                ],
                order: [
                    [0, 'asc']
                ]
            });

            // Handle filter input change
            $('#filtername, #filteremail, #start_date, #end_date').on('change', function() {
                table.ajax.reload(); // Reload the table with filters
            });

            // Handle the eye button click event
            $('#get-paymenthistory tbody').on('click', '.view-btn', function() {
                var name = $(this).data('name');
                var email = $(this).data('email');
                var amount = $(this).data('amount');
                var paymentId = $(this).data('payment-id');
                var subscriptionId = $(this).data('subscription-id');
                var createdAt = $(this).data('created-at');
                var status = $(this).data('status');

                // Format the 'createdAt' date to 'DD-MM-YYYY'
                var formattedCreatedAt = new Date(createdAt).toLocaleDateString(
                    'en-GB'); // 'en-GB' format is DD/MM/YYYY

                // Populate the modal with data
                $('#modalName').text(name);
                $('#modalEmail').text(email);
                $('#modalAmount').text('₹' + amount);
                $('#modalPaymentId').text(paymentId);
                $('#SubscriptionID').text(subscriptionId);
                $('#modalCreatedAt').text(formattedCreatedAt); // Use the formatted date
                $('#modalStatus').text(status);

                // Show the modal
                var paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
                paymentModal.show();
            });

        });
    </script>
@endsection
