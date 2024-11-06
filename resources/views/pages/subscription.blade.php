@extends('structures.main')


@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Subscription Plans</h1>
    </div>

    {{-- Nav button with data attributes for passing values --}}
    <div class="d-flex justify-content-center mb-4">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="monthly-tab" data-value="month" href="#" role="tab"
                    aria-controls="monthly" aria-selected="true" onclick="changeTab(this)">Monthly</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="yearly-tab" data-value="year" href="#" role="tab" aria-controls="yearly"
                    aria-selected="false" onclick="changeTab(this)">Yearly</a>
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

                            </div>
                        </div>
                    `;
                        }
                    });
                    $('#pricing-plans').html(plansHtml); // Inject the generated HTML into the container
                },
                error: function() {
                    alert('Failed to fetch subscription details.');
                }
            });
        }

        $(document).ready(function() {
            // Initially load the monthly plans
            changeTab(document.getElementById('monthly-tab'));
        });
    </script>

    <style type="text/css">
        body {
            margin-top: 20px;
            font-family: 'Arial', sans-serif;
            background-color: #f0f4f8;
            /* Soft background color */
            background-image: url('https://yourbackgroundimageurl.com');
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
