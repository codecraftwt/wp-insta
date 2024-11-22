$(document).ready(function () {
    let installedPluginsTable = $('#installedPluginsTable').DataTable({
        ajax: {
            url: '/installed-plugins',
            dataSrc: 'installedPlugins'
        },
        searching: false,
        lengthChange: false,
        columns: [
            { data: 'name' },
            { data: 'category_name' },
            { data: 'description' },

        ]
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
                    alert(response.success);
                    installedPluginsTable.ajax.reload(); // Reload the installed plugins table
                    $('#downloadPluginModal').modal('hide'); // Hide the modal
                    $('#loaderModal').modal('hide');
                    $('#downloadPluginForm')[0].reset();
                },
                error: function (xhr) {
                    const errorMessage = xhr.responseJSON && xhr.responseJSON.error
                        ? xhr.responseJSON.error
                        : 'An unknown error occurred.';
                    alert('An error occurred: ' + errorMessage);
                    $('#loaderModal').modal('hide');
                }
            });
        } else {
            alert('Please select a plugin category.');
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
