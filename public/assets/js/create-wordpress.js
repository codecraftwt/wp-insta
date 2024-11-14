$(document).ready(function () {
    $('#next-btn').click(function (e) {
        e.preventDefault();
        var selectedVersion = $('#wpVersion').find('option:selected').val();
        var siteName = $('#siteName').val();
        var version_wp = $('#version').val();
        var user_name = $('#user_name').val();
        var password = $('#password').val();


        if (selectedVersion) {
            $('#loaderModal').modal('show');
        } else {
            $('#loaderModal').modal('hide');
            alert('No WordPress version selected. Proceeding without a specific version.');
        }

        $.ajax({
            url: '/download-wordpress',
            method: 'POST',
            data: {
                version: selectedVersion,
                siteName: siteName,
                version_wp: version_wp,
                user_name: user_name,
                password: password,



            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    alert(response.message);
                    $('#loaderModal').modal('hide');
                } else {
                    alert('Error: ' + response.message);
                }
            },
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
                        <button type="button" class="btn btn-outline-primary mb-1 w-100 selectPluginBtn"
                            style="border-radius: 5px;" data-id="${category.id}" data-name="${category.name}">
                            ${category.name}
                        </button>
                    `);
                });
            }

            $('.selectPluginBtn').on('click', function () {
                const pluginId = $(this).data('id');

                $(this).toggleClass('active');
                $(this).hasClass('active') ?
                    $(this).removeClass('btn-outline-primary').addClass('btn-primary') :
                    $(this).removeClass('btn-primary').addClass('btn-outline-primary');

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
                console.log('Response:', response);
                alert('Successfully sent the data. Check the console for response.');
            },
            error: function (error) {
                console.error('Error:', error);
                alert('An error occurred while sending the data.');
            }
        });
    });



    // Change background color on checkbox click
    $(document).on('click', '.theme-item', function () {
        const checkbox = $(this).find('input[name="themes"]');
        checkbox.prop('checked', !checkbox.prop('checked')); // Toggle checkbox checked state

        const label = $(this);
        if (checkbox.prop('checked')) {
            label.css('background-color', '#87CEEB'); // Sky blue
            label.css('color', 'white'); // Change text color
        } else {
            label.css('background-color', ''); // Reset background color
            label.css('color', ''); // Reset text color
        }
    });

    // Handle checkbox state change for background color
    $(document).on('change', 'input[name="themes"]', function () {
        const label = $(this).closest('.theme-item');
        if ($(this).prop('checked')) {
            label.css('background-color', '#87CEEB'); // Sky blue
            label.css('color', 'white'); // Change text color
        } else {
            label.css('background-color', ''); // Reset background color
            label.css('color', ''); // Reset text color
        }
    });

    // AJAX request to fetch themes
    $.ajax({
        url: '/themesforextract',
        method: 'GET',
        success: function (response) {
            const themesContainer = $('#all-themes');
            themesContainer.empty(); // Clear existing content

            // Check if themes are available
            if (response.themes.length > 0) {
                $.each(response.themes, function (index, theme) {
                    const themeItem = `
                        <div class="theme-item mb-2">
                            <input type="checkbox" name="themes" value="${theme.file_path}" data-id="${theme.id}" data-name="${theme.name}" style="display: none;">
                            <label style="cursor: pointer;">${theme.name}</label>
                        </div>
                    `;
                    themesContainer.append(themeItem);
                });
            } else {
                themesContainer.append('<p>No Themes available yet.</p>');
            }
        },
        error: function (xhr, status, error) {
            console.error('Error fetching themes:', error);
            $('#all-themes').html('<p>Error loading themes.</p>');
        }
    });

    // Handle the download button click
    $(document).on('click', '.download-themes', function (event) {
        event.preventDefault(); // Prevent default form submission
        alert("joo");

        const selectedThemes = [];

        // Gather selected theme data
        $('input[name="themes"]:checked').each(function () {
            const themeData = {
                id: $(this).data('id'), // Get the theme ID
                name: $(this).data('name'), // Get the theme name
                filePath: $(this).val() // Get the file path from the checkbox value
            };
            selectedThemes.push(themeData); // Add to the array
        });

        if (selectedThemes.length > 0) {
            const themeNames = selectedThemes.map(theme => theme.name).join(', ');
            if (confirm(`You are about to extract the following themes: ${themeNames}. Proceed?`)) {
                $.ajax({
                    url: '/extract-themes', // Your endpoint
                    method: 'POST',
                    data: { themes: selectedThemes },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.success) {
                            alert('Themes extracted and saved successfully!');
                            // Optionally refresh the theme list or perform other actions
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function (error) {
                        console.error('Error:', error);
                        alert('An error occurred while extracting themes. Please try again.');
                    }
                });
            }
        } else {
            alert('Please select at least one theme to download.');
        }
    });



    $(document).on('click', '.next-step3', function (e) {
        e.preventDefault();
        alert("HELO AND WELCOME");

        $.ajax({
            url: '/create-database', // Use the route defined earlier
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                alert(response.success);
                console.log('Database created:', response.database);

                // Fetch session details and refresh table after database creation
                fetchSessionDetails();
            },
            error: function (_xhr, status, error) {
                alert('An error occurred: ' + error);
            }
        });
    });


    fetchSessionDetails();



    function updateChartData(data) {
        // Bar chart data
        const runningCount = data.runningCount;
        const stoppedCount = data.stoppedcount;
        const deletedCount = data.deletedcount;
        const totalCount = runningCount + stoppedCount + deletedCount;

        // Data for the bar chart
        const chartData = {
            labels: ['Running', 'Stopped', 'Deleted'],
            datasets: [{
                data: [runningCount, stoppedCount, deletedCount],
                backgroundColor: ['#28a745', '#dc3545', '#6c757d'],
                borderWidth: 1
            }]
        };

        // Get the canvas context
        const ctx = document.getElementById('siteStatusChart').getContext('2d');

        // If the chart already exists, destroy it before creating a new one
        if (window.siteStatusChart instanceof Chart) {
            window.siteStatusChart.destroy();  // Destroy the existing chart 
        }

        // Create the new chart
        window.siteStatusChart = new Chart(ctx, {
            type: 'bar',
            data: chartData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false  // Bar chart typically doesn't need a legend for a single dataset
                    },
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                const label = tooltipItem.label;
                                const value = tooltipItem.raw;
                                const percentage = ((value / totalCount) * 100).toFixed(2);
                                return label + ': ' + percentage + '%';
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
    }

    function fetchSessionDetails() {
        $.ajax({
            url: '/session-details',
            method: 'GET',
            success: function (data) {
                $('#staging_count').text(data.stoppedcount + data.runningCount + data.deletedcount);

                if (data.runningCount > 0) {
                    $('#createSiteButton').html('<i class="bi bi-plus-circle"></i>  Add  Site');
                } else {
                    $('#createSiteButton').html('<i class="bi bi-file-earmark-plus-fill"></i>  Add New Site');
                }

                // Update chart with the new data
                updateChartData(data);

                // If userDetailsTable already exists, clear and destroy it
                if ($.fn.DataTable.isDataTable('#userDetailsTable')) {
                    $('#userDetailsTable').DataTable().clear().destroy();
                }

                // Re-initialize DataTable with user details
                $('#userDetailsTable').DataTable({
                    data: data.info, // Use the 'info' part of the response
                    columns: [
                        { data: 'user_name' },
                        { data: 'password' },
                        { data: 'email' },
                        {
                            data: 'login_url',
                            render: function (data) {
                                let modifiedUrl = data + '/wp-admin';
                                return '<a href="' + modifiedUrl + '" target="_blank" rel="noopener noreferrer">' + modifiedUrl + ' <i class="bi bi-box-arrow-up-right"></i></a>';
                            }
                        },
                        {
                            data: 'status',
                            render: function (data, type, row) {
                                if (data === 'DELETED') {
                                    return 'SITE HAS BEEN DELETED';
                                }
                                return `
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn">
                                            <img src="/assets/img/running.png" alt="Running" style="width: 30px; height: 30px;">
                                        </button>
                                        <button type="button" class="btn">
                                            <img src="/assets/img/stop.png" alt="Stopped" style="width: 30px; height: 30px;">
                                        </button>
                                        <button type="button" class="btn" data-id="${row.id}" id="delete-button">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </div>`;
                            }
                        }
                    ]
                });
            },
            error: function (xhr, status, error) {
                console.error('Error fetching session details:', error);
            }
        });
    }




    $.ajax({
        url: '/getcount',
        method: 'GET',
        success: function (data) {
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

            var ctxDoughnut = document.getElementById('subscriptionChart').getContext('2d');
            var subscriptionChart = new Chart(ctxDoughnut, {
                type: 'doughnut',
                data: {
                    labels: ['Premium', 'Basic', 'Free'],
                    datasets: [{
                        data: subscriptionData,
                        backgroundColor: ['#36A2EB', '#FFCE56', '#FF6384'],
                        hoverBackgroundColor: ['#36A2EB', '#FFCE56', '#FF6384'],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    cutout: '70%',  // Creates the white center
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function (tooltipItem) {
                                    const label = tooltipItem.label;
                                    const value = tooltipItem.raw;
                                    return `${label}: ${value} users`;
                                }
                            }
                        }
                    }
                }
            });
        }
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


});
