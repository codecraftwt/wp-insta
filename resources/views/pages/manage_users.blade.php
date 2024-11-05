@extends('structures.main')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Manage Users</h1>
    </div>

    <div>
        <button type="button" class="btn mb-5 btn-success" data-bs-toggle="modal" data-bs-target="#usersmodel"
            id="addUserButton">
            <i class="bi bi-person-add"></i> Add User
        </button>
    </div>

    <div class="modal fade" id="usersmodel" tabindex="-1" aria-labelledby="usersmodelLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl"> <!-- Use modal-xl for extra-large size -->
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="usersmodelLabel"><i class="bi bi-people"></i> ADD User</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="userForm">
                        @csrf <!-- CSRF protection -->

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">User Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                                <input type="hidden" class="form-control" id="userId" name="userId">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="col-md-6 mb-3" id="passcontainer">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="country" class="form-label">Country</label>
                                <input type="text" class="form-control" id="country" name="country" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="state" class="form-label">State</label>
                                <input type="text" class="form-control" id="state" name="state" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control" id="city" name="city" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="pincode" class="form-label">Pincode</label>
                                <input type="text" class="form-control" id="pincode" name="pincode" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-select" id="gender" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="dob" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="dob" name="dob" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="subscription_type" class="form-label">Subscription Type</label>
                                <input type="text" class="form-control" id="subscription_type"
                                    name="subscription_type" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">status</label>
                                <input type="text" class="form-control" id="status" name="status" required>
                            </div>
                        </div>


                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-primary " id="submitButton"> <i
                                    class="bi bi-save"></i>
                                Add User</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card p-3" style="background-color: #f9f9f9; border: 1px solid #e0e0e0;">
        <div class="card-body">

            <div class="table-responsive">
                <div id="userscontainer" class="dataTables_wrapper no-footer">
                    <table id="usersTable" class="table table-striped table-bordered">
                        <thead class="table-primary">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated here via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {{-- <script>
        $(document).ready(function() {
            // Initialize the DataTable with ajax loading
            let userTable = $('#usersTable').DataTable({

                ajax: {
                    url: "{{ route('getusers') }}",
                    type: 'GET',
                    dataSrc: ''
                },
                columns: [{
                        data: "name",
                        title: "Name"
                    },
                    {
                        data: "email",
                        title: "Email"
                    },
                    {
                        data: "manage_users.0.phone",
                        title: "Phone",
                        defaultContent: "N/A"
                    },
                    {
                        data: null,
                        title: "Actions",
                        render: function(data, type, row) {
                            return `
                        <button class="btn btn-info" onclick='viewUser(${JSON.stringify(row)})'>
                            <i class="bi bi-eye"></i>
                        </button>
                        <button class="btn btn-primary" onclick='editUser(${JSON.stringify(row)})'>
                            <i class="bi bi-pencil"></i> Edit
                        </button>
                        <button class="btn btn-danger" onclick='deleteUser(${row.id})'>
                            <i class="bi bi-trash"></i> Delete
                         </button>
                    `;
                        }
                    }
                ]
            });

            // Handle user form submission
            $('#userForm').on('submit', function(event) {
                event.preventDefault();

                const userId = $('#userId').val();
                const url = userId ? `{{ url('users/update') }}/${userId}` : "{{ route('storeusers') }}";
                const method = userId ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    type: method,
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#usersmodel').modal('hide');
                        $('#userForm')[0].reset();

                        Swal.fire({
                            icon: 'success',
                            title: response.message || 'User successfully saved!',
                            toast: true,
                            position: 'top-end',
                            timer: 2000,
                            timerProgressBar: true,
                            showConfirmButton: false
                        });

                        // Reload the DataTable
                        userTable.ajax.reload(null,
                            false); // Reload data without resetting the pagination
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); // Log any errors
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed to save user',
                            text: error,
                        });
                    }
                });
            });

            // Event listener for when the modal is hidden
            $('#usersmodel').on('hidden.bs.modal', function() {
                $('#addUserButton').show();
                $('#submitButton').show();
                $('#userForm')[0].reset();
            });
        });

        // Function to view user details
        function viewUser(user) {
            // Populate the modal with user data
            $('#usersmodel #name').val(user.name);
            $('#usersmodel #email').val(user.email);
            const manageData = user.manage_users[0];
            $('#usersmodel #phone').val(manageData ? manageData.phone : 'N/A');
            $('#usersmodel #country').val(manageData ? manageData.country : 'N/A');
            $('#usersmodel #state').val(manageData ? manageData.state : 'N/A');
            $('#usersmodel #city').val(manageData ? manageData.city : 'N/A');
            $('#usersmodel #pincode').val(manageData ? manageData.pincode : 'N/A');
            $('#usersmodel #gender').val(manageData ? manageData.gender : 'N/A');
            $('#usersmodel #dob').val(manageData ? manageData.dob : 'N/A');
            $('#usersmodel #subscription_type').val(manageData ? manageData.subscription_type : 'N/A');
            $('#usersmodel #start_date').val(manageData ? manageData.start_date : 'N/A');
            $('#usersmodel #end_date').val(manageData ? manageData.end_date : 'N/A');
            $('#usersmodel #status').val(manageData ? manageData.status : 'N/A');
            $('#usersmodel input').attr('readonly', true);

            $('#addUserButton').hide();
            $('#submitButton').hide();
            $('#usersmodelLabel').text('View User Details');
            $('#usersmodel').modal('show');
        }

        // Function to edit user details
        function editUser(user) {
            // Populate the form for editing
            $('#userId').val(user.id);
            $('#name').val(user.name);
            $('#email').val(user.email);
            const manageData = user.manage_users[0];
            $('#phone').val(manageData ? manageData.phone : 'N/A');
            $('#country').val(manageData ? manageData.country : 'N/A');
            $('#state').val(manageData ? manageData.state : 'N/A');
            $('#city').val(manageData ? manageData.city : 'N/A');
            $('#pincode').val(manageData ? manageData.pincode : 'N/A');
            $('#gender').val(manageData ? manageData.gender : 'N/A');
            $('#dob').val(manageData ? manageData.dob : 'N/A');
            $('#subscription_type').val(manageData ? manageData.subscription_type : 'N/A');
            $('#start_date').val(manageData ? manageData.start_date : 'N/A');
            $('#end_date').val(manageData ? manageData.end_date : 'N/A');
            $('#status').val(manageData ? manageData.status : 'N/A');

            $('#usersmodel input').attr('readonly', false);
            $('#addUserButton').show();
            $('#submitButton').text('Update User');
            $('#usersmodelLabel').text('Edit User');
            $('#usersmodel').modal('show');
        }

        function deleteUser(id) {
            // SweetAlert confirmation dialog
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
                    // Proceed with deletion if confirmed
                    $.ajax({
                        url: `/users/delete/${id}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token
                        },
                        success: function(response) {
                            // Success alert with auto-close
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message,
                                timer: 2000, // Auto close after 2 seconds
                                showConfirmButton: false
                            }).then(() => {
                                // Reload DataTable after the alert closes
                                userTable.ajax.reload(null,
                                false); // Reload data without resetting pagination
                            });
                        },
                        error: function(xhr) {
                            // Error alert
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'An error occurred while deleting the user.',
                            });
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        }
    </script> --}}

    <script>
        // Declare userTable globally so it can be accessed anywhere
        let userTable;

        $(document).ready(function() {
            // Initialize the DataTable with ajax loading
            userTable = $('#usersTable').DataTable({
                ajax: {
                    url: "{{ route('getusers') }}",
                    type: 'GET',
                    dataSrc: ''
                },
                columns: [{
                        data: "name",
                        title: "Name"
                    },
                    {
                        data: "email",
                        title: "Email"
                    },
                    {
                        data: "manage_users.0.phone",
                        title: "Phone",
                        defaultContent: "N/A"
                    },
                    {
                        data: null,
                        title: "Actions",
                        render: function(data, type, row) {
                            return `
                                <button class="btn btn-info" onclick='viewUser(${JSON.stringify(row)})'>
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn btn-primary" onclick='editUser(${JSON.stringify(row)})'>
                                    <i class="bi bi-pencil"></i> Edit
                                </button>
                                <button class="btn btn-danger" onclick='deleteUser(${row.id})'>
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            `;
                        }
                    }
                ]
            });

            // Handle user form submission
            $('#userForm').on('submit', function(event) {
                event.preventDefault();

                const userId = $('#userId').val();
                const url = userId ? `{{ url('users/update') }}/${userId}` : "{{ route('storeusers') }}";
                const method = userId ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    type: method,
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#usersmodel').modal('hide');
                        $('#userForm')[0].reset();

                        Swal.fire({
                            icon: 'success',
                            title: response.message || 'User successfully saved!',
                            toast: true,
                            position: 'top-end',
                            timer: 2000,
                            timerProgressBar: true,
                            showConfirmButton: false
                        });

                        // Reload the DataTable
                        userTable.ajax.reload(null,
                            false); // Reload data without resetting the pagination
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed to save user',
                            text: error,
                        });
                    }
                });
            });

            // Event listener for when the modal is hidden
            $('#usersmodel').on('hidden.bs.modal', function() {
                $('#addUserButton').show();
                $('#submitButton').show();
                $('#userForm')[0].reset();
            });
        });

        // Function to delete user
        function deleteUser(id) {
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
                    // Proceed with deletion if confirmed
                    $.ajax({
                        url: `/users/delete/${id}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message,
                                timer: 2000, // Auto close after 2 seconds
                                showConfirmButton: false
                            }).then(() => {

                                userTable.ajax.reload(null,
                                    false);
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'An error occurred while deleting the user.',
                            });
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        }

        function viewUser(user) {
            // Populate the modal with user data
            $('#usersmodel #name').val(user.name);
            $('#usersmodel #email').val(user.email);
            const manageData = user.manage_users[0];
            $('#usersmodel #phone').val(manageData ? manageData.phone : 'N/A');
            $('#usersmodel #country').val(manageData ? manageData.country : 'N/A');
            $('#usersmodel #state').val(manageData ? manageData.state : 'N/A');
            $('#usersmodel #city').val(manageData ? manageData.city : 'N/A');
            $('#usersmodel #pincode').val(manageData ? manageData.pincode : 'N/A');
            $('#usersmodel #gender').val(manageData ? manageData.gender : 'N/A');
            $('#usersmodel #dob').val(manageData ? manageData.dob : 'N/A');
            $('#usersmodel #subscription_type').val(manageData ? manageData.subscription_type : 'N/A');
            $('#usersmodel #start_date').val(manageData ? manageData.start_date : 'N/A');
            $('#usersmodel #end_date').val(manageData ? manageData.end_date : 'N/A');
            $('#usersmodel #status').val(manageData ? manageData.status : 'N/A');
            $('#usersmodel input').attr('readonly', true);

            $('#addUserButton').hide();
            $('#passcontainer').hide();

            $('#submitButton').hide();
            $('#usersmodelLabel').text('View User Details');
            $('#usersmodel').modal('show');
        }

        // Function to edit user details
        function editUser(user) {
            // Populate the form for editing
            $('#userId').val(user.id);
            $('#name').val(user.name);
            $('#email').val(user.email);
            const manageData = user.manage_users[0];
            $('#phone').val(manageData ? manageData.phone : 'N/A');
            $('#country').val(manageData ? manageData.country : 'N/A');
            $('#state').val(manageData ? manageData.state : 'N/A');
            $('#city').val(manageData ? manageData.city : 'N/A');
            $('#pincode').val(manageData ? manageData.pincode : 'N/A');
            $('#gender').val(manageData ? manageData.gender : 'N/A');
            $('#dob').val(manageData ? manageData.dob : 'N/A');
            $('#subscription_type').val(manageData ? manageData.subscription_type : 'N/A');
            $('#start_date').val(manageData ? manageData.start_date : 'N/A');
            $('#end_date').val(manageData ? manageData.end_date : 'N/A');
            $('#status').val(manageData ? manageData.status : 'N/A');

            $('#usersmodel input').attr('readonly', false);
            $('#addUserButton').show();
            $('#passcontainer').show();
            $('#submitButton').text('Update User');
            $('#usersmodelLabel').text('Edit User');
            $('#usersmodel').modal('show');
        }
    </script>
@endsection
