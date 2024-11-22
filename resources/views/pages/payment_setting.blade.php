@extends('structures.main')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Payment Configuration</h1>
    </div>
    @if (Auth::user()->hasPermission('PAYMENT Configuration Create'))
        <button type="button" id="addpc" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#Plugin_Categories_Modal">
            <i class="bi bi-person-plus-fill"></i> Add Payment Configuration
        </button>
    @endif
    <div class="modal fade" id="Plugin_Categories_Modal" tabindex="-1" aria-labelledby="Plugin_Categories_ModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 rounded shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="Plugin_Categories_ModalLabel">Add Payment KEY</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="payment_keys" method="POST" action="{{ url('/payment-setting') }}">
                    @csrf
                    <input type="hidden" name="id" id="categoryId">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="stripe_key" class="form-label">STRIPE KEY</label>
                            <input type="text" class="form-control" id="stripe_key" name="stripe_key" required
                                placeholder="Enter Stripe Key" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="stripe_secret" class="form-label">STRIPE SECRET</label>
                            <input type="text" class="form-control" id="stripe_secret" name="stripe_secret" required
                                placeholder="Enter Stripe Secret" autocomplete="off">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="categorysave" class="btn btn-primary">Save Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Payment Setting List</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" style="width: 100%;"
                        id="payment_setting_table">
                        <thead class="table-primary">
                            <tr>
                                <th>SR</th>
                                <th>Stripe Key</th>
                                <th>Stripe Secret</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom styles for table */
        #payment_setting_table {
            border: 1px solid #007bff;
            border-radius: 0.25rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        #payment_setting_table thead th {
            background-color: #007bff;
            color: white;
        }

        .btn-link {
            color: #007bff;
        }

        .btn-link:hover {
            text-decoration: underline;
        }

        .view-more {
            padding: 0;

            border: none;

            background: transparent;

            cursor: pointer;

        }

        .bi-eye,
        .bi-eye-slash {
            font-size: 1.5rem;
            /* Increased icon size */
        }
    </style>

    <script>
        const hasPAYMENTConfigurationDelete = @json(Auth::user()->hasPermission('PAYMENT Configuration Delete'));
    </script>


    <script>
        $(document).ready(function() {
            var paymenttable = $('#payment_setting_table').DataTable({
                ajax: {
                    url: "/getpaymentsetting",
                    dataSrc: 'data'
                },
                columns: [{
                        data: null,
                        render: (data, type, row, meta) => meta.row + 1
                    },
                    {
                        data: 'stripe_key',
                        render: function(data) {
                            return data.length > 9 ?
                                `<span class="truncated">${data.substring(0, 9)}...</span> 
                        <button class="btn btn-link view-more" data-key="${data}">
                            <i class="bi bi-eye text-success"></i>
                        </button>
                        <div class="full-key" style="display:none;">${data}</div>` :
                                data;
                        }
                    },
                    {
                        data: 'stripe_secret',
                        render: function(data) {
                            return data.length > 9 ?
                                `<span class="truncated">${data.substring(0, 9)}...</span> 
                        <button class="btn btn-link view-more" data-secret="${data}">
                            <i class="bi bi-eye text-success"></i>
                        </button>
                        <div class="full-secret" style="display:none;">${data}</div>` :
                                data;
                        }
                    },
                    {
                        data: 'status',
                        render: function(data, type, row) {
                            const isChecked = data === "1" ? 'checked' : '';
                            return `
                          <div class="form-check form-switch">
                               <input class="form-check-input status-toggle" type="checkbox" data-id="${row.id}" ${isChecked}>
                               <label class="form-check-label">${data === "1" ? 'Active' : 'Inactive'}</label>
                           </div>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            let actionHtml = '';

                            // Check if the user has 'PAYMENT Settings Delete' permission
                            if (hasPAYMENTConfigurationDelete) {
                                // Render the delete button with dynamic data-id
                                actionHtml = `
                                 <button class="btn btn-danger delete-smtp" data-id="${row.id}">
                                   <i class="bi bi-trash"></i>
                                 </button>
                                  `;
                            } else {
                                // If no permission, render a disabled button or an alternative message
                                actionHtml = `
                                    <button class="btn btn-secondary" disabled>
                                       <i class="bi bi-trash"></i> No Permission
                                     </button>
                                     `;
                            }

                            return actionHtml;
                        }
                    }


                ]
            });

            // View More functionality
            $('#payment_setting_table').on('click', '.view-more', function() {
                const fullKeyDiv = $(this).closest('td').find('.full-key');
                const fullSecretDiv = $(this).closest('td').find('.full-secret');

                // Toggle full key
                fullKeyDiv.toggle();
                fullSecretDiv.toggle();

                // Change icon based on visibility
                if (fullKeyDiv.is(':visible')) {
                    $(this).html('<i class="bi bi-eye-slash text-danger"></i>'); // Change icon to eye-slash
                } else {
                    $(this).html('<i class="bi bi-eye text-success"></i>'); // Change icon to eye
                }
            });

            // Status toggle
            $('#payment_setting_table').on('change', '.status-toggle', function() {
                const paymentSettingId = $(this).data('id');
                const status = $(this).is(':checked') ? 1 : 0;

                $.ajax({
                    // url: "{{ url('/payment-setting/update-status') }}/" + paymentSettingId,
                    url: "/payment-setting/update-status/" + paymentSettingId,

                    method: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: status
                    },
                    success: function(response) {
                        console.log('AJAX response:', response);
                        if (response.success) {
                            paymenttable.ajax.reload(); // Reload the table
                        } else {
                            console.error('Failed to update status', response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', status, error);
                        console.error('Response:', xhr.responseText);
                    }
                });
            });

            $('#payment_setting_table').on('click', '.delete-smtp', function() {
                var payment_setting = $(this).data('id'); // Get the ID of the category to be deleted

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Make an AJAX request to delete the category
                        $.ajax({
                            url: '/payment-setting/' + payment_setting,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Deleted!',
                                    'Your Setting has been deleted.',
                                    'success'
                                );
                                $('#payment_setting_table').DataTable().ajax
                                    .reload(); // Reload table after delete
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'There was an issue deleting the category.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
