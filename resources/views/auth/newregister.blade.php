<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $siteSetting->site_title ?? 'WalstarWp' }}</title>
    <link rel="icon" href="https://www.walstartechnologies.com/wp-content/uploads/2024/09/Favicons3-150x150.png"
        sizes="32x32" />
    <link rel="icon" href="https://www.walstartechnologies.com/wp-content/uploads/2024/09/Favicons3-300x300.png"
        sizes="192x192" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">


    <style>
        body {

            font-family: 'Arial', sans-serif;
        }

        h2 {
            font-family: 'Poppins', sans-serif;
            font-weight: 900;
            font-size: 2rem;
            color: #3A5A9F;
            /* Vibrant blue */
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 20px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        }


        .container {
            max-width: 900px;
            margin: 20px auto;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-header {

            color: #fff;
            text-align: center;
            padding: 20px 10px;
            border-bottom: 0;
        }

        .card-header h4 {
            margin: 0;
            font-weight: bold;
        }

        .form-label {
            color: #333;
            font-weight: 500;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #ddd;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #4facfe;
            box-shadow: 0 0 5px rgba(79, 172, 254, 0.5);
        }

        .btn-primary {
            background-color: #4facfe;
            border: none;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #3a90da;
        }

        .btn-secondary {
            border-radius: 25px;
        }

        .bg-light {
            background: #f8f9fa;
        }

        #planDetails {
            text-align: center;
            padding: 10px;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.1);
        }

        #planDetails .plan-info h5 {
            color: #555;
        }

        #planDetails .plan-info p {
            color: #4facfe;
            font-size: 1.2rem;
            font-weight: bold;
        }



        .suggestions-container {
            position: absolute;
            z-index: 10;
            max-width: 32%;
            max-height: 150px;
            overflow-y: auto;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
        }

        .suggestion-item {
            padding: 8px;
            cursor: pointer;
            background-color: #f9f9f9;
            border-bottom: 1px solid #ddd;

            max-width: 400px;

        }

        .suggestion-item:last-child {
            border-bottom: none;

        }

        .suggestion-item:hover {
            background-color: #e0e0e0;

        }
    </style>

</head>

<body>
    <div class="container mt-3 text-center">
        <h2 class="fw-bold">User Registration Form</h2>
    </div>

    <div class="container mt-5 mb-5">
        <div class="card">
            <div class="card-header">
                <h4>Create Account</h4>
            </div>
            <div class="card-body">
                <form id="paymentform">
                    @csrf
                    <div class="row">
                        <!-- Main form section (left side) -->
                        <div class="col-md-8">
                            <div class="row">
                                <!-- First Name -->
                                <div class="col-md-6 mb-4">
                                    <label for="name" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required
                                        autocomplete="off">
                                    <input type="hidden" class="form-control" id="userId" name="userId">
                                    <input type="hidden" class="form-control" id="plan_id" name="plan_id">
                                    <input type="hidden" class="form-control" id="stripe_product_id"
                                        name="stripe_product_id">
                                    <input type="hidden" class="form-control" id="plan_price" name="plan_price">
                                    <input type="hidden" class="form-control" id="planType" name="planType">
                                    <input type="hidden" class="form-control" id="start_date" name="start_date"
                                        required autocomplete="off">
                                    <input type="hidden" class="form-control" id="subscription_type"
                                        name="subscription_type">
                                    <input type="hidden" class="form-control" id="end_date" name="end_date"
                                        autocomplete="off">
                                </div>

                                <!-- Last Name -->
                                <div class="col-md-6 mb-4">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" required
                                        autocomplete="off">
                                </div>

                                <!-- Email -->
                                <div class="col-md-6 mb-4">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required
                                        autocomplete="off">
                                </div>

                                <!-- Password -->
                                <div class="col-md-6 mb-4" id="passcontainer">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>

                                <!-- Phone -->
                                <div class="col-md-6 mb-4">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone" required
                                        autocomplete="off">
                                </div>

                                <!-- Address Details -->
                                <div class="col-md-6 mb-4">
                                    <label for="address" class="form-label">Address</label>
                                    <div class="input-group">
                                        <textarea class="form-control" id="address" name="address" required placeholder="Enter address or pincode"
                                            oninput="fetchAddressSuggestions()" rows="3"></textarea>
                                    </div>
                                    <!-- Container for suggestions -->
                                    <div id="suggestions-container" class="suggestions-container">
                                    </div>
                                </div>

                                <!-- Company Name -->
                                <div class="col-md-6 mb-4">
                                    <label for="company_name" class="form-label">Company Name</label>
                                    <input type="text" class="form-control" id="company_name" name="company_name"
                                        autocomplete="off">
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex justify-content-start">
                                <button type="submit" class="btn btn-primary me-2" id="submitButton">
                                    <i class="bi bi-save"></i> Register
                                </button>
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>

                        <!-- Dynamic content section (right side) -->
                        <div class="col-md-4 bg-light border-start" style="padding: 20px;">
                            <div id="planDetails">
                                <div class="plan-info mb-3">
                                    <h5 class="text-muted fw-bold">Plan Price</h5>
                                    <p class="lead" id="plan_price_title">$0.00</p>
                                </div>

                                <div class="plan-info mb-3">
                                    <h5 class="text-muted fw-bold">Subscription Type</h5>
                                    <p id="dynamic_subscription_type" class="lead">-</p>
                                </div>

                                <div class="plan-info mb-3">
                                    <h5 class="text-muted fw-bold">Plan Type</h5>
                                    <p id="dynamic_plan_type" class="lead">-</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>







    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">


    <script>
        window.onload = function() {
            // Retrieve the register data from localStorage
            const registerData = JSON.parse(localStorage.getItem('registerData'));

            // Check if the data exists
            if (registerData) {
                // Set the form values based on the retrieved registerData
                document.getElementById('plan_id').value = registerData.plan_id;
                document.getElementById('stripe_product_id').value = registerData.stripe_product_id;
                document.getElementById('plan_price').value = registerData.plan_price;
                document.getElementById('plan_price_title').textContent = `$ ${registerData.plan_price}`;

                document.getElementById('subscription_type').value = registerData.subscription_type;
                document.getElementById('dynamic_subscription_type').textContent = registerData.subscription_type;
                document.getElementById('planType').value = registerData.planType;
                document.getElementById('dynamic_plan_type').textContent =
                    registerData.planType.charAt(0).toUpperCase() + registerData.planType.slice(1).toLowerCase();

                document.getElementById('start_date').value = registerData.start_date;
                document.getElementById('end_date').value = registerData.end_date;
            }
        };
    </script>
    <script>
        $(document).ready(function() {


            $('#paymentform').on('submit', function(event) {
                event.preventDefault();

                var formData = JSON.stringify($(this).serializeArray().reduce((acc, {
                    name,
                    value
                }) => {
                    acc[name] = value;
                    return acc;
                }, {}));

                $.ajax({
                    url: 'userRegister',
                    type: 'POST',
                    data: formData,
                    contentType: 'application/json', // Correctly set to JSON
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token
                    },
                    success: function(response) {
                        if (response.redirect_url) {
                            // Show success message
                            Swal.fire({
                                title: "Success!",
                                text: "Form Has Been Saved",
                                icon: "success",
                                timer: 2000, // Display for 2 seconds
                                showConfirmButton: false // Hide the confirm button
                            });

                            // Redirect after a delay
                            setTimeout(function() {
                                window.location.href = response.redirect_url;
                            }, 2000);
                        } else {
                            // Show warning message if no redirect URL is provided
                            Swal.fire({
                                title: "Warning!",
                                text: "Registration successful, but no redirect URL provided.",
                                icon: "warning",
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        // Show error message
                        Swal.fire({
                            title: "Error!",
                            text: "An error occurred: " + xhr.responseText,
                            icon: "error",
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
            });

        });
    </script>

    <script>
        function fetchAddressSuggestions() {
            const address = $('#address').val().trim();

            if (address.length < 3) {
                $('#suggestions-container').html(''); // Clear previous suggestions if input is less than 3 characters
                return;
            }

            // Geoapify API key and URL
            const apiKey = '20d7d0b95e534459bae0c72805aeee9e';
            const apiUrl = `https://api.geoapify.com/v1/geocode/autocomplete?text=${address}&apiKey=${apiKey}`;

            $.ajax({
                url: apiUrl,
                method: 'GET',
                success: function(response) {
                    if (response.features && response.features.length > 0) {
                        let suggestionsHtml = '';
                        // Loop through suggestions and create a list
                        response.features.forEach(function(suggestion) {
                            const fullAddress = suggestion.properties.formatted;
                            const city = suggestion.properties.city || suggestion.properties.town ||
                                suggestion.properties.region || suggestion.properties.suburb ||
                                suggestion.properties.county || suggestion.properties.other;

                            // Create suggestion list item
                            suggestionsHtml +=
                                `<div class="suggestion-item" onclick="selectSuggestion('${fullAddress}')">${fullAddress}</div>`;
                        });

                        // Display suggestions in the container
                        $('#suggestions-container').html(suggestionsHtml);
                    } else {
                        // Optionally clear suggestions if no matches
                        $('#suggestions-container').html('<div>No suggestions found.</div>');
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was an issue fetching address suggestions. Please try again later.',
                        icon: 'error'
                    });
                }
            });
        }

        // Function to select a suggestion and update the textarea
        function selectSuggestion(address) {
            $('#address').val(address);
            $('#suggestions-container').html(''); // Clear suggestions once a selection is made
        }
    </script>

</body>

</html>
