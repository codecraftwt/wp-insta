@extends('layouts.app')

@section('content')
    <div class="container mt-5">
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
                        <p class="price">
                             <select class="currency-dropdown  custom-dropdown">
                                <option   value="usd" ${plan.currency === 'usd' ? 'selected' : ''}>$</option>
                                <option value="inr" ${plan.currency === 'inr' ? '' : ''}>₹</option>
                                <option value="eur" ${plan.currency === 'eur' ? 'selected' : ''}>€</option>
                                <option value="gbp" ${plan.currency === 'gbp' ? 'selected' : ''}>£</option>
                            </select>
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

        // $(document).ready(function() {

        //     $(document).on('change', '.currency-dropdown', function() {
        //         const selectedCurrency = $(this).val();
        //         const selectedPlanId = $(this).closest('.price-card').find('.btn-buy').data('plan-id');

        //         // Store the price card element for later use
        //         const priceCard = $(this).closest('.price-card');

        //         // Log values to debug
        //         console.log('Selected Currency:', selectedCurrency);
        //         console.log('Plan ID:', selectedPlanId);

        //         $.ajax({
        //             url: '/filterByCurrency',
        //             method: 'GET',
        //             data: {
        //                 plan_id: selectedPlanId,
        //                 currency: selectedCurrency,
        //             },
        //             success: function(response) {
        //                 // Log the response
        //                 console.log('Updated Price:', response.updated_price);

        //                 const updatedPrice = Math.round(response.updated_price);
        //                 priceCard.find('.price span').text(updatedPrice);
        //             },
        //             error: function(xhr, status, error) {
        //                 console.error('Error:', error);
        //             }
        //         });
        //     });

        //     // Initially load the monthly plans
        //     changeTab(document.getElementById('monthly-tab'));

        //     // Delegate the buy button event
        //     $('#pricing-plans').on('click', '.btn-buy', function() {
        //         const selectedPlanId = $(this).data('plan-id');
        //         const stripe_product_id = $(this).data('stripe_product_id');
        //         const plan_price = $(this).data('plan_price');
        //         const plain_title = $(this).data('plain_title');
        //         const plain_id = $(this).data('plain_id');



        //         alert('plan_price' + plan_price );

        //         const now = new Date();

        //         // Format the current date as 'YYYY-MM-DD' (no time, just date)
        //         let currentDate = now.getFullYear() + '-' +
        //             ('0' + (now.getMonth() + 1)).slice(-2) + '-' +
        //             ('0' + now.getDate()).slice(-2);

        //         // Set the formatted current date in the #start_date input
        //         $('#start_date').val(currentDate);

        //         let endDate = new Date(now);
        //         const planType = $('#myTab .nav-link.active').data('value');

        //         if (planType === 'month') {
        //             endDate.setMonth(endDate.getMonth() + 1);
        //         } else if (planType === 'year') {
        //             endDate.setFullYear(endDate.getFullYear() + 1);
        //         }

        //         // Format the end date as 'YYYY-MM-DD' (no time, just date)
        //         let formattedEndDate = endDate.getFullYear() + '-' +
        //             ('0' + (endDate.getMonth() + 1)).slice(-2) + '-' +
        //             ('0' + endDate.getDate()).slice(-2);

        //         // Set the formatted end date in the #end_date input
        //         $('#end_date').val(formattedEndDate);

        //         const selectedCurrency = $(this).closest('.price-card').find('.currency-dropdown').val();



        //         $('#plan_id').val(selectedPlanId);
        //         $('#stripe_product_id').val(stripe_product_id);
        //         $('#plan_price').val(priceCard);
        //         $('#subscription_type').val(plain_title);
        //         $('#planType').val(planType);
        //         $('#currency').val(selectedCurrency);
        //     });






        // });

        $(document).ready(function() {

            $(document).on('change', '.currency-dropdown', function() {
                const selectedCurrency = $(this).val();
                const selectedPlanId = $(this).closest('.price-card').find('.btn-buy').data('plan-id');

                // Store the price card element for later use
                const priceCard = $(this).closest('.price-card');

                // Log values to debug
                console.log('Selected Currency:', selectedCurrency);
                console.log('Plan ID:', selectedPlanId);

                $.ajax({
                    url: '/filterByCurrency',
                    method: 'GET',
                    data: {
                        plan_id: selectedPlanId,
                        currency: selectedCurrency,
                    },
                    success: function(response) {
                        // Log the response
                        console.log('Updated Price:', response.updated_price);

                        const updatedPrice = response.updated_price.toFixed(2);

                        priceCard.find('.price span').text(updatedPrice);

                        // Save the updated price in the plan price field
                        priceCard.find('.btn-buy').data('plan_price', updatedPrice);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });

            // Initially load the monthly plans
            changeTab(document.getElementById('monthly-tab'));

            // Delegate the buy button event
            $('#pricing-plans').on('click', '.btn-buy', function() {
                const selectedPlanId = $(this).data('plan-id');
                const stripe_product_id = $(this).data('stripe_product_id');
                const plan_price = $(this).data('plan_price');
                const plain_title = $(this).data('plain_title');
                const plain_id = $(this).data('plain_id');



                const now = new Date();

                // Format the current date as 'YYYY-MM-DD' (no time, just date)
                let currentDate = now.getFullYear() + '-' +
                    ('0' + (now.getMonth() + 1)).slice(-2) + '-' +
                    ('0' + now.getDate()).slice(-2);

                // Set the formatted current date in the #start_date input
                $('#start_date').val(currentDate);

                let endDate = new Date(now);
                const planType = $('#myTab .nav-link.active').data('value');

                if (planType === 'month') {
                    endDate.setMonth(endDate.getMonth() + 1);
                } else if (planType === 'year') {
                    endDate.setFullYear(endDate.getFullYear() + 1);
                }

                // Format the end date as 'YYYY-MM-DD' (no time, just date)
                let formattedEndDate = endDate.getFullYear() + '-' +
                    ('0' + (endDate.getMonth() + 1)).slice(-2) + '-' +
                    ('0' + endDate.getDate()).slice(-2);

                // Set the formatted end date in the #end_date input
                $('#end_date').val(formattedEndDate);

                const selectedCurrency = $(this).closest('.price-card').find('.currency-dropdown').val();

                $('#plan_id').val(selectedPlanId);
                $('#stripe_product_id').val(stripe_product_id);
                $('#plan_price').val(plan_price); // Use the updated price
                $('#subscription_type').val(plain_title);
                $('#planType').val(planType);
                $('#currency').val(selectedCurrency);
            });
        });
    </script>






    <script>
        $(document).ready(function() {
            $('#pricing-plans').on('click', '.btn-buy', function() {
                const selectedPlanId = $(this).data('plan-id');
                const stripeProductId = $(this).data('stripe_product_id');
                const planPrice = $(this).data('plan_price');
                const planTitle = $(this).data('plain_title');
                const planType = $(this).data('plan-type');
                const plain_id = $(this).data('plain_id');
                const selectedCurrency = $(this).closest('.price-card').find('.currency-dropdown').val();
                // Format the current date
                const now = new Date();
                let currentDate = now.getFullYear() + '-' +
                    ('0' + (now.getMonth() + 1)).slice(-2) + '-' +
                    ('0' + now.getDate()).slice(-2);

                // Set end date based on plan type (e.g., monthly or yearly)
                let endDate = new Date(now);
                if ($(this).data('plan-type') === 'month') {
                    endDate.setMonth(endDate.getMonth() + 1);
                } else if ($(this).data('plan-type') === 'year') {
                    endDate.setFullYear(endDate.getFullYear() + 1);
                }
                let formattedEndDate = endDate.getFullYear() + '-' +
                    ('0' + (endDate.getMonth() + 1)).slice(-2) + '-' +
                    ('0' + endDate.getDate()).slice(-2);

                // Build the URL with query parameters
                const registerData = {
                    plan_id: plain_id,
                    stripe_product_id: stripeProductId,
                    plan_price: planPrice,
                    subscription_type: planTitle,
                    start_date: currentDate,
                    planType: planType,
                    end_date: formattedEndDate,
                    currency: selectedCurrency
                };
                localStorage.setItem('registerData', JSON.stringify(registerData));

                // Redirect to the register page
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
    </style>
    <link href="assets/landing-css/landingstyle.css" rel="stylesheet">
@endsection
