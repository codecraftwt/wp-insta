@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Subscription Plans</h1>
    </div>

    {{-- Nav button with data attributes for passing values --}}
    <div class="d-flex justify-content-center mb-4">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="monthly-tab" data-value="month" role="tab" aria-controls="monthly"
                    aria-selected="true" onclick="changeTab(this)">Monthly</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="yearly-tab" data-value="year" role="tab" aria-controls="yearly"
                    aria-selected="false" onclick="changeTab(this)">Yearly</button>
            </li>
        </ul>
    </div>


    <section class="pricing-section">
        <div class="container">
            <div class="row" id="pricing-plans">
                <!-- Pricing cards will be injected here -->
            </div>
        </div>
    </section>


    <div class="modal fade" id="usersmodel" tabindex="-1" aria-labelledby="usersmodelLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl"> <!-- Use modal-xl for extra-large size -->
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="usersmodelLabel"><i class="bi bi-people"></i> ADD User</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="paymentform">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">User Name</label>
                                <input type="text" class="form-control" id="name" name="name" required
                                    autocomplete="off">
                                <input type="hidden" class="form-control" id="userId" name="userId">
                                <input type="hidden" class="form-control" id="plan_id" name="plan_id">
                                <input type="hidden" class="form-control" id="stripe_product_id" name="stripe_product_id">
                                <input type="hidden" class="form-control" id="plan_price" name="plan_price">
                                <input type="hidden" class="form-control" id="planType" name="planType">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required
                                    autocomplete="off">
                            </div>
                            <div class="col-md-6 mb-3" id="passcontainer">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" required
                                    autocomplete="off">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="pincode" class="form-label">Pincode</label>
                                <div class="input-group">
                                    <!-- Pincode input field -->
                                    <input type="text" class="form-control" id="pincode" name="pincode" required
                                        autocomplete="off" placeholder="Enter Pincode" onblur="fetchLocationDetails()">
                                    <!-- Button to trigger location fetch -->
                                    <button class="btn btn-primary" type="button" onclick="fetchLocationDetails()">Fetch
                                        Location</button>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="country" class="form-label">Country</label>
                                <input type="text" class="form-control" id="country" name="country" readonly
                                    autocomplete="off">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="state" class="form-label">State</label>
                                <input type="text" class="form-control" id="state" name="state" readonly
                                    autocomplete="off">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control" id="city" name="city" readonly
                                    autocomplete="off">
                            </div>

                            <!-- Pincode field -->



                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-select" id="gender" name="gender" required autocomplete="off">
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="dob" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="dob" name="dob" required
                                    autocomplete="off">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="subscription_type" class="form-label">Subscription Type</label>
                                <input type="text" class="form-control" id="subscription_type"
                                    name="subscription_type" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="datetime-local" class="form-control" id="start_date" name="start_date"
                                    required autocomplete="off">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="datetime-local" class="form-control" id="end_date" name="end_date"
                                    readonly autocomplete="off">
                            </div>


                        </div>


                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-primary " id="submitButton"> <i
                                    class="bi bi-save"></i>
                                Add User</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




    <!-- Include jQuery first, then your custom script -->


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">



    <script>
        function changeTab(tabElement) {
            const selectedPlanType = tabElement.getAttribute('data-value');

            $('.nav-link').removeClass('active');
            $(tabElement).addClass('active');

            $.ajax({
                url: '/getSubscriptiondetail',
                method: 'GET',
                data: {
                    type: selectedPlanType
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token
                },
                success: function(data) {
                    let plansHtml = '';
                    data.forEach(function(plan) {
                        if (plan.plan_type === selectedPlanType) {
                            plansHtml += `
                            <div class="col-md-4 mb-4">
                                <div class="price-card">
                                    <h2 class="plan-title">${plan.plain_title}</h2>
                                    <p class="plan-description">${plan.plan_description}</p>
                                    <p class="price"><span>${plan.plan_price}</span>/ ${plan.plan_type.charAt(0).toUpperCase() + plan.plan_type.slice(1)}</p>
                                    <ul class="pricing-features">
                                        ${plan.plan_details}
                                    </ul>
                                   <button class="btn btn-primary btn-buy" data-plan-id="${plan.id}" data-plan-type="${plan.plan_type}" data-plan_price="${plan.plan_price}" data-stripe_product_id="${plan.stripe_product_id}" data-plain_title="${plan.plain_title}"  data-bs-toggle="modal" data-bs-target="#usersmodel"
                                     id="addUserButton">Buy Now</button>
                                </div>
                            </div>
                        `;
                        }
                    });
                    $('#pricing-plans').html(plansHtml);
                },
                error: function() {
                    alert('Failed to fetch subscription details.');
                }
            });
        }

        $(document).ready(function() {
            // Initially load the monthly plans
            changeTab(document.getElementById('monthly-tab'));

            // Delegate the buy button event
            $('#pricing-plans').on('click', '.btn-buy', function() {
                const selectedPlanId = $(this).data('plan-id');
                const stripe_product_id = $(this).data('stripe_product_id');
                const plan_price = $(this).data('plan_price');
                const plain_title = $(this).data('plain_title');



                const now = new Date();


                const currentDateTime = now.toISOString().slice(0, 16);


                $('#start_date').val(currentDateTime);


                let endDate = new Date(now);
                const planType = $('#myTab .nav-link.active').data('value');

                if (planType === 'month') {
                    endDate.setMonth(endDate.getMonth() + 1);
                } else if (planType === 'year') {
                    endDate.setFullYear(endDate.getFullYear() + 1);
                }


                $('#end_date').val(endDate.toISOString().slice(0, 16));

                $('#plan_id').val(selectedPlanId);
                $('#stripe_product_id').val(stripe_product_id);
                $('#plan_price').val(plan_price);
                $('#subscription_type').val(plain_title);
                $('#planType').val(planType);

            });

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
                    url: '/subscriptionRegister',
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
                                text: "Registration successful. Redirecting to NEXT Page.",
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
        function fetchLocationDetails() {
            const pincode = $('#pincode').val().trim();

            if (!pincode) {
                return; // Don't make an API call if pincode is empty
            }

            // Geoapify API key and URL
            const apiKey = '20d7d0b95e534459bae0c72805aeee9e';
            const apiUrl = `https://api.geoapify.com/v1/geocode/search?text=${pincode}&apiKey=${apiKey}`;

            $.ajax({
                url: apiUrl,
                method: 'GET',
                success: function(response) {
                    if (response.features && response.features.length > 0) {
                        const location = response.features[0]; // Take the first matching location

                        const state = location.properties.state;
                        const country = location.properties.country;

                        // Fallback logic for city
                        let city = location.properties.city ||
                            location.properties.town ||

                            location.properties.region ||
                            location.properties.suburb ||
                            location.properties.other;



                        $('#state').val(state || '');
                        $('#country').val(country || '');


                        // Check if city exists
                        if (city) {
                            $('#city').val(city);
                            $('#city').prop('readonly', true);
                        } else {
                            $('#city').val('');
                            $('#city').prop('readonly', false);

                            Swal.fire({
                                title: 'City not found!',
                                text: 'We could not find the city for the given pincode. You can enter it manually.',
                                icon: 'warning'
                            });
                        }
                    }
                },

            });
        }
    </script>


    <style type="text/css">
        body {
            margin-top: 20px;
            font-family: 'Arial', sans-serif;
            background-color: #f0f4f8;
            /* Soft background color */

            /* Replace with your background image */
            background-size: cover;
            background-position: center;
        }

        .container {
            max-width: 1200px;
        }

        .pricing-section {
            padding: 50px 0;
        }

        .nav-tabs .nav-link {
            color: #007bff;
            border: none;
            font-weight: bold;
        }

        .nav-tabs .nav-link.active {
            background-color: #ffffff;
            color: #007bff;
            border-radius: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .price-card {
            position: relative;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            background-color: #ffffff;
            text-align: center;
            border: 1px solid #eaeaea;
            /* Light border */
            transition: all 0.3s;
        }

        .price-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .plan-title {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
        }

        .plan-description {
            color: #555555;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .price {
            font-size: 30px;
            color: #007bff;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .price span {
            font-size: 50px;
            color: #007bff;
            position: relative;
        }

        .price span:before {
            content: "₹";
            font-size: 24px;
            position: absolute;
            top: 8px;
            left: -18px;
            color: #007bff;
        }

        .pricing-features {
            padding-left: 0;
            margin-bottom: 20px;
            list-style: none;
        }

        .pricing-features li {
            font-size: 16px;
            color: #555555;
            padding: 12px 0;
            border-bottom: 1px solid #eeeeee;
            display: flex;
            align-items: center;
        }

        .pricing-features li i {
            color: #28a745;
            margin-right: 12px;
        }

        .btn-buy {
            display: inline-block;
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 25px;
            border-radius: 50px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        .btn-buy:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .plan-title {
                font-size: 20px;
            }

            .price {
                font-size: 24px;
            }

            .price span {
                font-size: 40px;
            }
        }
    </style>
@endsection
