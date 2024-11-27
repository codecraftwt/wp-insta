<div>

    <div class="card_detail mb-5">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <!-- Site Details Column -->
            <div class="col">
                <h5 class="mb-3 cdetail-heading text-primary fw-bold">Site Details</h5>
                <hr class="mb-4" style="border-top: 2px solid #0d6efd;">
                <div class="card custom_card custom-card-equal">
                    <div class="card-body">
                        <!-- Staging Sites Section -->
                        <div class="row align-items-center mb-2 mt-3">
                            <div class="col-auto d-flex justify-content-center">
                                <div class="image-container rounded-circle d-flex justify-content-center align-items-center"
                                    style="background-color: #fff5d9; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); width: 60px; height: 60px; position: relative;">
                                    <img class="card-img-top small-image"
                                        src="{{ asset('assets/img/staging_img.png') }}" alt="Staging Sites Icon"
                                        style="width: 40px; height: 40px; object-fit: cover; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                </div>
                            </div>
                            <div class="col text-start">
                                <a href="/sites-info" class="text-decoration-none text-dark fw-bold">Staging Sites</a>
                            </div>
                            <div class="col-auto text-center">
                                <h6 class="fw-bold mb-0" id="staging_count" style="font-size: 1.3rem; color: #007bff;">0
                                </h6>
                            </div>
                        </div>

                        <!-- Plugins Section -->
                        <div class="row align-items-center mb-2">
                            <div class="col-auto d-flex justify-content-center">
                                <div class="image-container rounded-circle"
                                    style="background-color: #e7edff; width: 60px; height: 60px; position: relative;">
                                    <img src="{{ asset('assets/img/plug_img.png') }}" alt="Plugins Icon"
                                        style="width: 30px; height: 30px; object-fit: cover; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                </div>
                            </div>
                            <div class="col text-start">
                                <a href="/plugins" class="text-decoration-none text-dark fw-bold">Plugins</a>
                            </div>
                            <div class="col-auto text-center">
                                <h6 class="fw-bold mb-0" id="plugin" style="font-size: 1.5rem; color: #007bff;">0
                                </h6>
                            </div>
                        </div>

                        <!-- Themes Section -->
                        <div class="row align-items-center mb-2">
                            <div class="col-auto d-flex justify-content-center">
                                <div class="image-container rounded-circle"
                                    style="background-color: #dcfaf8; width: 60px; height: 60px; position: relative;">
                                    <img src="{{ asset('assets/img/themes_img.png') }}" alt="Themes Icon"
                                        style="width: 30px; height: 30px; object-fit: cover; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                </div>
                            </div>
                            <div class="col text-start">
                                <a href="/themes" class="text-decoration-none text-dark fw-bold">Themes</a>
                            </div>
                            <div class="col-auto text-center">
                                <h6 class="fw-bold mb-0" id="themes" style="font-size: 1.5rem; color: #007bff;">0
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Details Column -->
            <div class="col">
                <h5 class="mb-3 cdetail-heading text-primary fw-bold">Users Details</h5>
                <hr class="mb-4" style="border-top: 2px solid #0d6efd;">
                <div class="card custom_card custom-card-equal">
                    <div class="card-body">
                        <!-- All Users Sites Section -->
                        <div class="row align-items-center mb-2 mt-3">
                            <div class="col-auto d-flex justify-content-center">
                                <div class="image-container rounded-circle d-flex justify-content-center align-items-center"
                                    style="background-color: #fff5d9; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); width: 60px; height: 60px; position: relative;">
                                    <i class="fas fa-users"
                                        style="font-size: 24px; color: #007bff; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"></i>
                                </div>
                            </div>
                            <div class="col text-start">
                                <a href="#" class="text-decoration-none text-dark fw-bold">Users Count</a>
                            </div>
                            <div class="col-auto text-center">
                                <h6 class="fw-bold mb-0" id="users_count" style="font-size: 1.3rem; color: #007bff;">
                                </h6>
                            </div>
                        </div>

                        <!-- Active Users Section -->
                        <div class="row align-items-center mb-2">
                            <div class="col-auto d-flex justify-content-center">
                                <div class="image-container rounded-circle"
                                    style="background-color: #e7edff; width: 60px; height: 60px; position: relative;">
                                    <i class="fas fa-user-check"
                                        style="font-size: 24px; color: #007bff; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"></i>
                                </div>
                            </div>
                            <div class="col text-start">
                                <a href="#" class="text-decoration-none text-dark fw-bold">Active Users</a>
                            </div>
                            <div class="col-auto text-center">
                                <h6 class="fw-bold mb-0" id="active_uses" style="font-size: 1.5rem; color: #007bff;">0
                                </h6>
                            </div>
                        </div>

                        <!-- Inactive Users Section -->
                        <div class="row align-items-center mb-2">
                            <div class="col-auto d-flex justify-content-center">
                                <div class="image-container rounded-circle"
                                    style="background-color: #dcfaf8; width: 60px; height: 60px; position: relative;">
                                    <i class="fas fa-user-times"
                                        style="font-size: 24px; color: #007bff; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"></i>
                                </div>
                            </div>
                            <div class="col text-start">
                                <a href="#" class="text-decoration-none text-dark fw-bold">IN - Active</a>
                            </div>
                            <div class="col-auto text-center">
                                <h6 class="fw-bold mb-0" id="inactive_uses" style="font-size: 1.5rem; color: #007bff;">0
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subscription Details Column -->
            <div class="col">
                <div class="text-center">
                    <h5 class="mb-3 cdetail-heading text-primary fw-bold">Subscription Details</h5>
                    <hr>
                    <div class="card custom_card custom-card-equal">
                        <div class="card-body">
                            <div class="d-flex justify-content-center align-items-center" style="height: 220px;">
                                <canvas id="subscriptionChart" style="max-width: 100%; max-height: 100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>









    {{-- GRAPH --}}
    <div class="row justify-content-center">
        <!-- Wrapper for Centered Cards -->
        <div class="col-md-10">
            <div class="row">
                <!-- Site Status Chart Card -->
                <div class="col-md-6 mb-3">
                    <div class="card border-0 rounded t p-3" style="">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center">
                            <canvas id="siteStatusChart" width="100" height="100"></canvas>
                        </div>
                    </div>
                </div>


                <div class="col-md-6 mb-3">
                    <div class="card border-0 rounded  p-3">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center">
                            <canvas id="userChart" width="100" height="100"></canvas>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
