@extends('structures.main')

@section('content')
    <div class="container">
        <h1 class="fw-bold my-2 text-center">
            Manage Roles
        </h1>
    </div>
    <div class="container-fluid ">
        <div class="card mt-4 shadow-lg border-0">

            <div class="card-body">
                <form method="POST" action="{{ route('roles.store') }}" class="mt-4">
                    @csrf
                    <div class="mb-3">
                        <label for="role_name" class="form-label fw-semibold">Role Name</label>
                        <input type="text" class="form-control border-primary shadow-sm" id="role_name" name="role_name"
                            placeholder="Enter role name" required>
                    </div>

                    <div class="mb-5">
                        <h5 class="text-secondary mb-3">Assign Permissions</h5>
                        <div id="permissions" class="row g-3"></div>
                    </div>

                    <div class="text-end">
                        @if (Auth::user()->hasPermission('Manage Role Create'))
                            <button type="submit" class="btn btn-success shadow-sm px-4">
                                <i class="bi bi-save"></i> Save Role
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>



    {{-- VIEW MODEL --}}

    <div class="modal fade" id="viewRoleModal" tabindex="-1" aria-labelledby="viewRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header rounded-top"
                    style="background: linear-gradient(135deg, #d9ffdc 0%, #e0f7fa 100%);">
                    <h5 class="modal-title text-dark fw-bold" id="viewRoleModalLabel">
                        <i class="bi bi-eye-fill text-success"></i> View Role
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Role Information -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="viewRoleName" class="form-label fw-semibold">Role Name:</label>
                            <input type="text" class="form-control border-info shadow-sm" id="viewRoleName" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="viewGuardName" class="form-label fw-semibold">Guard Name:</label>
                            <input type="text" class="form-control border-info shadow-sm" id="viewGuardName" disabled>
                        </div>
                    </div>

                    <!-- Assigned Permissions -->
                    <div class="mt-4">
                        <h5 class="fw-bold text-secondary">Assigned Permissions:</h5>
                        <div id="viewPermissions" class="mt-3 border rounded p-3 shadow-sm"
                            style="background-color: #f9f9f9;">
                            <!-- Permissions will be populated here dynamically -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer rounded-bottom"
                    style="background: linear-gradient(135deg, #e0f7fa 0%, #d9ffdc 100%);">
                    <button type="button" class="btn btn-secondary shadow-sm px-4" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle-fill"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- Edit Role Modal -->
    <div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header rounded-top"
                    style="background: linear-gradient(135deg, #f0e6ff 0%, #e6f7ff 100%);">
                    <h5 class="modal-title text-dark fw-bold" id="editRoleModalLabel">
                        <i class="bi bi-pencil-fill text-primary"></i> Edit Role
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Role Name and Guard -->
                    <form id="updateRoleForm">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="editRoleName" class="form-label fw-semibold">Role Name:</label>
                                <input type="text" class="form-control border-primary shadow-sm" id="editRoleName"
                                    name="name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editGuardName" class="form-label fw-semibold">Guard Name:</label>
                                <input type="text" class="form-control border-primary shadow-sm" id="editGuardName"
                                    name="guard_name" required>
                            </div>
                        </div>

                        <!-- Permissions -->
                        <div class="mt-4">
                            <h5 class="fw-bold text-secondary mb-3">Assign Permissions:</h5>
                            <div id="permissionsContainer" class="row g-3 border rounded p-3 shadow-sm"
                                style="background-color: #f9f9f9;">
                                <!-- Permissions will be populated here dynamically -->
                            </div>
                        </div>

                        <div class="modal-footer rounded-bottom">
                            <button type="button" class="btn btn-secondary shadow-sm px-4" data-bs-dismiss="modal">
                                <i class="bi bi-x-circle-fill"></i> Close
                            </button>
                            <button type="submit" class="btn btn-primary shadow-sm px-4" id="saveChangesBtn">
                                <i class="bi bi-save-fill"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




    {{-- Roles TABLE --}}

    <div class="container-fluid px-4">
        <div class="card mt-4 shadow-sm">
            <div class="card-body">
                <h4 class="fw-bold mb-4 mt-4 text-success">Roles List</h4>
                <div class="table-responsive">
                    <!-- Make the table responsive -->
                    <table id="roletable" class="table table-bordered table-striped table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>Name</th>
                                <th>Guard Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>





    <script>
        const hasManageRoleUpdate = @json(Auth::user()->hasPermission('Manage Role Update'));
        const hasManageRoleDelete = @json(Auth::user()->hasPermission('Manage Role Delete'));
    </script>

    <script>
        $(document).ready(function() {
            // Fetch permissions using AJAX
            $.ajax({
                url: '/getpermission', // Route to fetch permissions
                method: 'GET',
                success: function(data) {
                    if (Array.isArray(data.data)) {
                        let switches = `
                <div class="d-flex flex-wrap justify-content-start mb-3">
                    <button type="button" id="saveselectallbutton" class="btn btn-primary btn-sm me-2 mb-2"> 
                        <i class="fa fa-check-circle"></i> Select All
                    </button>
                    <button type="button" id="saveselectnonebutton" class="btn btn-secondary btn-sm mb-2"> 
                        <i class="fa fa-times-circle"></i> Unselect All
                    </button>
                </div>
                <div class="row gx-2 gy-3">`; // Use Bootstrap's row with gaps

                        data.data.forEach(function(permission) {
                            switches += `
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3"> 
                        <!-- Responsive column sizes -->
                        <div class="p-2 border rounded bg-light shadow-sm">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" id="permission_${permission.id}" name="permissions[]" value="${permission.id}">
                                <label class="form-check-label fw-bold" for="permission_${permission.id}">${permission.name}</label>
                            </div>
                        </div>
                    </div>`;
                        });

                        switches += `</div>`; // Close the row
                        $('#permissions').html(switches);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching permissions:', error);
                }
            });

            // Handle Save Select All button
            $('#permissions').on('click', '#saveselectallbutton', function() {
                $('.form-check-input').prop('checked', true);
            });

            // Handle Save Deselect All button
            $('#permissions').on('click', '#saveselectnonebutton', function() {
                $('.form-check-input').prop('checked', false);
            });

            // DataTable setup
            var table = $('#roletable').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: '/get/rolepermisson',
                    type: 'GET',
                },
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'guard_name',
                        name: 'guard_name'
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            // Use a flexbox container for responsiveness
                            let buttons = `
                <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-info btn-sm view-role" data-id="${row.id}">
                        <i class="fas fa-eye"></i> View
                    </button>
                `;

                            if (hasManageRoleUpdate) {
                                buttons += `
                    <button class="btn btn-sm btn-primary edit-role" data-id="${row.id}">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                `;
                            } else {
                                buttons +=
                                    `<span class="text-muted small">Edit: Need Permission</span>`;
                            }

                            if (hasManageRoleDelete) {
                                buttons += `
                    <button class="btn btn-sm btn-danger delete-role" data-id="${row.id}">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                `;
                            } else {
                                buttons +=
                                    `<span class="text-muted small">Delete: Need Permission</span>`;
                            }

                            buttons += `</div>`;
                            return buttons;
                        },
                    },
                ],
            });

            $('#roletable').on('click', '.delete-role', function() {
                var roleId = $(this).data('id');

                // Confirm delete action
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will delete the role and its permissions.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send AJAX request to delete the role and permissions
                        $.ajax({
                            url: `roles/delete/${roleId}`, // Endpoint to delete role and associated permissions
                            method: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr(
                                    'content'), // CSRF token for protection
                                role_id: roleId
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Role Deleted',
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        timerProgressBar: true
                                    });
                                    // Remove the row from DataTable
                                    table.row($(`[data-id="${roleId}"]`).closest('tr'))
                                        .remove().draw();
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Failed to Delete',
                                        text: response.message
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'There was an error while deleting the role.'
                                });
                            }
                        });
                    }
                });
            });

            $('#roletable').on('click', '.view-role', function() {
                // Get the row data from DataTable
                const rowData = $('#roletable').DataTable().row($(this).closest('tr')).data();

                // Set role details in the modal
                $('#viewRoleName').val(rowData.name); // Set role name in input field
                $('#viewGuardName').val(rowData.guard_name); // Set guard name in input field

                // Generate checkboxes for permissions
                let permissionsContent = '';
                if (rowData.permissions && rowData.permissions.length > 0) {
                    // Create permission checkboxes
                    rowData.permissions.forEach((permission, index) => {
                        permissionsContent += `
                       <div class="col-3 mb-2">
                          <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="view_permission_${index}" value="${permission}" checked disabled>
                         <label class="form-check-label" for="view_permission_${index}">${permission}</label>
                         </div>
                     </div>
                     `;
                    });
                } else {
                    // If no permissions, display a message
                    permissionsContent =
                        '<div class="col-12"><p class="text-muted">No permissions assigned.</p></div>';
                }

                // Append permissions to the modal
                $('#viewPermissions').html(`
                     <div class="row">
                        ${permissionsContent}
                     </div>
                `);

                // Show the modal
                $('#viewRoleModal').modal('show');
            });
        });
    </script>





    {{-- <script>
        $(document).ready(function() {
            // Handle the click event on the edit button
            $('#roletable').on('click', '.edit-role', function() {
                const roleId = $(this).data('id');

                $.ajax({
                    url: '/edite-rolepermisson', // Endpoint to fetch the role details
                    method: 'GET',
                    success: function(data) {
                        const role = data.data.find(r => r.id == roleId);

                        if (role) {
                            // Set role details in the modal
                            $('#editRoleName').val(role.name);
                            $('#editGuardName').val(role.guard_name);

                            // Prepare permissions content
                            let permissionContent = '';
                            const allPermissions = Object.entries(role
                                .all_permissions
                            ); // Convert all_permissions object to array of [id, name] pairs
                            const userPermissions = role
                                .permissions; // Get user permissions (array of names)

                            // Loop through all permissions and check which are assigned
                            allPermissions.forEach(([id, name]) => {
                                let checked = userPermissions.includes(name) ?
                                    'checked' : '';
                                permissionContent += `
                                    <div class="col-3">
                                        <div class="p-2 border rounded bg-light shadow-sm">
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input permission-checkbox" id="permission_${id}" name="permissions[]" value="${id}" ${checked}>
                                                <label class="form-check-label" for="permission_${id}">${name}</label>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            });

                            // Append permissions to the modal
                            $('#permissionsContainer').html(permissionContent);

                            // Show the edit modal
                            $('#editRoleModal').modal('show');

                            // Update role and permissions when form is submitted
                            $('#updateRoleForm').on('submit', function(e) {
                                e.preventDefault();

                                // Get role name and guard name from the modal
                                const roleName = $('#editRoleName').val();
                                const guardName = $('#editGuardName').val();

                                // Collect the selected permission IDs
                                const selectedPermissions = $(
                                    '.permission-checkbox:checked').map(function() {
                                    return $(this)
                                        .val(); // Get permission IDs of checked checkboxes
                                }).get();

                                // Send an AJAX request to update the role and its permissions
                                $.ajax({
                                    url: '/update-role/' + roleId,
                                    method: 'PUT',
                                    data: {
                                        name: roleName,
                                        guard_name: guardName,
                                        permissions: selectedPermissions, // Send the selected permission IDs
                                        _token: $('meta[name="csrf-token"]')
                                            .attr('content')
                                    },
                                    success: function(response) {
                                        // SweetAlert toast notification
                                        Swal.fire({
                                            icon: 'success',
                                            title: response.message,
                                            toast: true,
                                            position: 'top-end', // Position in the top-right corner
                                            showConfirmButton: false,
                                            timer: 3000, // Duration before auto-close
                                            timerProgressBar: true // Show progress bar during the timer
                                        });
                                        // Optionally, close the modal if needed
                                        $('#editRoleModal').modal('hide');
                                    },
                                    error: function(xhr, status, error) {
                                        console.error(
                                            'Error updating role:',
                                            error);
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error updating role',
                                            toast: true,
                                            position: 'top-end',
                                            showConfirmButton: false,
                                            timer: 3000,
                                            timerProgressBar: true
                                        });
                                    }
                                });
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching role details:', error);
                    }
                });
            });
        });
    </script> --}}

    <script>
        $(document).ready(function() {
            // Handle the click event on the edit button
            $('#roletable').on('click', '.edit-role', function() {
                const roleId = $(this).data('id');

                $.ajax({
                    url: '/edite-rolepermisson', // Endpoint to fetch the role details
                    method: 'GET',
                    success: function(data) {
                        const role = data.data.find(r => r.id == roleId);

                        if (role) {
                            // Set role details in the modal
                            $('#editRoleName').val(role.name);
                            $('#editGuardName').val(role.guard_name);

                            // Prepare permissions content
                            let permissionContent = `
                        
                                <div class="d-flex mb-3">
                                    <button type="button" id="selectAllButton" class="btn btn-primary btn-sm me-2">Select All</button>
                                    <button type="button" id="deselectAllButton" class="btn btn-secondary btn-sm">Deselect All</button>
                                </div>

                            `;
                            const allPermissions = Object.entries(role
                                .all_permissions
                            ); // Convert all_permissions object to array of [id, name] pairs
                            const userPermissions = role
                                .permissions; // Get user permissions (array of names)

                            // Loop through all permissions and check which are assigned
                            allPermissions.forEach(([id, name]) => {
                                let checked = userPermissions.includes(name) ?
                                    'checked' : '';
                                permissionContent += `
                                    <div class="col-3">
                                        <div class="p-2 border rounded bg-light shadow-sm">
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input permission-checkbox" id="permission_${id}" name="permissions[]" value="${id}" ${checked}>
                                                <label class="form-check-label" for="permission_${id}">${name}</label>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            });

                            // Append permissions to the modal
                            $('#permissionsContainer').html(permissionContent);

                            // Add Select All functionality
                            $('#selectAllButton').click(function() {
                                $('.permission-checkbox').prop('checked', true);
                            });

                            // Add Deselect All functionality
                            $('#deselectAllButton').click(function() {
                                $('.permission-checkbox').prop('checked', false);
                            });

                            // Show the edit modal
                            $('#editRoleModal').modal('show');

                            // Update role and permissions when form is submitted
                            $('#updateRoleForm').off('submit').on('submit', function(e) {
                                e.preventDefault();

                                // Get role name and guard name from the modal
                                const roleName = $('#editRoleName').val();
                                const guardName = $('#editGuardName').val();

                                // Collect the selected permission IDs
                                const selectedPermissions = $(
                                    '.permission-checkbox:checked').map(function() {
                                    return $(this)
                                        .val(); // Get permission IDs of checked checkboxes
                                }).get();

                                // Send an AJAX request to update the role and its permissions
                                $.ajax({
                                    url: '/update-role/' + roleId,
                                    method: 'PUT',
                                    data: {
                                        name: roleName,
                                        guard_name: guardName,
                                        permissions: selectedPermissions, // Send the selected permission IDs
                                        _token: $('meta[name="csrf-token"]')
                                            .attr('content')
                                    },
                                    success: function(response) {
                                        // SweetAlert toast notification
                                        Swal.fire({
                                            icon: 'success',
                                            title: response.message,
                                            toast: true,
                                            position: 'top-end', // Position in the top-right corner
                                            showConfirmButton: false,
                                            timer: 3000, // Duration before auto-close
                                            timerProgressBar: true // Show progress bar during the timer
                                        });
                                        // Optionally, close the modal if needed
                                        $('#editRoleModal').modal('hide');
                                    },
                                    error: function(xhr, status, error) {
                                        console.error(
                                            'Error updating role:',
                                            error);
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error updating role',
                                            toast: true,
                                            position: 'top-end',
                                            showConfirmButton: false,
                                            timer: 3000,
                                            timerProgressBar: true
                                        });
                                    }
                                });
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching role details:', error);
                    }
                });
            });
        });
    </script>

    <style>
        /* Custom font size adjustments */
        .permission-label {
            font-size: 0.85rem;
            /* Adjust the font size */
            line-height: 1.4;
            /* Optional: Adjust line height for better spacing */
        }

        .permission-button {
            font-size: 0.85rem;
            /* Smaller button font size */
        }
    </style>
@endsection
