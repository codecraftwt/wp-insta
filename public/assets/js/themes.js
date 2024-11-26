$(document).ready(function () {


    var getthemes = $('#installedthemessTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '/getthemes',
            type: 'GET',
        },
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        columns: [
            { data: 'name', name: 'name' },
            {
                data: 'description',
                name: 'description',
                render: function (data, type, row) {
                    const words = data ? data.split(' ') : [];
                    const shortDescription = words.slice(0, 20).join(' ');
                    const fullDescription = data || 'No description available';
                    return `
                        <div class="description">
                            <span class="short-description">${shortDescription}...</span>
                            <span class="full-description" style="display: none;">${fullDescription}</span>
                            <button class="btn btn-link read-more">Read More</button>
                        </div>
                    `;
                },
                defaultContent: 'No description available'
            },
            {
                data: null,
                render: function (data, type, row) {
                    return `
                        <button type="button" class="btn btn-danger btn-sm deleteThemeBtn" data-slug="${row.slug}" data-name="${row.name}">Delete</button>
                    `;
                }
            },
        ]
    });


    // Handle Delete Button Click
    $('#installedthemessTable').on('click', '.deleteThemeBtn', function () {
        const themeSlug = $(this).data('slug');  // Get the slug of the theme
        const themeName = $(this).data('name');  // Get the name of the theme

        console.log('Theme Slug:', themeSlug);
        console.log('Theme Name:', themeName);

        // Show SweetAlert confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Send delete request to the server
                $.ajax({
                    url: '/themes/delete',  // Updated route for deletion
                    method: 'DELETE',
                    data: {
                        slug: themeSlug,  // Send the slug
                        name: themeName,  // Optionally send the name
                        _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
                    },
                    success: function (response) {
                        // On success, reload the DataTable to reflect the changes
                        getthemes.ajax.reload();

                        // SweetAlert for success
                        Swal.fire({
                            icon: 'success',
                            title: 'Theme deleted successfully!',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                    },
                    error: function (error) {
                        console.error('Error deleting theme:', error);

                        // SweetAlert for error
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed to delete the theme.',
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


    // Initialize DataTable for thems
    var tablethems = $('#themesTable').DataTable({
        processing: false,
        serverSide: false,
        searching: false,
        ajax: {
            url: '/fetch-themes',
            type: 'GET',
            data: function (d) {
                d.search = $('#searchInput').val();
            }
        },
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        columns: [
            { data: 'name', name: 'name' },
            {
                data: 'description',
                name: 'description',
                render: function (data, type, row) {
                    const words = data.split(' ');
                    const shortDescription = words.slice(0, 20).join(' ');
                    const fullDescription = data;
                    return `
                        <div class="description">
                            <span class="short-description">${shortDescription}...</span>
                            <span class="full-description" style="display: none;">${fullDescription}</span>
                            <button class="btn btn-link read-more">Read More</button>
                        </div>
                    `;
                },
                defaultContent: 'No description available'
            },
            {
                data: 'slug',
                name: 'download',
                render: function (data, type, row) {
                    if (hasDownloadPermission) {
                        return `<button class="btn btn-success download-theme" 
                                    data-slug="${data}" 
                                    data-name="${row.name}" 
                                    data-description="${row.description}">
                                    Download
                                </button>`;
                    } else {
                        return '<span class="text-muted">No permission to download</span>';
                    }
                },
                defaultContent: ''
            }
        ]
    });







    // Handle search form submit
    $('#searchForm').on('submit', function (e) {
        e.preventDefault();
        tablethems.ajax.reload();
    });

    $(document).on('click', '.read-more', function () {
        var $description = $(this).siblings('.full-description');
        var $shortDescription = $(this).siblings('.short-description');

        if ($description.is(':visible')) {
            $description.hide();
            $shortDescription.show();
            $(this).text('Read More');
        } else {
            $description.show();
            $shortDescription.hide();
            $(this).text('Show Less');
        }
    });

    $(document).on('click', '.download-theme', function (e) {
        e.preventDefault();
        var slug = $(this).data('slug');
        var name = $(this).data('name');
        var description = $(this).data('description');

        // Show the loader modal
        $('#loaderModal').modal('show');

        $.ajax({
            url: '/download-theme',
            type: 'POST',
            data: {
                slug: slug,
                name: name,
                description: description
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                // Hide the loader modal
                $('#loaderModal').modal('hide');

                // SweetAlert for success message
                Swal.fire({
                    icon: 'success',
                    title: 'Theme downloaded successfully!',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });

                // Reload the DataTable to reflect changes
                getthemes.ajax.reload();
            },
            error: function (error) {
                // Hide the loader modal
                $('#loaderModal').modal('hide');

                // SweetAlert for error message
                Swal.fire({
                    icon: 'error',
                    title: 'Error downloading theme.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            }
        });

    });




});
