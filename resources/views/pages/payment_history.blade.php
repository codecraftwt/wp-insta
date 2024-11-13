@extends('structures.main')

@section('content')
    <div class="container">
        <h1 class="text-center p-2 mb-4">Payment History</h1>
    </div>

    <!-- Filters Section -->
    <div class="mt-5">
        <div class="card p-3">
            <div class="card-body">
                <div class="row p-2">
                    <!-- First column set (2 columns for filters) -->


                    <div class="col-md-3 mb-3">
                        <label for="filtername" class="form-label">Name</label>
                        <input type="text" class="form-control" id="filtername" aria-describedby="filtername">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="filteremail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="filteremail" aria-describedby="filteremail">
                    </div>
                    <!-- Second column set (2 columns for date filters) -->
                    <div class="col-md-3 mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" aria-describedby="start_date">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date" aria-describedby="end_date">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment History Table Section -->
    <div class="mt-4">
        <div class="card p-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="get-paymenthistory">
                        <thead class="table-primary">
                            <tr>
                                <th>SR</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Amount</th>
                                <th>Payment ID</th>
                                <th>VIEW</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Section -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
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
                        <div class="col-md-6 mb-3">
                            <div class="card border-danger ">
                                <div class="card-body text-center p-3">
                                    <h5 class="text-danger fw-bold"><i class="bi bi-exclamation-circle-fill"></i> Payment
                                        Intent:</h5>
                                    <p class="card-text" id="modalPaymentIntent"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card border-muted ">
                                <div class="card-body text-center p-3">
                                    <h5 class="text-muted fw-bold"><i class="bi bi-calendar-event"></i> Created At:</h5>
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
                                    <h5 class="text-info fw-bold"><i class="bi bi-credit-card-fill"></i> Payment ID:</h5>
                                    <p class="card-text" id="modalPaymentId"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background-color: #f8f9fa;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Section -->
    <script>
        // $(document).ready(function() {
        //     var table = $('#get-paymenthistory').DataTable({
        //         processing: true,
        //         serverSide: false,
        //         ajax: {
        //             url: '/get-paymenthistory', // Use the named route
        //             type: 'GET'
        //         },
        //         columns: [{
        //                 data: null,
        //                 render: (data, type, row, meta) => meta.row + 1
        //             },
        //             {
        //                 data: 'name',
        //                 name: 'name'
        //             },
        //             {
        //                 data: 'email',
        //                 name: 'email'
        //             },
        //             {
        //                 data: 'amount',
        //                 name: 'amount',
        //                 render: function(data, type, row) {
        //                     return '₹' + data; // Prepend '₹' to the amount
        //                 }
        //             },
        //             {
        //                 data: 'payment_id',
        //                 name: 'payment_id'
        //             },
        //             {
        //                 data: null,
        //                 render: function(data, type, row) {
        //                     return `<button class="btn btn-info view-btn" data-id="${row.id}" data-name="${row.name}" data-email="${row.email}" data-amount="${row.amount}" data-payment-id="${row.payment_id}" data-payment-intent="${row.payment_intent}" data-created-at="${row.created_at}" data-status="${row.status}"><i class="fas fa-eye"></i></button>`;
        //                 }
        //             },
        //         ],
        //         order: [
        //             [0, 'asc']
        //         ]
        //     });

        //     // Handle the eye button click event
        //     $('#get-paymenthistory tbody').on('click', '.view-btn', function() {
        //         var name = $(this).data('name');
        //         var email = $(this).data('email');
        //         var amount = $(this).data('amount');
        //         var paymentId = $(this).data('payment-id');
        //         var paymentIntent = $(this).data('payment-intent');
        //         var createdAt = $(this).data('created-at');
        //         var status = $(this).data('status');

        //         // Populate the modal with data
        //         $('#modalName').text(name);
        //         $('#modalEmail').text(email);
        //         $('#modalAmount').text('₹' + amount);
        //         $('#modalPaymentId').text(paymentId);
        //         $('#modalPaymentIntent').text(paymentIntent);
        //         $('#modalCreatedAt').text(createdAt);
        //         $('#modalStatus').text(status);

        //         // Show the modal
        //         var paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
        //         paymentModal.show();
        //     });
        // });

        $(document).ready(function() {
            // Initialize the DataTable
            var table = $('#get-paymenthistory').DataTable({
                processing: true,
                serverSide: false,
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
                    {
                        data: 'payment_id',
                        name: 'payment_id'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `<button class="btn btn-info view-btn" data-id="${row.id}" data-name="${row.name}" data-email="${row.email}" data-amount="${row.amount}" data-payment-id="${row.payment_id}" data-payment-intent="${row.payment_intent}" data-created-at="${row.created_at}" data-status="${row.status}"><i class="fas fa-eye"></i></button>`;
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
                var paymentIntent = $(this).data('payment-intent');
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
                $('#modalPaymentIntent').text(paymentIntent);
                $('#modalCreatedAt').text(formattedCreatedAt); // Use the formatted date
                $('#modalStatus').text(status);

                // Show the modal
                var paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
                paymentModal.show();
            });

        });
    </script>
@endsection
