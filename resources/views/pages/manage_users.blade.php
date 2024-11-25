@extends('structures.main')

@section('content')
    <div class="container">

        <h1 class="fw-bold my-2 text-center">
            Manage Users
        </h1>
    </div>

    <div>
        @if (Auth::user()->hasPermission('Manage Users Create'))
            <button type="button" class="btn mb-5 btn-success" data-bs-toggle="modal" data-bs-target="#usersmodel"
                id="addUserButton">
                <i class="bi bi-person-add"></i> Add User
            </button>
        @endif
    </div>

    <div class="modal fade" id="usersmodel" tabindex="-1" aria-labelledby="usersmodelLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content shadow-lg border-0">
                <!-- Modal Header -->
                <div class="modal-header"
                    style="background: linear-gradient(135deg, #d9ffdc 0%, #e0f7fa 100%); color: #333; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                    <h5 class="modal-title fw-bold" id="usersmodelLabel">
                        <i class="bi bi-people"></i> Add User
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body bg-light">
                    <form id="userForm" class="p-3">
                        @csrf <!-- CSRF protection -->

                        <div class="row g-4">
                            <!-- User Name -->
                            <div class="col-md-3">
                                <label for="name" class="form-label fw-semibold">User Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                                <input type="hidden" class="form-control" id="userId" name="userId">
                            </div>

                            <!-- Select Role -->
                            <div class="col-md-3">
                                <label for="role_id" class="form-label fw-semibold">Select Role</label>
                                <select class="form-control" id="role_id" name="role_id">
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>

                            <!-- Password -->
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-semibold">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-semibold">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" required>
                            </div>

                            <!-- Address Details -->
                            <div class="col-md-4">
                                <label for="pincode" class="form-label">Pincode</label>
                                <div class="input-group">
                                    <!-- Pincode input field -->
                                    <input type="text" class="form-control" id="pincode" name="pincode" required
                                        autocomplete="off" placeholder="Enter Pincode" onblur="fetchLocationDetails()">
                                    <!-- Button to trigger location fetch -->
                                    <button class="btn btn-primary" type="button" onclick="fetchLocationDetails()">Fetch
                                        Location</button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="country" class="form-label fw-semibold">Country</label>
                                <input type="text" class="form-control" id="country" name="country" required>
                            </div>
                            <div class="col-md-4">
                                <label for="state" class="form-label fw-semibold">State</label>
                                <input type="text" class="form-control" id="state" name="state" required>
                            </div>
                            <div class="col-md-4">
                                <label for="city" class="form-label fw-semibold">City</label>
                                <input type="text" class="form-control" id="city" name="city" required>
                            </div>


                            <!-- Gender and Date of Birth -->
                            <div class="col-md-4">
                                <label for="gender" class="form-label fw-semibold">Gender</label>
                                <select class="form-select" id="gender" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="dob" class="form-label fw-semibold">Date of Birth</label>
                                <input type="date" class="form-control" id="dob" name="dob" required>
                            </div>

                            <!-- Subscription Details -->
                            <div class="col-md-4">
                                <label for="subscription_type" class="form-label fw-semibold">Subscription Type</label>
                                <input type="text" class="form-control" id="subscription_type"
                                    name="subscription_type" required>
                            </div>
                            <div class="col-md-4">
                                <label for="start_date" class="form-label fw-semibold">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                            <div class="col-md-4">
                                <label for="end_date" class="form-label fw-semibold">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>

                            <!-- Status -->
                            <div class="col-md-4">
                               
                                <input type="hidden" class="form-control" id="status" name="status"
                                    value="1">
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="modal-footer mt-3">
                            <button type="submit" id='submit-btn' class="btn btn-primary rounded-pill px-4">
                                <i class="bi bi-save"></i> Add User
                            </button>
                            <button type="button" class="btn btn-secondary rounded-pill px-4"
                                data-bs-dismiss="modal">Close</button>
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

    <script>
        const hasManageUsersUpdate = @json(Auth::user()->hasPermission('Manage Users Update'));
        const hasManageUsersDelete = @json(Auth::user()->hasPermission('Manage Users Delete'));
    </script>



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
                            let actionHtml = `
            <button class="btn btn-info" onclick='viewUser(${JSON.stringify(row)})'>
                <i class="bi bi-eye"></i>
            </button>
        `;

                            // Check if the user has the 'Manage Users Update' permission
                            if (hasManageUsersUpdate) {
                                actionHtml += `
                <button class="btn btn-primary" onclick='editUser(${JSON.stringify(row)})'>
                    <i class="bi bi-pencil"></i> Edit
                </button>
            `;
                            } else {
                                actionHtml += `
                <button class="btn btn-secondary" disabled>
                    <i class="bi bi-pencil"></i> No Permission
                </button>
            `;
                            }

                            // Check if the user has the 'Manage Users Delete' permission
                            if (hasManageUsersDelete) {
                                actionHtml += `
                <button class="btn btn-danger" onclick='deleteUser(${row.id})'>
                    <i class="bi bi-trash"></i> Delete
                </button>
            `;
                            } else {
                                actionHtml += `
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
            $('#submit-btn').hide();

            $('#submitButton').hide();
            $('#usersmodelLabel').text('View User Details');
            $('#usersmodel').modal('show');
        }

        // Function to edit user details
        function editUser(user) {
            // Populate the form for editing
            $('#userId').val(user.id);
            $('#name').val(user.name);
            $('#role_id').val(user.role_id);
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
            $('#submit-btn').show();
            $('#passcontainer').show();
            $('#submitButton').text('Update User');
            $('#usersmodelLabel').text('Edit User');
            $('#usersmodel').modal('show');
        }
    </script>

    <script>
        function fetchLocationDetails() {
            const pincode = $('#pincode').val().trim();

            if (!pincode) {
                return; // Don't make an API call if pincode is empty
            }

            // Geoapify API key and URL
            const apiKey = '20d7d0b95e534459bae0c72805aeee9e';
            const apiUrl = `https://api.geoapify.com/v1/geocode/search?text=${pincode}&apiKey=${apiKey}`;

            $.ajax({
                url: apiUrl,
                method: 'GET',
                success: function(response) {
                    if (response.features && response.features.length > 0) {
                        const location = response.features[0]; // Take the first matching location

                        const state = location.properties.state;
                        const country = location.properties.country;

                        // Fallback logic for city
                        let city = location.properties.city ||
                            location.properties.town ||

                            location.properties.region ||
                            location.properties.suburb ||
                            location.properties.county ||
                            location.properties.other;



                        $('#state').val(state || '');
                        $('#country').val(country || '');


                        // Check if city exists
                        if (city) {
                            $('#city').val(city);
                            $('#city').prop('readonly', true);
                        } else {
                            $('#city').val('');
                            $('#city').prop('readonly', false);

                            Swal.fire({
                                title: 'City not found!',
                                text: 'We could not find the city for the given pincode. You can enter it manually.',
                                icon: 'warning'
                            });
                        }
                    }
                },

            });
        }
    </script>
@endsection
