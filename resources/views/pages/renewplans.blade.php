@extends('structures.main')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4">Renew Subscription Plans</h1>

        {{-- Display Current Active Plan --}}
        <div id="current-plan"></div>

        {{-- Display Available Plans --}}
        <div class="row" id="available-plans"></div>
    </div>


    <script>
        function renewOrBuyPlan(currentEndDate, duration, subscriptionType, price) {
            // Calculate new start and end dates based on duration
            const startDate = currentEndDate ? new Date(currentEndDate) : new Date();
            let endDate;

            if (duration === 'month') {
                endDate = new Date(startDate);
                endDate.setMonth(startDate.getMonth() + 1);
            } else if (duration === 'year') {
                endDate = new Date(startDate);
                endDate.setFullYear(startDate.getFullYear() + 1);
            }

            // Sending only the necessary data to the backend
            $.ajax({
                url: '/renew-subscription',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    start_date: startDate.toISOString().split('T')[0],
                    end_date: endDate.toISOString().split('T')[0],
                    subscription_type: subscriptionType,
                    price: price,
                    duration: duration,
                },
                success: function(response) {
                    if (response.checkout_url) {

                        window.location.href = response.checkout_url;
                    } else {
                        alert('Error: Could not initiate payment.');
                    }
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        }


        $(document).ready(function() {
            $.ajax({
                url: '/renew-plans-data',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Find the current plan's price
                    let currentPlanPrice = null;
                    if (data.currentPlan) {
                        const currentPlanMatch = data.membershipPlans.find(plan =>
                            plan.plain_title === data.currentPlan.subscription_type &&
                            plan.plan_type === data.currentPlan.duration
                        );
                        currentPlanPrice = currentPlanMatch ? currentPlanMatch.plan_price : 'N/A';
                    }

                    // Display current plan info
                    if (data.currentPlan) {
                        $('#current-plan').html(`
                      <div class="card shadow-lg border-0">
                            <div class="card-header mb-3 text-center">
                                <h4>Your Current Plan: ${data.currentPlan.subscription_type}</h4>
                            </div>
                            <div class="row card-body text-center">
                                <div class="col-md-3">
                                    <p><strong>Start Date:</strong> ${data.currentPlan.start_date}</p>
                                </div>
                                <div class="col-md-3">
                                    <p><strong>End Date:</strong> ${data.currentPlan.end_date}</p>
                                </div>
                                <div class="col-md-3">
                                    <p><strong>Duration:</strong> ${data.currentPlan.duration}</p>
                                </div>
                                <div class="col-md-3">
                                    <p><strong>Price:</strong> ₹${currentPlanPrice}</p>
                                </div>
                                <div class="col-md-12">
                                    <p><strong>Status:</strong> <span class="badge bg-success">Active</span></p>
                                </div>
                            </div>
                        </div>
                `);
                    } else {
                        $('#current-plan').html(`
                            <div class="card shadow-lg border-0">
                                <div class="card-header mb-3 text-center">
                                    <h4>Your Current Plan: Not Available</h4>
                                </div>
                                <div class="row card-body text-center">
                                    <div class="col-md-3">
                                        <p><strong>Start Date:</strong> N/A</p>
                                    </div>
                                    <div class="col-md-3">
                                        <p><strong>End Date:</strong> N/A</p>
                                    </div>
                                    <div class="col-md-3">
                                        <p><strong>Duration:</strong> N/A</p>
                                    </div>
                                    <div class="col-md-3">
                                        <p><strong>Price:</strong> ₹0</p>
                                    </div>
                                    <div class="col-md-12">
                                        <p><strong>Status:</strong> <span class="badge bg-danger">Expired</span></p>
                                    </div>
                                </div>
                            </div>
                        `);
                    }

                    // Display available plans
                    let availablePlansHtml = '';
                    data.membershipPlans.forEach(function(plan) {
                        const currentEndDate = data.currentPlan ? data.currentPlan.end_date :
                            null;
                        const isCurrentPlan =
                            data.currentPlan &&
                            data.currentPlan.subscription_type === plan.plain_title &&
                            data.currentPlan.duration === plan.plan_type;

                        availablePlansHtml += `
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-header bg-success text-white text-center">
                                ${plan.plain_title}
                               
                            </div>
                            <div class="card-body">
                                <h2 class="card-title text-center">Price: ₹${plan.plan_price}</h2>
                                <h5 class="card-title  text-center" id="plan_type">Duration: ${plan.plan_type}</h5>
                                <div>${plan.plan_details}</div>
                         
                            </div>
                            <div class="card-footer text-center">
                                <button class="btn btn-${isCurrentPlan ? 'primary' : 'success'}"
                                    onclick="renewOrBuyPlan( '${currentEndDate}', '${plan.plan_type}', '${plan.plain_title}', '${plan.plan_price}')">
                                    ${isCurrentPlan ? 'Renew Plan' : 'Buy Now'}
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                    });

                    $('#available-plans').html(availablePlansHtml);

                },
                error: function(error) {
                    console.log('Error fetching data:', error);
                }
            });
        });
    </script>

    <style>
        ul {
            list-style-type: none;
        }

        #plan_type {
            text-transform: capitalize;
        }
    </style>
@endsection
