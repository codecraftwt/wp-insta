@extends('layouts.app')

@section('content')
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
                                    <label for="name" class="form-label">First Name <span
                                            class="required_star">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" required
                                        autocomplete="off" placeholder="Enter Your First Name">
                                    <input type="hidden" id="userId" name="userId">
                                    <input type="hidden" id="plan_id" name="plan_id">
                                    <input type="hidden" id="stripe_product_id" name="stripe_product_id">
                                    <input type="hidden" id="plan_price" name="plan_price">
                                    <input type="hidden" id="planType" name="planType">
                                    <input type="hidden" id="start_date" name="start_date" required autocomplete="off">
                                    <input type="hidden" id="subscription_type" name="subscription_type">
                                    <input type="hidden" id="end_date" name="end_date" autocomplete="off">
                                    <input type="hidden" id="currency" name="currency" />
                                    <input type="hidden" id="no_sites" name="no_sites" />
                                    <input type="hidden" id="storage" name="storage" />
                                  
                                </div>

                                <!-- Last Name -->
                                <div class="col-md-6 mb-4">
                                    <label for="last_name" class="form-label">Last Name <span
                                            class="required_star">*</span></label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" required
                                        autocomplete="off" placeholder="Enter Your Last Name">
                                </div>

                                <!-- Email -->
                                <div class="col-md-6 mb-4">
                                    <label for="email" class="form-label">Email <span
                                            class="required_star">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required
                                        autocomplete="off" placeholder="Enter Your Email">
                                </div>

                                <!-- Password -->
                                <div class="col-md-6 mb-4">
                                    <label for="password" class="form-label">Password <span
                                            class="required_star">*</span></label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Enter Your Password ">
                                </div>

                                <!-- Phone -->
                                <div class="col-md-6 mb-4">
                                    <label for="phone" class="form-label">Phone <span
                                            class="required_star">*</span></label>
                                    <input type="text" class="form-control" id="phone" name="phone" required
                                        autocomplete="off" placeholder="Enter Phone Number">
                                </div>

                                <!-- Address Details -->
                                <div class="col-md-6 mb-4">
                                    <label for="address" class="form-label">Address <span
                                            class="required_star">*</span></label>
                                    <div class="input-group">
                                        <textarea class="form-control" id="address" name="address" required placeholder="Enter address or pincode"
                                            oninput="fetchAddressSuggestions()" rows="3"></textarea>
                                    </div>
                                    <div id="suggestions-container" class="suggestions-container"></div>
                                </div>

                                <!-- Company Name -->
                                <div class="col-md-6 mb-4">
                                    <label for="company_name" class="form-label">Company Name</label>
                                    <input type="text" class="form-control" id="company_name" name="company_name"
                                        autocomplete="off" placeholder="Enter Company Number">
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex justify-content-start">
                                <button type="submit" class="btn btn-primary me-2" id="submitButton">
                                    <i class="bi bi-save"></i> Register
                                </button>
                                <a href="subscription-plans"><button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Back</button></a>
                            </div>
                        </div>

                        <!-- Dynamic content section (right side) -->
                        <div class="col-md-4 bg-light border-start" style="padding: 20px;">
                            <div id="planDetails">
                                <div class="plan-info mb-3">
                                    <h5 class="text-muted">Plan Price</h5>
                                    <p class="lead" id="plan_price_title">$0.00</p>
                                </div>

                                <div class="plan-info mb-3">
                                    <h5 class="text-muted">Subscription Type</h5>
                                    <p id="dynamic_subscription_type" class="lead">-</p>
                                </div>

                                <div class="plan-info mb-3">
                                    <h5 class="text-muted">Plan Type</h5>
                                    <p id="dynamic_plan_type" class="lead">-</p>
                                </div>
                                <div class="plan-info mb-3">
                                    <h5 class="text-muted">Apply coupon</h5>
                                    <input type="text" class="form-control text-center" id="coupon" name="coupon"
                                        autocomplete="off" placeholder="Apply Coupon">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Loader --}}
    <div class="modal fade" id="loaderModal" tabindex="-1" aria-labelledby="loaderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p>Please wait...</p>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>



    <script>
        window.onload = function() {
            // Retrieve the register data from localStorage
            const registerData = JSON.parse(localStorage.getItem('registerData'));

            // Check if the data exists
            if (registerData) {
                // Set the form values based on the retrieved registerData
                document.getElementById('plan_id').value = registerData.plan_id;
                document.getElementById('currency').value = registerData.currency;
                document.getElementById('stripe_product_id').value = registerData.stripe_product_id;

                let planPrice = registerData.plan_price;

                // Store the currency symbol based on the currency
                const selectedCurrency_1 = registerData.currency;

                // Set the currency symbol based on the selected currency
                let currencySymbol;

                switch (selectedCurrency_1) {
                    case 'inr':
                        currencySymbol = '₹'; // Indian Rupee
                        break;
                    case 'usd':
                        currencySymbol = '$'; // US Dollar
                        break;
                    case 'eur':
                        currencySymbol = '€'; // Euro
                        break;
                    case 'gbp':
                        currencySymbol = '£'; // British Pound
                        break;
                    default:
                        currencySymbol = '$'; // Default to USD if no match
                }



                // Set the plan price and display it with the correct currency symbol
                document.getElementById('plan_price').value = planPrice;
                document.getElementById('no_sites').value = registerData.no_sites;
                document.getElementById('storage').value = registerData.storage;

                document.getElementById('plan_price_title').textContent = `${currencySymbol} ${planPrice}`;

                document.getElementById('subscription_type').value = registerData.subscription_type;
                document.getElementById('dynamic_subscription_type').textContent = registerData.subscription_type;
                document.getElementById('planType').value = registerData.plan_type;
                document.getElementById('dynamic_plan_type').textContent =
                    registerData.plan_type.charAt(0).toUpperCase() + registerData.plan_type.slice(1).toLowerCase();
                if (document.getElementById('start_date')) {
                    document.getElementById('start_date').value = registerData.start_date;
                }
                if (document.getElementById('end_date')) {
                    document.getElementById('end_date').value = registerData.end_date;
                }
            }
        };
    </script>


    <script>
        $(document).ready(function() {


            $('#paymentform').on('submit', function(event) {
                event.preventDefault();

                $('#loaderModal').modal('show');

                var formData = JSON.stringify($(this).serializeArray().reduce((acc, {
                    name,
                    value
                }) => {
                    acc[name] = value;
                    return acc;
                }, {}));

                var couponCode = $('#coupon').val();
                var currency = $('#currency').val();
                $.ajax({
                    url: '/userRegister',
                    type: 'POST',
                    data: JSON.stringify({
                        ...JSON.parse(formData), // Merge form data with coupon data
                        coupon: couponCode,
                        currency: currency
                    }),
                    contentType: 'application/json', // Correctly set to JSON
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token
                    },
                    success: function(response) {
                        $('#loaderModal').modal('hide');
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

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fb;
            color: #333;
        }

        h2 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 2.2rem;
            color: #007bff;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 20px;
            text-shadow: 1px 1px 6px rgba(0, 0, 0, 0.1);
        }

        .container {
            max-width: 1200px;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            font-size: 1.4rem;
            padding: 15px 25px;
            border-radius: 15px 15px 0 0;
        }

        .card-body {
            padding: 30px;
            background-color: #fff;
            border-radius: 0 0 15px 15px;
        }

        .form-label {
            font-weight: bold;
            color: #444;
        }

        .form-control {
            border-radius: 10px;
            box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.1);
        }

        .required_star {
            color: red;
        }


        .btn-secondary {
            background-color: #6c757d;
            border: none;
            padding: 12px 25px;
            font-weight: 600;
            border-radius: 10px;
            text-transform: uppercase;
            transition: background-color 0.3s;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .suggestions-container {
            position: absolute;
            z-index: 10;
            max-width: 100%;
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

        #planDetails {
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.1);
        }

        .plan-info h5 {
            color: #555;
            font-weight: 600;
        }

        .plan-info p {
            color: #007bff;
            font-size: 1.4rem;
            font-weight: bold;
        }

        .plan-info input {
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 10px;
            font-size: 1.1rem;
        }
    </style>
@endsection
