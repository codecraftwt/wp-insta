    @extends('structures.main')

    @section('content')
        <div class="container">
            <h1 class="text-center p-3 mb-4 fw-bold">Permission List</h1>
        </div>


        <div class="mt-5">
            <!-- Card with shadow and light border -->
            <div class="card shadow-sm border-light rounded w-100">
                <!-- Card Header with Title -->
                <div class="card-header table_headercolor text-white">
                    <h5 class="mb-0">Permissions List</h5>
                </div>

                <!-- Card Body containing the Table -->
                <div class="card-body">
                    <!-- Responsive Table -->
                    <div class="table-responsive mt-3">
                        <table id="permissiontable" class="table table-striped table-bordered text-center"
                            style="width: 100%">
                            <thead class="table-primary">
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Name</th>
                                    <th>Guard Name</th>
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




        <div class="modal fade" id="PermissionModal" tabindex="-1" aria-labelledby="PermissionModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="PermissionModalLabel"><i class="bi bi-plus-circle"></i> Add New Role
                        </h5>
                        <button type="button" class="btn-close text-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="role-form">
                            @csrf
                            <div class="form-group mb-4">
                                <label for="name" class="form-label text-primary"> Name</label>
                                <input type="text" class="form-control border-primary" name="e_name" id="e_name"
                                    placeholder="Enter  Name" required>
                                <span id="nameError" class="text-danger"></span>
                            </div>
                            <div class="form-group mb-4">
                                <label for="guard_name" class="form-label fw-semibold">Guard Name</label>
                                <input type="text" class="form-control border-primary" name="e_gurar_name"
                                    id="e_gurar_name" placeholder="Guard Name" readonly>
                                <span id="nameError" class="text-danger"></span>
                            </div>
                            <input type="hidden" id="pId">
                            <button type="submit" class="btn btn-primary w-100"><i class="bi bi-save"></i>Save
                                Permission</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>



        <script>
            const hasAddPermissionDelete = @json(Auth::user()->hasPermission('Add Permission Delete'));
            const hasAddPermissionUpdate = @json(Auth::user()->hasPermission('Add Permission Update'));
        </script>

        <script>
            $(document).ready(function() {
                permissiontable = $('#permissiontable').DataTable({
                    ajax: {
                        url: "/getpermission",
                        type: 'GET',
                        dataSrc: 'data'
                    },
                    columns: [{
                            data: null,
                            title: "Sr.No",
                            render: function(data, type, row, meta) {
                                return meta.row + 1; // Serial number starts from 1
                            }
                        },
                        {
                            data: "name",
                            title: "Name"
                        },
                        {
                            data: "guard_name",
                            title: "Guard Name"
                        },
                        {
                            data: null,
                            title: "Actions",
                            render: function(data, type, row) {
                                let buttons = '';

                                // Check permission for update and add edit-role button
                                if (hasAddPermissionUpdate) {
                                    buttons += `
                                          <button class="btn btn-primary edit-role" data-id="${row.id}" data-name="${row.name}" data-guard-name="${row.guard_name}">
                                           <i class="bi bi-pencil"></i>
                                         </button>
                                         `;
                                } else {
                                    buttons +=
                                        `<span class="text-muted"> Need Permission</span>`;
                                }

                                // Check permission for delete and add delete-permission button
                                if (hasAddPermissionDelete) {
                                    buttons += `
                                    <button class="btn btn-danger delete-permission" data-id="${row.id}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    `;
                                } else {
                                    buttons +=
                                        ``;
                                }

                                return buttons;
                            }
                        }

                    ]
                });

                // Show modal with data when Edit button is clicked
                $(document).on('click', '.edit-role', function() {
                    const id = $(this).data('id');
                    const name = $(this).data('name');
                    const guardName = $(this).data('guard-name');

                    $('#pId').val(id);
                    $('#e_name').val(name);
                    $('#e_gurar_name').val(guardName);

                    $('#PermissionModal').modal('show');
                });

                // Handle form submission for updating the permission
                $('#role-form').submit(function(e) {
                    e.preventDefault();

                    const id = $('#pId').val();
                    const name = $('#e_name').val();
                    const guardName = $('#e_gurar_name').val();

                    $.ajax({
                        url: `/permission/${id}`,
                        type: 'PUT',
                        data: {
                            _token: $('input[name="_token"]').val(),
                            name: name,
                            guard_name: guardName
                        },
                        success: function(response) {
                            if (response.success) {
                                // Close the modal and reload the table
                                $('#PermissionModal').modal('hide');
                                permissiontable.ajax.reload();
                                alert('Permission updated successfully!');
                            } else {
                                alert('Failed to update permission!');
                            }
                        },
                        error: function() {
                            alert('Error occurred while updating permission!');
                        }
                    });
                });

                // Handle delete button click
                $(document).on('click', '.delete-permission', function() {
                    const id = $(this).data('id');

                    // Show confirmation before deleting
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You are about to delete this permission!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'No, keep it'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: `/permission-delete/${id}`,
                                type: 'DELETE',
                                data: {
                                    _token: $('input[name="_token"]').val(),
                                },
                                success: function(response) {
                                    if (response.success) {
                                        permissiontable.ajax.reload();
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Deleted!',
                                            text: 'Permission deleted successfully!',
                                            confirmButtonText: 'Ok'
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: 'Failed to delete permission!',
                                            confirmButtonText: 'Ok'
                                        });
                                    }
                                },
                                error: function() {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Error occurred while deleting permission!',
                                        confirmButtonText: 'Ok'
                                    });
                                }
                            });
                        }
                    });
                });


            });
        </script>
    @endsection
