$(document).ready(function () {
    let installedPluginsTable = $('#installedPluginsTable').DataTable({
        ajax: {
            url: '/installed-plugins',
            dataSrc: 'installedPlugins'
        },
       
        columns: [
            { data: 'name' },
            { data: 'category_name' },
            { data: 'description' },
            {
                data: null,
                render: function (data, type, row) {
                    return `<button type="button" class="btn btn-danger btn-sm deletePluginBtn" data-name="${row.name}">Delete</button>`;
                }
            }
        ]
    });

    // Handle Delete Button Click
    $('#installedPluginsTable').on('click', '.deletePluginBtn', function () {
        const pluginName = $(this).data('name');  // Get the name of the plugin

        console.log(pluginName);  // This will log the name of the plugin, not the ID

        // Show confirmation dialog using SweetAlert
        Swal.fire({
            title: 'Are you sure?',
            text: `You won't be able to revert the deletion of ${pluginName}!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            if (result.isConfirmed) {
                // Send delete request to the server (You may still need to send the ID on the backend)
                $.ajax({
                    url: '/installed-plugins/delete', // Make sure to use the correct URL for deletion
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: { name: pluginName },  // Send the name to the server if needed
                    success: function (response) {
                        // On success, reload the DataTable to reflect the changes
                        installedPluginsTable.ajax.reload();

                        // Show success message using SweetAlert
                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                    },
                    error: function (error) {
                        console.error('Error deleting plugin:', error);

                        // Show error message using SweetAlert
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed to delete the plugin.',
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






    let wpPluginsTable = $('#wpPluginsTable').DataTable({
        ajax: {
            url: '/fetch-plugins',
            dataSrc: 'plugins'
        },
        searching: false,
        columns: [
            { data: 'name' },
            { data: 'short_description' },
            // {
            //     data: 'download_link',
            //     render: function (data, type, row) {
            // return `<button class="btn btn-success open-modal"
            //         data-url="${data}"
            //         data-slug="${row.slug}"
            //         data-short-description="${row.short_description}">Download</button>`;
            //     }
            // }
            {
                data: 'download_link',
                render: function (data, type, row) {
                    if (hasDownloadPermission) {
                        return `<button class="btn btn-success open-modal"
                            data-url="${data}"
                            data-slug="${row.slug}"
                            data-short-description="${row.short_description}">Download</button>`;
                    } else {
                        return '<span class="text-muted">No permission to download</span>';
                    }
                }
            }
        ]
    });


    // Handle the button click to open the modal
    $(document).on('click', '.open-modal', function () {
        const downloadUrl = $(this).data('url');
        const pluginSlug = $(this).data('slug'); // Ensure slug is retrieved
        const shortDescription = $(this).data('short-description'); // Retrieve the short description

        $('#pluginSlug').val(pluginSlug); // Set the slug in the hidden field
        $('#shortDescription').val(shortDescription); // Set the short description in the hidden field
        $('#downloadPluginForm').data('downloadUrl', downloadUrl); // Set the download URL
        $('#downloadPluginModal').modal('show'); // Show the modal


    });


    $('#downloadBtn').on('click', function () {
        const pluginSlug = $('#pluginSlug').val(); // Get the slug
        const downloadUrl = $('#downloadPluginForm').data('downloadUrl'); // Make sure this is set
        const categoryId = $('#pluginCategory').val();
        const shortDescription = $('#shortDescription').val(); // Get the short description

        $('#loaderModal').modal('show');

        // Check if all required values are present
        // Check if all required values are present
        if (pluginSlug && downloadUrl && categoryId && shortDescription) {
            $.ajax({
                url: '/download-plugin',
                method: 'POST',
                data: {
                    url: downloadUrl,
                    category_id: categoryId, // Send the category ID
                    slug: pluginSlug, // Send the plugin slug
                    description: shortDescription // Send the short description
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: response.success,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                    installedPluginsTable.ajax.reload(); // Reload the installed plugins table
                    $('#downloadPluginModal').modal('hide'); // Hide the modal
                    $('#loaderModal').modal('hide');
                    $('#downloadPluginForm')[0].reset();
                },
                error: function (xhr) {
                    const errorMessage = xhr.responseJSON && xhr.responseJSON.error
                        ? xhr.responseJSON.error
                        : 'An unknown error occurred.';
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                    $('#loaderModal').modal('hide');
                }
            });
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Validation Error',
                text: 'Please select a plugin category.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        }

    });




    // Re-fetch WP plugins on form submit
    $('#searchForm').on('submit', function (e) {
        e.preventDefault();
        let searchQuery = $('#searchInput').val();
        wpPluginsTable.ajax.url(`/fetch-plugins?search=${searchQuery}`).load();
    });

    // Handle the download button click
    $(document).on('click', '.download-btn', function () {
        const downloadUrl = $(this).data('url'); // Get the download URL
        const pluginDescription = $(this).data('description'); // Get the description from the button's data
        const baseUrl = `${window.location.origin}`;

        console.log(baseUrl);

        $.ajax({
            url: '/download-plugin',
            method: 'GET',
            data: {
                url: downloadUrl,
                description: pluginDescription, // Pass the description with the request
                baseUrl: baseUrl
            },
            success: function (response) {
                alert(response.success);
                installedPluginsTable.ajax.reload(); // Reload the installed plugins table after download
            },
            error: function (xhr) {
                const errorMessage = xhr.responseJSON && xhr.responseJSON.error
                    ? xhr.responseJSON.error
                    : 'An unknown error occurred.';
                alert('An error occurred: ' + errorMessage);
            }
        });
    });
});
