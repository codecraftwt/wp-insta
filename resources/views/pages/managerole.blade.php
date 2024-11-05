@extends('structures.main')

@section('content')
    <div class="pagetitle mb-5 text-primary">

        <h1 class="text-center mb-4">Manage Roles</h1>

    </div>

    <div class="col-lg-12">
        <div>
            <button type="button" class="btn mb-5 btn-success" data-bs-toggle="modal" data-bs-target="#roleModal">
                <i class="bi bi-person-add"></i> Add Role
            </button>
        </div>
        <table class="managerole table table-bordered table-hover" id="managerole" style="width: 100%">
            <thead class="table-dark">
                <tr>
                    <th class="text-center">Sr.No</th>
                    <th class="text-center">Role Name</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody style="text-transform: uppercase;">

            </tbody>
        </table>
    </div>

    <div class="modal fade" id="roleModal" tabindex="-1" aria-labelledby="roleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="roleModalLabel"><i class="bi bi-plus-circle"></i> Add New Role</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="role-form">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="name" class="form-label text-primary">Role Name</label>
                            <input type="text" class="form-control border-primary" name="name" id="name"
                                placeholder="Enter Role Name" required>
                            <span id="nameError" class="text-danger"></span>
                        </div>
                        <input type="hidden" id="roleId">
                        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-save"></i> Save Role</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const table = $('#managerole').DataTable({
                ajax: {
                    url: "{{ route('getrole') }}",
                    dataSrc: 'data'
                },
                columns: [{
                        data: null,
                        render: (data, type, row, meta) => meta.row + 1
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: null,
                        render: (data, type, row) => `
                            <button class="btn btn-sm btn-danger delete-role" data-id="${row.id}">Delete</button>
                            <button class="btn btn-sm btn-primary edit-role" data-id="${row.id}" data-name="${row.name}">Edit</button>
                        `
                    }
                ]

            });

            // Add or Edit Role
            $('#role-form').on('submit', function(e) {
                e.preventDefault();
                const roleId = $('#roleId').val();
                const url = roleId ? "{{ url('roles/update') }}/" + roleId : "{{ route('roles.store') }}";

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#roleModal').modal('hide');
                        table.ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            toast: true,
                            position: 'top-end',
                            timer: 2000,
                            timerProgressBar: true
                        });
                    },
                    error: function(response) {
                        $('#nameError').text(response.responseJSON.errors?.name[0] ||
                            'An error occurred');
                    }
                });
            });

            // Edit Role
            $(document).on('click', '.edit-role', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                $('#roleId').val(id);
                $('#name').val(name);
                $('#roleModal').modal('show');
            });

            // Delete Role
            $(document).on('click', '.delete-role', function() {
                const id = $(this).data('id');
                if (confirm('Are you sure you want to delete this role?')) {
                    $.ajax({
                        url: "{{ url('roles/delete') }}/" + id,
                        type: 'DELETE',
                        success: function(response) {
                            table.ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: response.message,

                                timer: 2000,
                                timerProgressBar: true
                            });
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });

        });
    </script>
@endsection
