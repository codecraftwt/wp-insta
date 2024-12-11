$(document).ready(function () {

    $('#next-btn').click(function (e) {
        e.preventDefault();

        // Fetch field values
        var selectedVersion = $('#wpVersion').find('option:selected').val();
        var siteName = $('#siteName').val().trim();
        var version_wp = $('#wpVersion').val().trim();
        var user_name = $('#user_name').val().trim();
        var password = $('#password').val().trim();
        var DomainName = $('#DomainName').val().trim();

        // Regex for Domain Name validation (only letters allowed)
        const invalidRegex = /[^a-zA-Z]/;

        // Validate if any field is empty or Domain Name is invalid
        if (!selectedVersion || !siteName || !user_name || !password || !DomainName || invalidRegex.test(DomainName)) {
            // Show error message for missing fields
            if (!selectedVersion || !siteName || !user_name || !password) {
                Swal.fire({
                    icon: 'error',
                    title: 'All fields are required!',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
            }

            // Show error for invalid Domain Name
            if (invalidRegex.test(DomainName)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Domain names can only contain letters (a-z, A-Z).',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });

                // Highlight invalid Domain Name input
                $('#DomainName').addClass('is-invalid');
                if (!$('.feedback-message').length) {
                    $('#DomainName').after(`
                        <div class="invalid-feedback feedback-message">
                            Domain names can only contain letters (a-z, A-Z). No symbols, numbers, or spaces are allowed.
                        </div>
                    `);
                }
            }

            return; // Prevent further execution
        }

        // Validate domain name availability via AJAX
        $.ajax({
            url: '/suggesstionname',
            method: 'GET',
            data: { name: DomainName },
            success: function (response) {
                if (response.status === 'taken') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Domain name is already taken!',
                        text: `Try this instead: ${response.suggestion}`,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });

                    // Highlight invalid Domain Name input
                    $('#DomainName').addClass('is-invalid');
                    if (!$('.feedback-message').length) {
                        $('#DomainName').after(`
                            <div class="invalid-feedback feedback-message">
                                This domain name is already taken. Try this instead: <strong>${response.suggestion}</strong>
                            </div>
                        `);
                    }
                    return; // Prevent further execution
                } else {
                    // Proceed with form submission if the domain name is valid and available
                    $('#loaderModal').modal('show');

                    $.ajax({
                        url: '/download-wordpress',
                        method: 'POST',
                        data: {
                            siteName: siteName,
                            version_wp: version_wp,
                            user_name: user_name,
                            password: password,
                            DomainName: DomainName,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            $('#loaderModal').modal('hide');
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: response.message,
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error: ' + response.message,
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true
                                });
                            }
                        },
                    });
                }
            }
        });
    });



    function initializeTooltips() {
        $('[data-toggle="tooltip"]').tooltip();
    }

    $.ajax({
        url: "/plugins_categories",
        method: "GET",
        success: function (response) {
            const pluginCategories = response.pluginCategories;
            $('#pluginCategoriesContainer').empty();

            if (pluginCategories.length === 0) {
                $('#pluginCategoriesContainer').append('<p>No categories available.</p>');
            } else {
                pluginCategories.forEach(function (category) {
                    $('#pluginCategoriesContainer').append(`
                        <button type="button" class="btn btn-outline-primary mb-3 w-100 selectPluginBtn"
                            style="border-radius: 5px;" data-id="${category.id}" data-name="${category.name}">
                            ${category.name}
                        </button>
                    `);
                });
            }

            $('.selectPluginBtn').on('click', function () {
                const pluginId = $(this).data('id');

                // Remove 'active' class from all buttons and reset their styles
                $('.selectPluginBtn').removeClass('active btn-primary').addClass('btn-outline-primary');

                // Add 'active' class and update the style of the clicked button
                $(this).toggleClass('active');
                $(this).addClass('btn-primary').removeClass('btn-outline-primary');

                $.ajax({
                    url: "/plugins/byCategory/" + pluginId,
                    method: "GET",
                    success: function (pluginResponse) {
                        const plugins = pluginResponse.plugins;
                        $('#pluginList').empty();

                        if (plugins.length === 0) {
                            $('#pluginList').append(
                                '<p>No plugins available in this category.</p>'
                            );
                        } else {
                            plugins.forEach(function (plugin) {
                                $('#pluginList').append(`
                                    <button type="button" class="btn btn-outline-secondary mb-1 pluginBtn"
                                        style="border-radius: 5px;" data-id="${plugin.id}" data-name="${plugin.name}" data-path="${plugin.file_path}">
                                        <strong>${plugin.name}</strong>
                                    </button>
                                `);
                            });
                        }
                    },
                    error: function (error) {
                        console.error('Error fetching plugins:', error);
                    }
                });
            });
        },
        error: function (error) {
            console.error('Error fetching plugin categories:', error);
        }
    });


    $('#pluginList').on('click', '.pluginBtn', function () {
        const pluginId = $(this).data('id');
        const pluginName = $(this).data('name');
        const pluginFilePath = $(this).data('path'); // Get the file path

        // Prevent adding duplicates
        if ($('#selectedPluginsContainer div[data-id="' + pluginId + '"]').length > 0) {
            return;
        }

        // Deselect any previously selected plugin
        $('#pluginList button.active').removeClass('btn-secondary active').addClass('btn-outline-secondary');

        // Select the current plugin
        $(this).addClass('active').removeClass('btn-outline-secondary').addClass('btn-secondary');

        // Remove default "no plugins selected" message
        if ($('#selectedPluginsContainer p:contains("No plugins selected yet.")').length > 0) {
            $('#selectedPluginsContainer').empty();
        }

        // Append the selected plugin's name and file path only
        $('#selectedPluginsContainer').append(`
            <div class="badge bg-primary text-white mr-2 mb-2 pluginBadge"
                style="border-radius: 20px; padding: 10px; position: relative;"
                data-id="${pluginId}" data-path="${pluginFilePath}" data-toggle="tooltip" title="${pluginName}">
                ${pluginName}
                <span class="badge-remove text-dark" style="position: absolute; top: -5px; right: -5px; cursor: pointer;">&times;</span>
            </div>
        `);

        initializeTooltips();
    });



    $('#selectedPluginsContainer').on('click', '.badge-remove', function () {
        const pluginId = $(this).parent().data('id');
        $(this).parent().remove();

        $('#pluginList button[data-id="' + pluginId + '"]').removeClass('btn-secondary active')
            .addClass('btn-outline-secondary');

        if ($('#selectedPluginsContainer').children().length === 0) {
            $('#selectedPluginsContainer').append('<p>No plugins selected yet.</p>');
        }
    });

    $('#siteCreationFormtwo').on('submit', function (e) {
        e.preventDefault();
        $('#loaderModal').modal('show');
        const selectedPlugins = [];
        $('#selectedPluginsContainer .pluginBadge').each(function () {
            const pluginId = $(this).data('id');
            const pluginName = $(this).text().trim(); // Only the name
            const pluginFilePath = $(this).data('path'); // Get the file path

            console.log(pluginName, pluginFilePath); // This should log only the name

            selectedPlugins.push({
                id: pluginId,
                name: pluginName,
                filePath: pluginFilePath
            });
        });

        $.ajax({
            url: '/extractplugin',
            method: 'POST',
            data: {
                plugins: selectedPlugins,
                siteName: $('#siteName').val()
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $('#loaderModal').modal('hide');
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: response.message,
                        toast: true, // Enables toast-style alert
                        position: 'top-end', // Position at the top-end of the screen
                        showConfirmButton: false, // No confirm button
                        timer: 2000, // Auto-close after 3 seconds
                        timerProgressBar: true // Display a progress bar
                    });

                } else {
                    $('#loaderModal').modal('hide');
                    Swal.fire({
                        icon: 'info', // Change to 'info' for a neutral message (no error)
                        title: 'Info: ' + response.message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });
                }
            },
            error: function (error) {
                $('#loaderModal').modal('hide');
                console.error('Error:', error);
                Swal.fire({
                    icon: 'info',
                    title: 'No Any Plugin Has Been',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
            }
        });
    });




    function renderChart(data) {
        var ctx = document.getElementById('userChart').getContext('2d');

        var chart = new Chart(ctx, {
            type: 'line', // Type of chart
            data: {
                labels: data.dates, // X-axis labels (dates)
                datasets: [{
                    label: 'Active Users',
                    data: data.userdata, // Y-axis data for active users
                    borderColor: 'rgba(75, 192, 192, 1)', // Line color for active users
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Fill color for active users
                    fill: true,
                    tension: 0.1 // Smoothness of the line
                }, {
                    label: 'Inactive Users',
                    data: data.inactiveusers, // Y-axis data for inactive users
                    borderColor: 'rgba(255, 99, 132, 1)', // Line color for inactive users
                    backgroundColor: 'rgba(255, 99, 132, 0.2)', // Fill color for inactive users
                    fill: true,
                    tension: 0.1 // Smoothness of the line
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Users'
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });
    }


    $.ajax({
        url: '/getcount',
        method: 'GET',
        success: function (data) {
            // Check if the user role is 'superadmin'
            if (authRole === 'superadmin') {

                // Updating text values for plugin and themes
                $('#plugin').text(data.plugin);
                $('#themes').text(data.themes);

                // Line chart for Active and Inactive Users
                var activeUsers = data.userdata;
                var inactiveUsers = data.inactiveusers;
                var projectedActiveUsers = activeUsers + 1;
                var projectedInactiveUsers = inactiveUsers + 1;

                var ctxLine = document.getElementById('userChart').getContext('2d');
                var userChart = new Chart(ctxLine, {
                    type: 'line',
                    data: {
                        labels: ['Current', 'Projected'],
                        datasets: [
                            {
                                label: 'Active Users',
                                data: [activeUsers, projectedActiveUsers],
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                fill: true,
                                tension: 0.1
                            },
                            {
                                label: 'Inactive Users',
                                data: [inactiveUsers, projectedInactiveUsers],
                                borderColor: 'rgba(255, 99, 132, 1)',
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                fill: true,
                                tension: 0.1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                            },
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function (value) { return value.toFixed(0); }
                                }
                            }
                        }
                    }
                });

                // Doughnut chart for User Subscription Types with counts displayed
                var subscriptionData = [data.Premium, data.Basic, data.Free];
                var total = subscriptionData.reduce((sum, value) => sum + value, 0); // Total to calculate percentages

                var ctxPie = document.getElementById('subscriptionChart').getContext('2d');
                var subscriptionChart = new Chart(ctxPie, {
                    type: 'pie',  // Pie chart
                    data: {
                        labels: ['Premium', 'Basic', 'Free'],  // Labels for each slice
                        datasets: [{
                            data: subscriptionData,  // Values for each slice
                            backgroundColor: ['#36A2EB', '#FFCE56', '#FF6384'], // Colors for each slice
                            hoverBackgroundColor: ['#36A2EB', '#FFCE56', '#FF6384'], // Hover colors
                            borderWidth: 7,
                            borderColor: '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            // Legend configuration
                            legend: {
                                position: 'top',
                                labels: {
                                    // Customize label colors in the legend
                                    generateLabels: function (chart) {
                                        var original = Chart.overrides.pie.plugins.legend.labels.generateLabels;
                                        var labels = original.call(this, chart);
                                        labels.forEach(function (label, index) {
                                            label.textColor = ['#36A2EB', '#FFCE56', '#FF6384'][index]; // Set label colors in legend
                                        });
                                        return labels;
                                    }
                                }
                            },
                            // Tooltip configuration
                            tooltip: {
                                callbacks: {
                                    label: function (tooltipItem) {
                                        const label = tooltipItem.label;
                                        const value = tooltipItem.raw;
                                        return `${label}: ${value} users`; // Show label and value in tooltip
                                    }
                                }
                            },
                            // Data Labels plugin configuration
                            datalabels: {
                                formatter: function (value, ctx) {
                                    var label = ctx.chart.data.labels[ctx.dataIndex];  // Get label for each slice
                                    return `${label}: ${value} users`;  // Format the label to show the type and count
                                },
                                color: '#fff',  // White text color for labels on pie slices
                                font: {
                                    weight: 'bold',
                                    size: 16
                                },
                                anchor: 'center',  // Position labels at the center of the slices
                                align: 'center'    // Align the text to the center
                            }
                        }
                    }
                });

            }
        }
    });



    //BAR CHART
    fetchSessionDetails();


    function fetchSessionDetails() {
        $.ajax({
            url: '/session-details',
            method: 'GET',
            success: function (data) {
                const { stoppedcount, runningCount, deletedcount } = data;
                // Update the "Add Site" button
                if (runningCount > 0) {
                    $('#createSiteButton').html('<i class="bi bi-plus-circle"></i> Add Site');
                } else {
                    $('#createSiteButton').html('<i class="bi bi-file-earmark-plus-fill"></i> Add New Site');
                }

                if (authRole === 'superadmin') {
                    // Update the staging count
                    const stagingCount = stoppedcount + runningCount + deletedcount;
                    $('#staging_count').text(stagingCount);

                    // Handle chart updates
                    const ctx = document.getElementById('siteStatusChart').getContext('2d');
                    const totalCount = runningCount + stoppedcount + deletedcount;

                    if (window.siteStatusChart instanceof Chart) {
                        window.siteStatusChart.destroy();
                    }

                    window.siteStatusChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Running', 'Stopped', 'Deleted'],
                            datasets: [{
                                data: [runningCount, stoppedcount, deletedcount],
                                backgroundColor: ['#28a745', '#dc3545', '#6c757d'],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function (tooltipItem) {
                                            const label = tooltipItem.label;
                                            const value = tooltipItem.raw;
                                            const percentage = ((value / totalCount) * 100).toFixed(2);
                                            return `${label}: ${percentage}%`;
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Status'
                                    }
                                },
                                y: {
                                    title: {
                                        display: true,
                                        text: 'Count'
                                    },
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                } else {
                    // Update counts for non-superadmin role
                    $('#staging_count').text(stoppedcount + runningCount + deletedcount);
                    $('#running_count').text(runningCount);
                    $('#stopped_count').text(stoppedcount);
                    $('#deleted_count').text(deletedcount);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching session details:', error);
            }
        });
    }

    //DELETE

    $('#userDetailsTable').on('click', '#delete-button', function () {
        const recordId = $(this).data('id');

        console.log(recordId);

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
                // AJAX request to delete the record
                $.ajax({
                    url: '/delete-site/' + recordId, // Adjust the URL based on your routing
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        // Show success message
                        Swal.fire(
                            'Deleted!',
                            'Your record has been deleted.',
                            'success'
                        );
                        fetchSessionDetails(); // Refresh the session details
                    },
                    error: function (xhr, status, error) {
                        console.error('Error deleting record:', error);
                        Swal.fire(
                            'Error!',
                            'There was an error deleting your record.',
                            'error'
                        );
                    }
                });
            }
        });
    });


    $('#all-themes').hide();
    $.ajax({
        url: '/get-categories',
        method: 'GET',
        success: function (response) {
            const categoriesContainer = $('#all-categories');
            categoriesContainer.empty();

            if (response.categories.length > 0) {
                $.each(response.categories, function (index, category) {
                    const categoryItem = `
                        <div class="category-item mb-2">
                            <button class="btn btn-outline-primary mb-1 w-100 category-btn" data-id="${category.id}" style="width: 100%; ">
                                ${category.name}
                            </button>
                        </div>
                    `;
                    categoriesContainer.append(categoryItem);
                });
            } else {
                categoriesContainer.append('<p>No categories available.</p>');
            }
        },
        error: function (xhr, status, error) {
            console.error('Error fetching categories:', error);
            $('#all-categories').html('<p>Error loading categories.</p>');
        }
    });


    $(document).on('click', '.category-btn', function (event) {
        event.preventDefault(); // Prevent the default behavior (e.g., page refresh)

        const categoryId = $(this).data('id');



        $.ajax({
            url: `/get-themes-by-category/${categoryId}`,
            method: 'GET',
            success: function (response) {
                const themesContainer = $('#all-themes');
                themesContainer.empty();

                if (response.themes.length > 0) {

                    themesContainer.show();

                    $.each(response.themes, function (index, theme) {
                        const themeItem = `
                            <div class="theme-item mb-2 theme-label" data-id="${theme.id}">
                                <input type="checkbox" name="themes" value="${theme.file_path}" data-id="${theme.id}" data-name="${theme.name}" style="display: none;">
                                <label class="" style="cursor: pointer;">${theme.name}</label>
                            </div>
                        `;
                        themesContainer.append(themeItem);
                    });
                } else {
                    themesContainer.append('<p>No themes available for this category.</p>');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching themes:', error);
                $('#all-themes').html('<p>Error loading themes.</p>');
            }
        });
    });

    $(document).on('click', '.theme-label', function (event) {
        event.preventDefault();

        const label = $(this).closest('.theme-item');
        const checkbox = label.find('input[type="checkbox"]');


        if (!checkbox.prop('checked')) {

            $('.theme-item').each(function () {
                $(this).find('input[type="checkbox"]').prop('checked', false);
                $(this).css('background-color', '');

            });


            checkbox.prop('checked', true);
            label.css('background-color', '#28a745');

        } else {

            checkbox.prop('checked', false);
            label.css('background-color', '');

        }
    });




    $(document).on('click', '#next-step3', function (e) {
        e.preventDefault();

        // Start by handling the theme extraction first
        const selectedThemes = [];
        $('input[name="themes"]:checked').each(function () {
            const themeData = {
                id: $(this).data('id'),
                name: $(this).data('name'),
                filePath: $(this).val()
            };
            selectedThemes.push(themeData);
        });

        if (selectedThemes.length > 0) {
            // Proceed to extract themes
            $.ajax({
                url: '/extract-themes',
                method: 'POST',
                data: { themes: selectedThemes },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {


                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Themes downloaded successfully!',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });

                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: 'Error: ' + response.message,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });
                    }
                },
                error: function (error) {

                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'An error occurred while downloading the themes. Please try again.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });
                }
            });
        } else {
            Swal.fire({
                icon: 'info',
                title: 'Not Any Plugin is Selected',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });
        }

        createDatabase();
    });

    // Function to create the database after theme extraction
    function createDatabase() {
        $.ajax({
            url: '/create-database', // Use the route defined earlier
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    $('#login_url_display a').attr('href', response.login_url + '/wp-login.php').text(response.login_url + '/wp-login.php');
                    $('#user_name_display').text(response.user_name);
                    $('#password_display').text(response.password);
                }

                Swal.fire({
                    icon: 'success',
                    title: response.success,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });

                // Fetch session details and refresh table after database creation
                fetchSessionDetails();
            },
            error: function (_xhr, status, error) {

                Swal.fire({
                    icon: 'error',
                    title: 'An error occurred: ' + error,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
            }
        });
    }



});



