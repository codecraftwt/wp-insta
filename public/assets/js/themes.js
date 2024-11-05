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
        ]
    });



    // Initialize DataTable for thems
    var tablethems = $('#themesTable').DataTable({
        processing: false,
        serverSide: false,
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
                    return '<button class="btn btn-success download-theme" data-slug="' + data + '" data-name="' + row.name + '" data-description="' + row.description + '">Download</button>';
                }
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
                alert('Theme downloaded successfully!');
                getthemes.ajax.reload();
            },
            error: function (error) {
                // Hide the loader modal
                $('#loaderModal').modal('hide');
                alert('Error downloading theme.');
            }
        });
    });




});
