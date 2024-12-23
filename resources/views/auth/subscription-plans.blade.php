@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4">Subscription Plans</h1>
    </div>

    {{-- Nav bar with the currency dropdown --}}
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
            <li>
                <div class="d-flex align-items-center">
                    <select class="currency-dropdown custom-dropdown">
                        <option value="usd">$ USD</option>
                        <option value="inr">₹ INR</option>
                        <option value="eur">€ EURO</option>
                        <option value="gbp">£ POUND </option>
                    </select>
                </div>
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



    {{-- //loader --}}
    <div class="modal custom-loader-modal" id="loaderModal" tabindex="-1" aria-labelledby="loaderModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 400px; margin: auto;">
            <div class="modal-content"
                style="background: rgba(255, 255, 255, 0.57); border: none; backdrop-filter: blur(10px);">
                <div class="modal-body d-flex justify-content-center align-items-center flex-column">
                    <!-- Custom Round Loader -->
                    <div class="round-loader"></div>
                    <!-- Text -->
                    <p class="mt-3 text-dark loader-text">Please wait a moment. <i class="bi bi-wordpress"></i></p>
                </div>
            </div>
        </div>
    </div>





    <!-- Include jQuery first, then your custom script -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

    {{-- <script>
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
                                    <p class="price">
                                        <span>${plan.plan_price}</span>
                                        / ${plan.plan_type.charAt(0).toUpperCase() + plan.plan_type.slice(1)}
                                    </p>
                                    <ul class="pricing-features">
                                        ${plan.plan_details}
                                    </ul>
                                    <button class="btn btn-primary btn-buy"     data-plan-id="${plan.id}" data-plan-type="${plan.plan_type}" data-plan_price="${plan.plan_price}" data-stripe_product_id="${plan.stripe_product_id}" data-plain_title="${plan.plain_title}" data-plain_id="${plan.plain_id}"  data-bs-target="#usersmodel" id="addUserButton">Buy Now</button>
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
        changeTab(document.getElementById('monthly-tab'));
    </script>

    <script>
        $(document).ready(function() {
            function setCurrencyByRegion() {
                // Fetch region and currency data dynamically
                $.getJSON('https://ipapi.co/json/', function(data) {
                    const country = data.country_name; // Get the user's country
                    const currency = data.currency; // Get the user's currency code
                    console.log('Detected Country:', country, 'Currency:', currency);

                    // Set the default currency in the dropdown if the API provides a valid currency
                    if (currency) {
                        $('.currency-dropdown').val(currency.toLowerCase()).trigger('change');
                    } else {
                        console.warn('Currency not detected, defaulting to USD');
                        $('.currency-dropdown').val('usd').trigger('change'); // Default to USD
                    }
                }).fail(function() {
                    console.error('Failed to detect region, defaulting to USD');
                    $('.currency-dropdown').val('usd').trigger('change'); // Default to USD on error
                });
            }

            // Automatically detect and set currency on page load
            setCurrencyByRegion();

            // Handle currency change and update prices dynamically
            $(document).on('change', '.currency-dropdown', function() {
                const selectedCurrency = $(this).val();
                $('#loaderModal').modal('show');

                console.log('Selected Currency:', selectedCurrency);

                // Update prices based on selected currency
                $('#pricing-plans .price-card').each(function() {
                    const planPriceElement = $(this).find('.price span');
                    const planId = $(this).find('.btn-buy').data('plan-id');
                    const btnBuy = $(this).find('.btn-buy'); // The buy button

                    $.ajax({
                        url: '/filterByCurrency',
                        method: 'GET',
                        data: {
                            plan_id: planId,
                            currency: selectedCurrency,
                        },
                        success: function(response) {
                            const updatedPrice = response.updated_price.toFixed(2);
                            $('#loaderModal').modal('hide');

                            // Update price in UI
                            planPriceElement.text(updatedPrice);
                            btnBuy.attr('data-plan_price',
                                updatedPrice); // Update price in data attribute
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });
                });
            });

            // Handle the button click for purchase
            $('#pricing-plans').on('click', '.btn-buy', function() {
                // Extract the plan data from the clicked button
                const selectedPlanId = $(this).data('plan-id');
                const stripeProductId = $(this).data('stripe_product_id');
                let planPrice = $(this).data(
                    'plan_price'); // The updated price from the button's data attribute
                const planTitle = $(this).data('plain_title');
                const planType = $(this).data('plan-type');
                const plainId = $(this).data('plain_id');
                const selectedCurrency_1 = $('.currency-dropdown').val();


                // Get the selected currency from the closest .price-card's dropdown


                // Format the current date (start date)
                const now = new Date();
                let currentDate = now.getFullYear() + '-' +
                    ('0' + (now.getMonth() + 1)).slice(-2) + '-' +
                    ('0' + now.getDate()).slice(-2);

                // Calculate end date based on the plan type (monthly or yearly)
                let endDate = new Date(now);
                if (planType === 'month') {
                    endDate.setMonth(endDate.getMonth() + 1); // Add 1 month
                } else if (planType === 'year') {
                    endDate.setFullYear(endDate.getFullYear() + 1); // Add 1 year
                }
                let formattedEndDate = endDate.getFullYear() + '-' +
                    ('0' + (endDate.getMonth() + 1)).slice(-2) + '-' +
                    ('0' + endDate.getDate()).slice(-2);

                // Create the registerData object
                const registerData = {
                    plan_id: plainId,
                    stripe_product_id: stripeProductId,
                    plan_price: planPrice, // Updated price
                    subscription_type: planTitle,
                    start_date: currentDate,
                    plan_type: planType,
                    end_date: formattedEndDate,
                    currency: selectedCurrency_1
                };

                // Store the registerData in localStorage
                localStorage.setItem('registerData', JSON.stringify(registerData));

                // Redirect to the register page
                window.location.href = '/register';
            });
        });
    </script> --}}

    <script>
        $(document).ready(function() {
            // Function to change tabs and fetch subscription details
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
                                        <p class="price">
                                            <span>${plan.plan_price}</span>
                                            / ${plan.plan_type.charAt(0).toUpperCase() + plan.plan_type.slice(1)}
                                        </p>
                                        <ul class="pricing-features">
                                            ${plan.plan_details}
                                        </ul>
                                        <button class="btn btn-primary btn-buy" data-plan-id="${plan.id}" data-plan-type="${plan.plan_type}" data-plan_price="${plan.plan_price}" data-stripe_product_id="${plan.stripe_product_id}" data-plain_title="${plan.plain_title}" data-plain_id="${plan.plain_id}" data-bs-target="#usersmodel" id="addUserButton">Buy Now</button>
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

            // Automatically change tab on page load (for initial tab)
            changeTab(document.getElementById('monthly-tab'));

            // Function to set the currency based on user's region
            function setCurrencyByRegion() {
                $.getJSON('https://ipapi.co/json/', function(data) {
                    const country = data.country_name;
                    const currency = data.currency;
                    console.log('Detected Country:', country, 'Currency:', currency);

                    if (currency) {
                        $('.currency-dropdown').val(currency.toLowerCase()).trigger('change');
                    } else {
                        console.warn('Currency not detected, defaulting to USD');
                        $('.currency-dropdown').val('usd').trigger('change');
                    }
                }).fail(function() {
                    console.error('Failed to detect region, defaulting to USD');
                    $('.currency-dropdown').val('usd').trigger('change');
                });
            }

            // Automatically set currency on page load
            setCurrencyByRegion();

            // Handle currency change and update prices dynamically
            $(document).on('change', '.currency-dropdown', function() {
                const selectedCurrency = $(this).val();
                $('#loaderModal').modal('show');

                $('#pricing-plans .price-card').each(function() {
                    const planPriceElement = $(this).find('.price span');
                    const planId = $(this).find('.btn-buy').data('plan-id');
                    const btnBuy = $(this).find('.btn-buy');

                    $.ajax({
                        url: '/filterByCurrency',
                        method: 'GET',
                        data: {
                            plan_id: planId,
                            currency: selectedCurrency,
                        },
                        success: function(response) {
                            const updatedPrice = response.updated_price.toFixed(2);
                            $('#loaderModal').modal('hide');

                            planPriceElement.text(updatedPrice);
                            btnBuy.attr('data-plan_price',
                                updatedPrice); // Update price in data attribute
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });
                });
            });

            // Handle the button click for purchase
            $('#pricing-plans').on('click', '.btn-buy', function() {
                const selectedPlanId = $(this).data('plan-id');
                const stripeProductId = $(this).data('stripe_product_id');
                let planPrice = $(this).data('plan_price');
                const planTitle = $(this).data('plain_title');
                const planType = $(this).data('plan-type');
                const plainId = $(this).data('plain_id');
                const selectedCurrency_1 = $('.currency-dropdown').val();

                const now = new Date();
                let currentDate = now.getFullYear() + '-' + ('0' + (now.getMonth() + 1)).slice(-2) + '-' + (
                    '0' + now.getDate()).slice(-2);

                let endDate = new Date(now);
                if (planType === 'month') {
                    endDate.setMonth(endDate.getMonth() + 1); // Add 1 month
                } else if (planType === 'year') {
                    endDate.setFullYear(endDate.getFullYear() + 1); // Add 1 year
                }
                let formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth() + 1)).slice(
                    -2) + '-' + ('0' + endDate.getDate()).slice(-2);

                const registerData = {
                    plan_id: plainId,
                    stripe_product_id: stripeProductId,
                    plan_price: planPrice,
                    subscription_type: planTitle,
                    start_date: currentDate,
                    plan_type: planType,
                    end_date: formattedEndDate,
                    currency: selectedCurrency_1
                };

                // Store the registerData in localStorage and redirect
                localStorage.setItem('registerData', JSON.stringify(registerData));
                window.location.href = '/register';
            });
        });
    </script>




    <style type="text/css">
        .pricing-section {
            padding: 50px 0;
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

        .custom-dropdown {
            appearance: none;
            /* Remove default browser styling */
            border: none;
            /* Remove border */
            background-color: transparent;
            /* Transparent background */

            /* Adjust font size */
            color: #333;
            /* Text color */
            padding: 0.5rem 1rem;
            /* Add padding for better click area */
            cursor: pointer;
            /* Change cursor to pointer */
            outline: none;
            /* Remove outline when focused */
            width: auto;
            /* Make it compact */
        }

        .custom-dropdown:focus {
            outline: none;
            /* Prevent focus outline */
        }

        .custom-dropdown option {
            background-color: #f8f9fa;
            /* Light background for options */
            color: #333;
            /* Text color for options */
            padding: 0.5rem;
            /* Padding for dropdown items */
        }

        .custom-dropdown:hover {
            background-color: #f0f0f0;
            /* Light hover background */
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

        .round-loader {
            border: 5px solid rgba(0, 0, 0, 0.1);
            border-top: 5px solid #007bff;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    <link href="assets/landing-css/landingstyle.css" rel="stylesheet">
@endsection
