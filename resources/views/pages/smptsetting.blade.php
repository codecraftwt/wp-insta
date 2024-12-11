@extends('structures.main')

@section('content')
    <div class="container">
        <h1 class="text-center p-2 mb-4">SMTP Settings</h1>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    timer: 2000,
                    timerProgressBar: true,
                    showCloseButton: true,
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif




    <div class="container-fluid">
        <!-- Card with shadow and light border -->
        <div class="card mt-4 shadow-sm border-light rounded w-100">

            <!-- Card Header -->
            <div class="card-header table_headercolor text-white">
                <h5 class="mb-0">Add SMTP Settings</h5>
            </div>

            <!-- Card Body -->
            <div class="card-body p-4">
                <form action="{{ route('mail_settings.store') }}" method="POST">
                    @csrf
                    <!-- SMTP Mailer Settings -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="mail_mailer">Mailer</label>
                                <input type="text" name="mail_mailer" class="form-control p-1" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="mail_host">Host</label>
                                <input type="text" name="mail_host" class="form-control p-1" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="mail_port">Port</label>
                                <input type="text" name="mail_port" class="form-control p-1" required>
                            </div>
                        </div>
                    </div>

                    <!-- SMTP Username, Password, Encryption -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="mail_username">Username</label>
                                <input type="text" name="mail_username" class="form-control p-1" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="mail_password">Password</label>
                                <input type="password" name="mail_password" class="form-control p-1" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="mail_encryption">Encryption</label>
                                <input type="text" name="mail_encryption" class="form-control p-1" required>
                            </div>
                        </div>
                    </div>

                    <!-- SMTP From Address and Name -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="mail_from_address">From Address</label>
                                <input type="email" name="mail_from_address" class="form-control p-1" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="mail_from_name">From Name</label>
                                <input type="text" name="mail_from_name" class="form-control p-1" required>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden Status Input -->
                    <input type="hidden" name="status" value="1">

                    <!-- Save Button -->
                    <div class="text-end">
                        @if (Auth::user()->hasPermission('SMTP Create'))
                            <button type="submit" class="btn btn-primary shadow-sm px-4 mt-3">
                                <i class="bi bi-save"></i> Save Settings
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="card m-4">
        <div class="card-header table_headercolor text-white">
            <h5 class="mb-0">SMTP Settings</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div id="smtpcontainer" class="dataTables_wrapper no-footer mt-2">
                    <table id="smtpTable" class="display table table-bordered">
                        <thead class="custom-thead">
                            <tr>
                                <th>Sr.No</th>
                                <th>Mailer</th>
                                <th>Host</th>
                                <th>Port</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Encryption</th>
                                <th>From Address</th>
                                <th>From Name</th>
                                <th>Status</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated by DataTable AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="editSmtpModal" tabindex="-1" aria-labelledby="editSmtpModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSmtpModalLabel">Edit SMTP Settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editSmtpForm">
                        @csrf
                        @method('PUT') <!-- This is for the PUT request method -->
                        <input type="hidden" id="smtp-id" name="id">

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="mail_mailer" class="form-label">Mailer</label>
                                <input type="text" class="form-control" id="mail_mailer" name="mail_mailer" required>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="mail_host" class="form-label">Host</label>
                                <input type="text" class="form-control" id="mail_host" name="mail_host" required>
                            </div>

                            <div class="col-md-2 mb-3">
                                <label for="mail_port" class="form-label">Port</label>
                                <input type="text" class="form-control" id="mail_port" name="mail_port" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="mail_username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="mail_username" name="mail_username"
                                    required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="mail_password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="mail_password" name="mail_password"
                                    required>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="mail_encryption" class="form-label">Encryption</label>
                                <input type="text" class="form-control" id="mail_encryption" name="mail_encryption"
                                    required>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="mail_from_address" class="form-label">From Address</label>
                                <input type="email" class="form-control" id="mail_from_address"
                                    name="mail_from_address" required>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="mail_from_name" class="form-label">From Name</label>
                                <input type="text" class="form-control" id="mail_from_name" name="mail_from_name"
                                    required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        const hasSMTPDelete = @json(Auth::user()->hasPermission('SMTP Delete'));
    </script>

    <script>
        $(document).ready(function() {
            const table = $('#smtpTable').DataTable({
                ajax: {
                    url: "/getsmtp",
                    dataSrc: 'data'
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart +
                                1;
                        },
                        title: 'SR No.'
                    }, {
                        data: 'mail_mailer',
                        name: 'mail_mailer'
                    },
                    {
                        data: 'mail_host',
                        name: 'mail_host'
                    },
                    {
                        data: 'mail_port',
                        name: 'mail_port'
                    },
                    {
                        data: 'mail_username',
                        name: 'mail_username'
                    },
                    {
                        data: 'mail_password',
                        name: 'mail_password'
                    },
                    {
                        data: 'mail_encryption',
                        name: 'mail_encryption'
                    },
                    {
                        data: 'mail_from_address',
                        name: 'mail_from_address'
                    },
                    {
                        data: 'mail_from_name',
                        name: 'mail_from_name'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, row) {
                            // Create a toggle switch
                            return `
                                <label class="switch">
                                    <input type="checkbox" class="toggle-status" data-id="${row.id}" ${data == "1" ? 'checked' : ''}>
                                    <span class="slider"></span>
                                </label>
                            `;
                        }
                    },
                    {
                        data: null,
                        title: "Actions",
                        render: function(data, type, row) {
                            let actionHtml = '';

                            // Edit button
                            actionHtml = `
            <button class="btn btn-primary edit-smtp" data-id="${row.id}" data-mailer="${row.mail_mailer}" data-host="${row.mail_host}" data-port="${row.mail_port}" data-username="${row.mail_username}" data-password="${row.mail_password}" data-encryption="${row.mail_encryption}" data-from-address="${row.mail_from_address}" data-from-name="${row.mail_from_name}">
                <i class="bi bi-pencil"></i>
            </button>
        `;

                            // If the user has 'SMTP Delete' permission
                            if (hasSMTPDelete) {
                                actionHtml += `
                <button class="btn btn-danger delete-smtp" data-id="${row.id}">
                    <i class="bi bi-trash"></i>
                </button>
            `;
                            }

                            return actionHtml;
                        }
                    }


                ]
            });
        });

        $(document).on('change', '.toggle-status', function() {
            const id = $(this).data('id');
            const status = this.checked ? 1 : 0;
            const token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                    url: `/smtptoggle/${id}`,
                    method: 'POST',
                    data: {
                        status,
                        _token: token
                    }
                }).done(response => console.log(response))
                .fail(() => $(this).prop('checked', !this.checked));
        });

        $('#smtpTable').on('click', '.delete-smtp', function() {
            var smtp = $(this).data('id'); // Get the ID of the category to be deleted

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
                        url: '/smpt-delete/' + smtp,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                'Your smpt has been deleted.',
                                'success'
                            );
                            $('#smtpTable').DataTable().ajax
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

        $(document).on('click', '.edit-smtp', function() {
            const id = $(this).data('id');
            const mailer = $(this).data('mailer');
            const host = $(this).data('host');
            const port = $(this).data('port');
            const username = $(this).data('username');
            const password = $(this).data('password');
            const encryption = $(this).data('encryption');
            const fromAddress = $(this).data('from-address');
            const fromName = $(this).data('from-name');

            // Populate modal with current data
            $('#smtp-id').val(id);
            $('#mail_mailer').val(mailer);
            $('#mail_host').val(host);
            $('#mail_port').val(port);
            $('#mail_username').val(username);
            $('#mail_password').val(password);
            $('#mail_encryption').val(encryption);
            $('#mail_from_address').val(fromAddress);
            $('#mail_from_name').val(fromName);

            // Show the modal
            $('#editSmtpModal').modal('show');
        });

        $('#editSmtpForm').on('submit', function(e) {
            e.preventDefault();

            const formData = $(this).serialize();
            const id = $('#smtp-id').val();

            $.ajax({
                url: `/smtpsettings/${id}`,
                method: 'PUT',
                data: formData,
                success: function(response) {
                    Swal.fire(
                        'Updated!',
                        'SMTP settings have been updated.',
                        'success'
                    );
                    $('#smtpTable').DataTable().ajax.reload(); // Reload table
                    $('#editSmtpModal').modal('hide'); // Hide modal
                },
                error: function(xhr) {
                    Swal.fire(
                        'Error!',
                        'There was an issue updating the SMTP settings.',
                        'error'
                    );
                }
            });
        });
    </script>

    <style>
        .switch {
            display: inline-block;
            width: 40px;
            height: 20px;
            position: relative;
        }

        .switch input {
            display: none;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: background-color 0.2s;
            border-radius: 20px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            border-radius: 50%;
            transition: transform 0.2s;
        }

        input:checked+.slider {
            background-color: #4CAF50;
        }

        input:checked+.slider:before {
            transform: translateX(20px);
        }

        .custom-thead>tr>th {
            background-color: #0094DE !important;
        }

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

@endsection
