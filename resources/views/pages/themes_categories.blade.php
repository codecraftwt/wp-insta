@extends('structures.main')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Manage Themes Categories</h1>
    </div>

    <button type="button" id="themecata" class="btn btn-primary" data-bs-toggle="modal"
        data-bs-target="#Themes_Categories_Modal">
        <i class="bi bi-plus-circle"></i> Add Themes Category
    </button>

    <!-- Modal for Adding and Editing Categories -->
    <div class="modal fade" id="Themes_Categories_Modal" tabindex="-1" aria-labelledby="Themes_Categories_ModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="Themes_Categories_ModalLabel">Add New Themes Category</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="themesCategoryForm" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="categoryId">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="name" name="name" required
                                placeholder="Enter category name" autocomplete="off">

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="categorysave" class="btn btn-primary">Save Category</button>
                        <button type="button" id="editecategory" class="btn btn-primary">Edite Category</button>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <div class="card shadow-sm border-light rounded w-100">
            <div class="card-header table_headercolor text-white">
                <h5 class="mb-0">Themes Category List</h5>
            </div>
            <div class="card-body">
                <!-- Responsive Table -->
                <div class="table-responsive mt-3">
                    <table class="table table-striped text-center rounded mt-3" id="themescata_table" style="width: 100%">
                        <thead class="table-primary">
                            <tr>
                                <th>SR</th>
                                <th>Name</th>
                                <th>Action</th>
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
        $(document).ready(function() {
            // Handle Save (Add) Category
            $('#themesCategoryForm').on('submit', function(event) {
                event.preventDefault();

                let url = '/storethemescategories';
                let method = 'POST';

                // Check if it's an edit operation
                if ($('#categoryId').val()) {
                    url = '/updatethemescategory/' + $('#categoryId').val();
                    method = 'PUT';
                }

                $.ajax({
                    url: url,
                    type: method,
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#Themes_Categories_Modal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                            text: "Category has been saved."
                        });
                        table.ajax.reload();
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            text: xhr.responseJSON.message || 'Something went wrong!',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                    }
                });
            });

            // Handle Edithemescata_tablet Category


            // Handle Delete Category
            $(document).on('click', '.delete-btn', function() {
                let categoryId = $(this).data('id');

                // Confirm before deleting
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This category will be deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/deleteCategory/' + categoryId,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: response.message,
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true
                                });
                                table.ajax.reload();
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    text: xhr.responseJSON.message ||
                                        'Something went wrong!',
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true
                                });
                            }
                        });
                    }
                });
            });

            // Initialize DataTable
            let table = new DataTable('#themescata_table', {
                processing: false,
                serverSide: false,
                ajax: {
                    url: '/get-themes-categories',
                    type: 'GET',
                },
                columns: [{
                        data: null,
                        name: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            let buttons = '';

                            // Delete Button
                            buttons +=
                                '<button class="btn btn-danger delete-btn m-1" data-id="' + row.id +
                                '">' +
                                '<i class="bi bi-trash"></i> Delete</button>';

                            // Edit Button
                            buttons +=
                                '<button class="btn btn-success edit-btn m-1" data-id="' + row.id +
                                '">' +
                                '<i class="bi bi-pen"></i> Edit</button>';

                            return '<div class="d-flex justify-content-center">' + buttons +
                                '</div>';
                        }
                    }
                ]
            });

            $('#themescata_table').on('click', '.edit-btn', function() {
                const editId = $(this).data('id'); // Get the ID of the category to be edited

                // Make an AJAX request to get the category data
                $.ajax({
                    url: '/get-themes-category/' + editId, // Adjust the URL as needed
                    type: 'GET',
                    success: function(response) {
                        // Populate the form with the existing category data
                        $('#categoryId').val(response.id);
                        $('#name').val(response.name);
                        $('#categorysave').hide();
                        // Change the modal title and button for editing
                        $('#Themes_Categories_ModalLabel').text('Edit Themes Category');
                        // Hide the Save button
                        $('#editecategory').show(); // Show the Update button

                        // Show the modal
                        $('#Themes_Categories_Modal').modal('show');
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            text: 'Error fetching category data.',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });
                    }
                });
            });

            $('#editecategory').click(function(event) {
                event.preventDefault();
                let categoryId = $('#categoryId').val();
                let formData = $('#themesCategoryForm').serialize();

                $.ajax({
                    url: '/update-themes-category/' + categoryId,
                    type: 'PUT',
                    data: formData,
                    success: function(response) {
                        $('#Plugin_Categories_Modal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                            text: "Categories Has been Save'd"
                        });
                        table.ajax.reload();
                        $('#Themes_Categories_Modal').modal('hide');
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Failed to update category!', 'error');
                    }
                });
            });
            $('#themecata').on('click', function() {

                $('#categoryId').val('');
                $('#name').val('');


                $('#Themes_Categories_ModalLabel').text('Add Themes Category');

                $('#editecategory').hide();
                $('#categorysave').show();
            });

        });
    </script>
    <style>
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
