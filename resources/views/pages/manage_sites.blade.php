@extends('structures.main')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Site Management</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Button to trigger the modal -->
        <button type="button" class="btn btn-primary" id="openaddSiteModal">
            <i class="bi bi-plus-circle"></i> Add Site
        </button>

        <!-- Modal -->
        <div class="modal fade" id="manageSiteModal21" tabindex="-1" aria-labelledby="manageSiteModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="manageSiteModalLabel">Add Site</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('storesite') }}" method="POST">
                            @csrf
                            <div class="row">
                                <!-- User Selection with matching width -->
                                <div class="col-md-6 mb-3">
                                    <label for="user_id" class="form-label">Select User</label>
                                    <select class="form-select" name="user_id" id="user_id" style="width: 100%;" required>
                                        <option value="">Select User Name</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Site Details -->
                                <div class="col-md-6 mb-3">
                                    <label for="site_name" class="form-label">Site Name</label>
                                    <input type="text" class="form-control" name="site_name" id="site_name" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="site_type" class="form-label">Site Type</label>
                                    <input type="text" class="form-control" name="site_type" id="site_type" required>
                                </div>

                                <!-- Email and Password -->
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" id="password" required>
                                </div>

                                <!-- Username and Database Details -->
                                <div class="col-md-6 mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" name="username" id="username" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="db_name" class="form-label">Database Name</label>
                                    <input type="text" class="form-control" name="db_name" id="db_name" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="db_username" class="form-label">Database Username</label>
                                    <input type="text" class="form-control" name="db_username" id="db_username" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="db_password" class="form-label">Database Password</label>
                                    <input type="text" class="form-control" name="db_password" id="db_password" required>
                                </div>

                                <!-- Plugin List and Theme -->
                                <div class="col-md-6 mb-3">
                                    <label for="plugin_list" class="form-label">Plugin List</label>
                                    <select class="form-select" name="plugin_list[]" id="plugin_list" multiple="multiple"
                                        style="width: 100%;" required>
                                        @foreach ($plugin as $plugins)
                                            <option value="{{ $plugins->id }}">{{ $plugins->name }}</option>
                                        @endforeach
                                        <!-- Add as many options as needed -->
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="theam" class="form-label">Theme</label>
                                    <input type="text" class="form-control" name="theam" id="theam" required>
                                </div>

                                <!-- Domain Details -->
                                <div class="col-md-6 mb-3">
                                    <label for="domain_name" class="form-label">Domain Name</label>
                                    <input type="text" class="form-control" name="domain_name" id="domain_name"
                                        required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="ownerdomain_name" class="form-label">Owner Domain Name</label>
                                    <input type="text" class="form-control" name="ownerdomain_name"
                                        id="ownerdomain_name" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container mt-5">

        <table id="siteTable" class="table table-bordered">
            <thead class="table-primary">
                <tr>
                    <th class="text-center"><i class="bi bi-list-ul"></i> SR.No</th>
                    <th class="text-center"><i class="bi bi-person"></i> Username</th>
                    <th class="text-center"><i class="bi bi-building"></i> Site Name</th>
                    <th class="text-center"><i class="bi bi-globe"></i> Domain Name</th>
                    <th class="text-center"><i class="bi bi-gear-fill"></i> Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be populated dynamically by DataTable -->
            </tbody>
        </table>
    </div>


    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="" method="POST">
                        <input type="hidden" name="euser_id" id="euser_id">
                        <input type="hidden" name="id" id="id" required>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="euser_name" class="form-label">User's Name</label>
                                <input type="text" class="form-control" name="euser_name" id="euser_name" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="edomain_name" class="form-label">Domain Name</label>
                                <input type="text" class="form-control" name="edomain_name" id="edomain_name"
                                    required>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




    <script>
        $(document).ready(function() {
            // Show modal when button is clicked
            $('#openaddSiteModal').on('click', function() {
                $('#manageSiteModal21').modal('show');
            });


            $('#user_id').select2({
                dropdownParent: $('#manageSiteModal21'),
                placeholder: "Select an Option",
                allowClear: true
            });


            $('#plugin_list').select2({
                dropdownParent: $('#manageSiteModal21'),
                placeholder: "Select Plugins",
                allowClear: true
            });

        });
    </script>

    <script>
        var siteTable;

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // Initialize the DataTable and assign it to the global variable
            siteTable = $('#siteTable').DataTable({
                ajax: {
                    url: '{{ route('showsites') }}',
                    type: 'GET',
                    dataSrc: ""
                },
                columns: [{
                        data: null,
                        title: 'SR.No',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'user.name',
                        name: 'user_id'
                    },
                    {
                        data: 'site_name',
                        name: 'site_name'
                    },
                    {
                        data: 'domain_name',
                        name: 'domain_name'
                    },
                    {
                        data: null,
                        title: 'Actions',
                        render: function(data, type, row) {
                            return `
                        <button class="btn btn-sm btn-danger delete-role" data-id="${row.id}">Delete</button>
                        <button class="btn btn-sm btn-primary edit-role" data-id="${row.id}" data-name="${row.name}">Edit</button>
                    `;
                        }
                    }
                ],
            });
        });

        $(document).on('click', '.edit-role', function() {
            // Get data attributes from the button
            var userId = $(this).data('id');

            // Perform an AJAX request to fetch the user data
            $.ajax({
                url: '/users/' + userId, // Change to your route
                method: 'GET',
                success: function(response) {

                    $('#euser_id').val(response.user_id);
                    $('#id').val(response.id);
                    $('#euser_name').val(response.username);
                    // $('#esite_name').val(response.site_name);
                    // $('#esite_type').val(response.site_type);
                    // $('#eemail').val(response.email);

                    // $('#eusername').val(response.username);
                    // $('#edb_name').val(response.db_name);
                    // $('#edb_username').val(response.db_username);
                    // $('#eownerdomain_name').val(response.ownerdomain_name);
                    // $('#eplugin_list').val(response.plugin_list);
                    // $('#etheam').val(response.theam);
                    $('#edomain_name').val(response.domain_name);


                    // Show the modal
                    $('#editModal').modal('show');
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Error fetching user data.');
                }
            });
        });



        $(document).on('submit', '#editForm', function(e) {
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url: '/users/updatesite',
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#editModal').modal('hide');

                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'User data updated successfully.',
                        position: 'top-right',
                        toast: true,
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });

                    siteTable.ajax.reload();
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Error updating user data. Please check the fields and try again.');
                }
            });
        });

        $(document).on('click', '.delete-role', function() {
            // Get data attributes from the button
            var userId = $(this).data('id');

            // Use SweetAlert for confirmation
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/users/sitedelete/' + userId,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response
                                    .message,
                                timer: 1500,
                                showConfirmButton: false,
                                position: 'top-end',
                                toast: true,
                                timerProgressBar: true
                            }).then(() => {
                                siteTable.ajax.reload();
                            });
                        },

                    });
                }
            });
        });
    </script>
  
@endsection
