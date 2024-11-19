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




    <div class="card" style="font-family: 'Poppins', sans-serif;">
        <div class="card-body p-2 mt-2">
            <h4 class="fw-bold ms-4">Add SMTP Settings</h4>
        </div>

        <div class="card-body p-4">

            <form action="{{ route('mail_settings.store') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mail_mailer">Mailer</label>
                            <input type="text" name="mail_mailer" class="form-control p-1">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mail_host">Host</label>
                            <input type="text" name="mail_host" class="form-control p-1">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mail_port">Port</label>
                            <input type="text" name="mail_port" class="form-control p-1">
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mail_username">Username</label>
                            <input type="text" name="mail_username" class="form-control p-1">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mail_password">Password</label>
                            <input type="password" name="mail_password" class="form-control p-1">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mail_encryption">Encryption</label>
                            <input type="text" name="mail_encryption" class="form-control p-1">
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mail_from_address">From Address</label>
                            <input type="email" name="mail_from_address" class="form-control p-1">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mail_from_name">From Name</label>
                            <input type="text" name="mail_from_name" class="form-control p-1">
                        </div>
                    </div>
                </div>

                <!-- Hidden Status Input -->
                <input type="hidden" name="status" value="1">
                @if (Auth::user()->hasPermission('SMTP Create'))
                    <button type="submit" class="btn btn-success mt-3">Save</button> <!-- Margin-top for spacing -->
                @endif
            </form>
        </div>
    </div>

    <div class="card m-4">
        <div class="card-body">
            <div class="table-responsive">
                <div id="smtpcontainer" class="dataTables_wrapper no-footer">

                    <table id="smtpTable" class="display">
                        <thead>
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

    <script>
        const hasSMTPDelete = @json(Auth::user()->hasPermission('SMTP Delete'));
    </script>

    <script>
        $(document).ready(function() {
            const table = $('#smtpTable').DataTable({
                ajax: {
                    url: "{{ route('getsmtp') }}",
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

                            // Check if the user has 'SMTP Delete' permission
                            if (hasSMTPDelete) {
                                // If the user has permission, render the delete button
                                actionHtml = `
                <button class="btn btn-danger delete-smtp" data-id="${row.id}">
                    <i class="bi bi-trash"></i> 
                </button>
            `;
                            } else {
                                // If the user does not have permission, render a disabled button or a "No Permission" message
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
    </style>

@endsection
