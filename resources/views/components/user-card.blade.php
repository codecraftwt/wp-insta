<div>
    <div class="container mt-5">
        <div class="row g-4">
            <!-- Card 1: Staging Count -->
            <div class="col-xl-3 col-lg-3 col-md-6">
                <a href="/sites-info" class="card-link">
                    <div class="card shadow-sm border-light">
                        <div class="card-body d-flex align-items-center">
                            <i class="fas fa-tasks me-3" style="font-size: 2rem; color: #6c757d;"></i>
                            <div>
                                <h5 class="card-title text-primary mb-1">Staging Count</h5>
                                <h4 class="card-text text-center " id="staging_count" style="font-size: 1.5rem;">0</h4>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Card 2: Running Count -->
            <div class="col-xl-3 col-lg-3 col-md-6">
                <a href="/sites-info" class="card-link">
                    <div class="card shadow-sm border-light">
                        <div class="card-body d-flex align-items-center">
                            <i class="fas fa-running me-3" style="font-size: 2rem; color: #28a745;"></i>
                            <div>
                                <h5 class="card-title text-primary mb-1">Running Count</h5>
                                <h4 class="card-text text-center" id="running_count" style="font-size: 1.5rem;">0</h4>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Card 3: Stopped Count -->
            <div class="col-xl-3 col-lg-3 col-md-6">
                <a href="/sites-info" class="card-link">
                    <div class="card shadow-sm border-light">
                        <div class="card-body d-flex align-items-center">
                            <i class="fas fa-pause-circle me-3" style="font-size: 2rem; color: #dc3545;"></i>
                            <div>
                                <h5 class="card-title text-primary mb-1">Stopped Count</h5>
                                <h4 class="card-text text-center" id="stopped_count" style="font-size: 1.5rem;">0</h4>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Card 4: Deleted Count -->
            <div class="col-xl-3 col-lg-3 col-md-6">
                <a href="/sites-info" class="card-link">
                    <div class="card shadow-sm border-light">
                        <div class="card-body d-flex align-items-center">
                            <i class="fas fa-trash-alt me-3" style="font-size: 2rem; color: #6c757d;"></i>
                            <div>
                                <h5 class="card-title text-primary mb-1">Deleted Count</h5>
                                <h4 class="card-text text-center" id="deleted_count" style="font-size: 1.5rem;">0</h4>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- <div class="container">
        <h3>Storage Usage</h3>
        <div>
            <strong>Total Storage Limit:</strong> <span id="storage-limit">Loading...</span>
        </div>
        <div>
            <strong>Total Used Storage:</strong> <span id="total-used-storage">Loading...</span>
        </div>

        <div class="progress" style="height: 30px;">
            <div id="progress-bar" class="progress-bar" role="progressbar" style="width: 0%; background-color: #f0f0f0;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                0% Used
            </div>
        </div>
    </div> -->


    <!-- <div class="container">
        <h3>Storage Usage</h3>
        <div>
            <p>Total Storage: {{ $userStorage['total_storage'] }} </p>
            <p>Database Storage: {{ $userStorage['database_storage'] }} </p>
            <p>Total Usage: {{ $userStorage['totalusages'] }} </p>
            <p>Storage Limit: {{ $userStorage['storage'] }} </p>
            <p>Number of Sites: {{ $userStorage['usersite'] }}</p>
        </div>

        <div class="progress" style="height: 30px;">
            <div id="progress-bar" class="progress-bar" role="progressbar"
                style="width: 0%; background-color: #f0f0f0;"
                aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                0% Used
            </div>
        </div>
    </div> -->

    <div class="container mt-4">
        <!-- Card Start -->
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Storage Usage</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Left Column with Storage Info -->
                    <div class="col-md-6">
                        <p><strong>Total Storage:</strong> {{ $userStorage['total_storage'] }} </p>
                        <p><strong>Database Storage:</strong> {{ $userStorage['database_storage'] }} </p>
                        <p><strong>Total Usage:</strong> {{ $userStorage['totalusages'] }} </p>
                        <p><strong>Storage Limit:</strong> {{ $userStorage['storage'] }} </p>
                        <p><strong>Number of Sites:</strong> {{ $userStorage['usersite'] }}</p>
                    </div>

                    <!-- Right Column with Progress Bar -->
                    <div class="col-md-6">
                        <div class="progress" style="height: 30px;">
                            <div id="progress-bar" class="progress-bar" role="progressbar"
                                style="width: 0%; background-color: #f0f0f0;"
                                aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                0% Used
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-muted text-center">
                Storage details and usage.
            </div>
        </div>

    </div>


    <script>
        $(document).ready(function() {
            // Data from the backend (ensure the values are in the right format, GB or MB)
            var totalStorage = "{{ $userStorage['storage'] }}"; // Total storage limit (formatted as GB or MB)
            var usedStorage = "{{ $userStorage['totalusages'] }}"; // Used storage (formatted as GB or MB)

            // Extract numerical value and unit (GB, MB)
            var totalStorageValue = parseFloat(totalStorage);
            var usedStorageValue = parseFloat(usedStorage);
            var totalStorageUnit = totalStorage.replace(totalStorageValue, '').trim(); // e.g., 'GB' or 'MB'
            var usedStorageUnit = usedStorage.replace(usedStorageValue, '').trim(); // e.g., 'GB' or 'MB'

            // Check if the values are valid numbers
            if (isNaN(totalStorageValue) || isNaN(usedStorageValue)) {
                console.error('Invalid storage data received');
                return;
            }

            // If the units are different (GB vs MB), convert them to the same unit for calculation
            if (totalStorageUnit !== usedStorageUnit) {
                if (totalStorageUnit === 'GB' && usedStorageUnit === 'MB') {
                    usedStorageValue = usedStorageValue / 1024; // Convert MB to GB
                } else if (totalStorageUnit === 'MB' && usedStorageUnit === 'GB') {
                    totalStorageValue = totalStorageValue * 1024; // Convert GB to MB
                }
            }

            // Calculate the usage percentage
            var usagePercentage = (usedStorageValue / totalStorageValue) * 100;

            // If usage percentage is too small, set a minimum value to ensure visibility
            if (usagePercentage < 1) {
                usagePercentage = 1; // Set a minimum of 1% usage to make progress bar visible
            }

            // Update the progress bar width and aria-valuenow
            $('#progress-bar').css('width', usagePercentage + '%');
            $('#progress-bar').attr('aria-valuenow', usagePercentage);

            // Adjust progress bar color based on usage percentage
            if (usagePercentage <= 30) {
                $('#progress-bar').css('background-color', 'green');
            } else if (usagePercentage <= 60) {
                $('#progress-bar').css('background-color', 'yellow');
            } else {
                $('#progress-bar').css('background-color', 'red');
            }

            // Update the progress bar text with the usage percentage
            $('#progress-bar').text(usagePercentage.toFixed(2) + '% Used');

            // Log values for debugging
            console.log('Total Storage:', totalStorage);
            console.log('Used Storage:', usedStorage);
            console.log('Usage Percentage:', usagePercentage.toFixed(2));
        });
    </script>




    <!-- 
    <script>
        $(document).ready(function() {

            $.ajax({
                url: '/storage-user', // Route to your controller method
                method: 'GET',
                success: function(response) {

                    var totalStorageGB = parseFloat(response.storage);
                    var usedStorageMB = parseFloat(response.totalusages);

                    // Check if the values are valid numbers
                    if (isNaN(totalStorageGB) || isNaN(usedStorageMB)) {
                        console.error('Invalid storage data received');
                        return;
                    }


                    var totalStorageMB = totalStorageGB * 1024;

                    // Calculate usage percentage
                    var usagePercentage = (usedStorageMB / totalStorageMB) * 100;

                    // Update the storage limit and used storage values
                    $('#storage-limit').text(totalStorageGB + ' GB');
                    $('#total-used-storage').text(response.totalusages);


                    $('#progress-bar').css('width', usagePercentage + '%');
                    $('#progress-bar').attr('aria-valuenow', usagePercentage);


                    if (usagePercentage <= 30) {
                        $('#progress-bar').css('background-color', 'green');
                    } else if (usagePercentage <= 60) {
                        $('#progress-bar').css('background-color', 'yellow');
                    } else {
                        $('#progress-bar').css('background-color', 'red');
                    }

                    // Update the progress bar text with the usage percentage
                    $('#progress-bar').text(usagePercentage.toFixed(2) + '% Used');

                    console.log('Usage Percentage: ' + usagePercentage.toFixed(2) + '%');
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching storage data:', error);
                }
            });
        });
    </script> -->

    <!-- 

    <script>
        $(document).ready(function() {
            $.ajax({
                url: '/storage-user',
                method: 'GET',
                success: function(response) {
                    var totalStorageGB = parseFloat(response.storage);
                    var usedStorageMB = parseFloat(response.totalusages);

                    // Check if the values are valid numbers
                    if (isNaN(totalStorageGB) || isNaN(usedStorageMB)) {
                        console.error('Invalid storage data received');
                        return;
                    }

                    var totalStorageMB = totalStorageGB * 1024;
                    var usagePercentage = (usedStorageMB / totalStorageMB) * 100;

                    // Format used storage for display
                    var formattedUsedStorage;
                    if (usedStorageMB >= 1024) {
                        formattedUsedStorage = (usedStorageMB / 1024).toFixed(2) + ' GB';
                    } else {
                        formattedUsedStorage = usedStorageMB.toFixed(2) + ' MB';
                    }

                    // Update the storage limit and used storage values
                    $('#storage-limit').text(totalStorageGB + ' GB');
                    $('#total-used-storage').text(formattedUsedStorage);

                    $('#progress-bar').css('width', usagePercentage + '%');
                    $('#progress-bar').attr('aria-valuenow', usagePercentage);

                    if (usagePercentage <= 30) {
                        $('#progress-bar').css('background-color', 'green');
                    } else if (usagePercentage <= 60) {
                        $('#progress-bar').css('background-color', 'yellow');
                    } else {
                        $('#progress-bar').css('background-color', 'red');
                    }

                    // Update the progress bar text with the usage percentage
                    $('#progress-bar').text(usagePercentage.toFixed(2) + '% Used');

                    console.log('Usage Percentage: ' + usagePercentage.toFixed(2) + '%');
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching storage data:', error);
                }
            });
        });
    </script> -->
</div>