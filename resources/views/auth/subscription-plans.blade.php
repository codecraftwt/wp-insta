@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4">Subscription Plans</h1>
    </div>

    <div class="container mt-5">

        <div class="container mt-5 text-center">
            <div class="row g-0">

                <div class="col-md-8 p-0">
                    <div class="filter-container p-3 rounded">
                        <span>Filter by:</span>
                        <div class="btn-group" role="group" aria-label="Filter options">
                            <input type="radio" class="btn-check" name="filter" id="wordpress" autocomplete="off"
                                checked>
                            <label class="btn" for="wordpress">WordPress Installs</label>

                            <input type="radio" class="btn-check" name="filter" id="storage" autocomplete="off">
                            <label class="btn" for="storage">Amount of Storage</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 p-0">
                    <div class="dropdown-currency p-3">
                        <select class="form-select" id="currecny-select" aria-label="Currency selection">
                            <option value="usd" selected>USD</option>
                            <option value="inr">INR</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>



        <div class="mb-3">
            <!-- Slider -->
            <input type="range" id="planfilter" value="1" min="1" max="9" step="1"
                class="form-range" aria-label="Slide through available plans">

            <!-- Labels aligned with slider steps -->
            <div class="position-relative mt-2">
                <div class="d-flex justify-content-between position-absolute w-100" style="top: 0;">
                    <span class="text-nowrap" id="label-1">1</span>
                    <span class="text-nowrap" id="label-2">2</span>
                    <span class="text-nowrap" id="label-3">3</span>
                    <span class="text-nowrap" id="label-4">5</span>
                    <span class="text-nowrap" id="label-5">10</span>
                    <span class="text-nowrap" id="label-6">20</span>
                    <span class="text-nowrap" id="label-7">50</span>
                    <span class="text-nowrap" id="label-8">80</span>
                    <span class="text-nowrap" id="label-9">100</span>
                </div>
            </div>
        </div>
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

    <script>
        // Get all the radio buttons
        const wordpressRadio = document.getElementById('wordpress');
        const storageRadio = document.getElementById('storage');

        // Get all the labels to change
        const labels = [
            'label-1',
            'label-2',
            'label-3',
            'label-4',
            'label-5',
            'label-6',
            'label-7',
            'label-8',
            'label-9'
        ];

        // Arrays of labels to change based on selection
        const wordpressLabels = ['1', '2', '3', '5', '10', '20', '50', '80', '100'];
        const storageLabels = ['1GB', '20GB', '30GB', '35GB', '50GB', '80GB', '200GB', '275GB', '325GB'];

        // Function to update the labels
        function updateLabels(isStorage) {
            const newLabels = isStorage ? storageLabels : wordpressLabels;

            labels.forEach((id, index) => {
                document.getElementById(id).textContent = newLabels[index];
            });
        }

        // Set initial state based on the checked radio button
        updateLabels(false); // Initially, it's set to WordPress Installs

        // Add event listeners to change labels when radio button is clicked
        wordpressRadio.addEventListener('change', () => updateLabels(false));
        storageRadio.addEventListener('change', () => updateLabels(true));
    </script>

    <script>
        let exchangeRate = 0;


        function fetchExchangeRate(currency = 'inr') {
            $.ajax({
                url: 'https://api.exchangerate-api.com/v4/latest/USD',
                method: 'GET',
                success: function(data) {
                    if (currency === 'inr' && data.rates.INR) {
                        exchangeRate = data.rates.INR;
                    } else {
                        exchangeRate = 85;
                    }


                    const selectedCurrency = $('#currecny-select').val();
                    fetchFilteredPlans('free', selectedCurrency);
                },
                error: function() {
                    console.error('Failed to fetch exchange rate, using default value of 1');
                    exchangeRate = 1;
                    const selectedCurrency = $('#currecny-select').val();
                    fetchFilteredPlans('free', selectedCurrency);
                }
            });
        }

        // Function to fetch and display filtered plans
        function fetchFilteredPlans(planType, currency = 'usd') {
            $.ajax({
                url: '/getSubscriptiondetail',
                method: 'GET',
                data: {
                    currency: currency
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    let filteredPlans = data.filter(plan => plan.plain_title.toLowerCase() === planType
                        .toLowerCase());
                    let uniquePlanDetails = new Set();
                    let plansHtml = '';

                    filteredPlans.forEach(function(plan) {
                        let displayPrice = (currency === 'inr') ? (plan.plan_price * exchangeRate) :
                            plan.plan_price;

                        // Check if plan details are already added
                        if (!uniquePlanDetails.has(plan.plan_details)) {
                            uniquePlanDetails.add(plan.plan_details);
                            plansHtml += `
                            <div class="col-md-4 mb-4">
                                <div class="price-card">
                                    <ul class="pricing-features">
                                        ${plan.plan_details}
                                    </ul>
                                </div>
                            </div>
                        `;
                        }

                        plansHtml += `
                        <div class="col-md-4 mb-4">
                            <div class="price-card">
                                <h2 class="plan-title">${plan.plain_title}</h2>
                                <p class="plan-description">${plan.plan_description}</p>
                                <p class="price">
                                    ${currency === 'usd' ? '$' : '₹'} <span>${displayPrice}</span> / ${plan.plan_type.charAt(0).toUpperCase() + plan.plan_type.slice(1)}
                                </p>
                                <button class="btn btn-primary btn-buy"
                                        data-plan-id="${plan.id}"
                                        data-plan-type="${plan.plan_type}"
                                        data-plan_price="${plan.plan_price}"
                                        data-stripe_product_id="${plan.stripe_product_id}"
                                        data-plain_title="${plan.plain_title}"
                                        data-plain_id="${plan.plain_id}"
                                        data-no_sites="${plan.no_sites}"
                                        data-storage="${plan.storage}"
                                        data-bs-target="#usersmodel"
                                        id="addUserButton">Buy Now</button>
                            </div>
                        </div>
                    `;
                    });

                    $('#pricing-plans').html(plansHtml);
                },
                error: function() {
                    alert('Failed to fetch subscription details.');
                }
            });
        }

        // Fetch plans initially with default USD currency
        fetchExchangeRate('usd');

        // Handle the currency dropdown change
        $('#currecny-select').on('change', function() {
            const selectedCurrency = $(this).val();
            fetchExchangeRate(selectedCurrency);
        });


        $('#planfilter').on('input', function() {
            const value = $(this).val();
            let selectedPlanType = '';


            switch (value) {
                case '1':
                    selectedPlanType = 'Free';
                    break;
                case '2':
                    selectedPlanType = 'Standard';
                    break;
                case '3':
                    selectedPlanType = 'Silver';
                    break;
                case '4':
                    selectedPlanType = 'Gold';
                    break;
                case '5':
                    selectedPlanType = 'Platinum';
                    break;
                case '6':
                    selectedPlanType = 'Diamond';
                    break;
                case '7':
                    selectedPlanType = 'Ultimate';
                    break;
                case '8':
                    selectedPlanType = 'Premier';
                    break;
                case '9':
                    selectedPlanType = 'Pro';
                    break;
            }

            const selectedCurrency = $('#currecny-select').val();
            fetchFilteredPlans(selectedPlanType, selectedCurrency);
        });

        // Handle the button click for purchase
        $('#pricing-plans').on('click', '.btn-buy', function() {
            const selectedPlanId = $(this).data('plan-id');
            const stripeProductId = $(this).data('stripe_product_id');
            const planPrice = $(this).data('plan_price');
            const planTitle = $(this).data('plain_title');
            const planType = $(this).data('plan-type');
            const plainId = $(this).data('plain_id');
            const no_sites = $(this).data('no_sites');
            const storage = $(this).data('storage');

            const selectedCurrency = $('#currecny-select').val();
            let displayPrice = (selectedCurrency === 'inr') ? (planPrice * exchangeRate) : planPrice;

            console.log("Updated Price: ", displayPrice);

            const now = new Date();
            const currentDate = now.toISOString().split('T')[0];
            let endDate = new Date(now);

            if (planType === 'month') {
                endDate.setMonth(endDate.getMonth() + 1);
            } else if (planType === 'year') {
                endDate.setFullYear(endDate.getFullYear() + 1);
            }

            const formattedEndDate = endDate.toISOString().split('T')[0];

            const registerData = {
                plan_id: plainId,
                stripe_product_id: stripeProductId,
                plan_price: displayPrice,
                subscription_type: planTitle,
                start_date: currentDate,
                plan_type: planType,
                end_date: formattedEndDate,
                currency: selectedCurrency,
                no_sites: no_sites,
                storage: storage,
            };

            localStorage.setItem('registerData', JSON.stringify(registerData));

            window.location.href = '/register';
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

        /* Styling for alignment */
        .form-range {
            margin: 0;
            padding: 0;
        }

        .position-relative {
            height: 20px;
            /* Ensures alignment of labels with slider */
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .d-flex span {
                font-size: 12px;
            }
        }

        @media (max-width: 576px) {
            .d-flex span {
                font-size: 10px;
            }
        }

        /* Make sure the labels don't have background color initially */
        .btn-check:checked+.btn {
            background-color: #007bff;
            /* or any color you prefer for selected state */
            color: white;
        }

        .btn-check:checked+.btn:active {
            background-color: #0056b3;
            /* or any color you prefer when active */
        }
    </style>
    <link href="assets/landing-css/landingstyle.css" rel="stylesheet">
@endsection
