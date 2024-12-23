@extends('structures.main')

@section('content')
    <div class="container">

        <h1 class="fw-bold my-2 text-center">
            Manage Users
        </h1>
    </div>

    <div>
        @if (Auth::user()->hasPermission('Manage Users Create'))
            <button type="button" class="btn mb-5 btn-primary" data-bs-toggle="modal" data-bs-target="#usersmodel"
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
                            <div class="col-md-3">
                                <label for="last_name" class="form-label fw-semibold">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" required>

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
                            <div class="col-md-6" id="passcontainer">
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
                                <label for="address" class="form-label">Address</label>
                                <div class="input-group">
                                    <!-- Address Textarea with Autocomplete -->
                                    <textarea class="form-control" id="address" name="address" required placeholder="Enter address or pincode"
                                        oninput="fetchAddressSuggestions()" rows="3"></textarea>
                                </div>
                                <!-- Container for suggestions -->
                                <div id="suggestions-container" class="suggestions-container col-md-4"
                                    style="position: absolute; z-index: 10; width: 100%; max-height: 200px; overflow-y: auto;">
                                </div>
                            </div>


                            <!-- Gender and Date of Birth -->
                            <div class="col-md-4">
                                <label for="company_name" class="form-label fw-semibold">Company Name</label>
                                <input type="text" class="form-control" id="company_name" name="company_name" required>
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
                                <i class="bi bi-save"></i> Save
                            </button>
                            <button type="button" class="btn btn-secondary rounded-pill px-4"
                                data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card m-4">
        <div class="card-header table_headercolor text-white">
            <h5 class="mb-0">User Detail's</h5>
        </div>
        <div class="card-body">
            <div class="col-md-auto mt-2">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="all-tab" data-bs-toggle="tab" href="#all" role="tab"
                            aria-controls="all" aria-selected="true">All Users</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="Free-tab" data-bs-toggle="tab" href="#Free" role="tab"
                            aria-controls="Free" aria-selected="false">Free</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="Basic-tab" data-bs-toggle="tab" href="#Basic" role="tab"
                            aria-controls="Basic" aria-selected="false">Basic</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="Premium-tab" data-bs-toggle="tab" href="#Premium" role="tab"
                            aria-controls="Premium" aria-selected="false">Premium</a>
                    </li>
                </ul>
            </div>

            <div class="card p-3 mt-3" style="background-color: #f9f9f9; border: 1px solid #e0e0e0;">
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
            var userTable = $('#usersTable').DataTable({
                ajax: {
                    url: "/getusers",
                    type: 'GET',
                    data: function(d) {
                        // Get the selected subscription type and send as a filter parameter
                        var subscriptionType = $('.nav-tabs .nav-link.active').attr('id').replace(
                            '-tab', '');
                        d.subscription_type = subscriptionType;
                    },
                    dataSrc: function(json) {
                        return json; // Return data as is for DataTable
                    }
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
                            let actionHtml =
                                `<button class="btn btn-info me-2" onclick='viewUser(${JSON.stringify(row)})'><i class="bi bi-eye"></i></button>`;

                            // Permissions (if any)
                            if (hasManageUsersUpdate) {
                                actionHtml +=
                                    `<button class="btn btn-primary me-2" onclick='editUser(${JSON.stringify(row)})'><i class="bi bi-pencil"></i></button>`;
                            } else {
                                actionHtml +=
                                    `<button class="btn btn-secondary me-2" disabled><i class="bi bi-pencil"></i> No Permission</button>`;
                            }

                            if (hasManageUsersDelete) {
                                actionHtml +=
                                    `<button class="btn btn-danger me-2" onclick='deleteUser(${row.id})'><i class="bi bi-trash"></i></button>`;
                            } else {
                                actionHtml +=
                                    `<button class="btn btn-secondary me-2" disabled><i class="bi bi-trash"></i> No Permission</button>`;
                            }

                            return actionHtml;
                        }
                    }

                ]
            });

            // Filter data based on the selected tab
            $('#myTab a').on('click', function(e) {
                e.preventDefault();
                var tabId = $(this).attr('id').replace('-tab', '');
                userTable.ajax.reload(); // Reload DataTable with new filter
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
                $('#usersmodelLabel').text(' Add User');
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
            $('#usersmodel #last_name').val(user.last_name);
            const manageData = user.manage_users[0];
            $('#usersmodel #phone').val(manageData ? manageData.phone : 'N/A');
            $('#usersmodel #address').val(manageData ? manageData.address : 'N/A');
            $('#usersmodel #company_name').val(manageData ? manageData.company_name : 'N/A');
            $('#usersmodel #subscription_type').val(manageData ? manageData.subscription_type : 'N/A');
            $('#usersmodel #start_date').val(manageData ? manageData.start_date : 'N/A');
            $('#usersmodel #end_date').val(manageData ? manageData.end_date : 'N/A');
            $('#usersmodel #status').val(manageData ? manageData.status : 'N/A');
            $('#usersmodel input').attr('readonly', true);
            $('#usersmodel #role_id').val(user.role_id).change();
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
            $('#last_name').val(user.last_name);
            const manageData = user.manage_users[0];
            $('#phone').val(manageData ? manageData.phone : 'N/A');
            $('#address').val(manageData ? manageData.address : 'N/A');
            $('#company_name').val(manageData ? manageData.company_name : 'N/A');

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
        function fetchAddressSuggestions() {
            const address = $('#address').val().trim();

            if (address.length < 3) {
                $('#suggestions-container').html(''); // Clear previous suggestions if input is less than 3 characters
                return;
            }

            // Geoapify API key and URL
            const apiKey = '20d7d0b95e534459bae0c72805aeee9e';
            const apiUrl = `https://api.geoapify.com/v1/geocode/autocomplete?text=${address}&apiKey=${apiKey}`;

            $.ajax({
                url: apiUrl,
                method: 'GET',
                success: function(response) {
                    if (response.features && response.features.length > 0) {
                        let suggestionsHtml = '';
                        // Loop through suggestions and create a list
                        response.features.forEach(function(suggestion) {
                            const fullAddress = suggestion.properties.formatted;
                            const city = suggestion.properties.city || suggestion.properties.town ||
                                suggestion.properties.region || suggestion.properties.suburb ||
                                suggestion.properties.county || suggestion.properties.other;

                            // Create suggestion list item
                            suggestionsHtml +=
                                `<div class="suggestion-item" onclick="selectSuggestion('${fullAddress}')">${fullAddress}</div>`;
                        });

                        // Display suggestions in the container
                        $('#suggestions-container').html(suggestionsHtml);
                    } else {
                        // Optionally clear suggestions if no matches
                        $('#suggestions-container').html('<div>No suggestions found.</div>');
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was an issue fetching address suggestions. Please try again later.',
                        icon: 'error'
                    });
                }
            });
        }

        // Function to select a suggestion and update the textarea
        function selectSuggestion(address) {
            $('#address').val(address);
            $('#suggestions-container').html(''); // Clear suggestions once a selection is made
        }
    </script>

    <style>
        /* Style for suggestion items */
        .suggestion-item {
            padding: 8px;
            cursor: pointer;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            max-width: 550px;
        }

        .suggestion-item:hover {
            background-color: #e0e0e0;
        }
    </style>
@endsection
