<div>
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-item">
                <a class="nav-link" href="dashboard">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <hr>

            <!-- ALL SITES Menu -->
            @if (Auth::user()->hasPermission('ALL SITES Menu'))
                <li class="nav-item">
                    <a class="nav-link" href="sites-info">
                        <i class="fas fa-info-circle"></i>
                        <span>All Sites</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->hasPermission('Manage Users Menu'))
                <li class="nav-item">
                    <a class="nav-link" href="manageusers">
                        <i class="bi bi-kanban-fill"></i>
                        <span>Manage Users</span>
                    </a>
                </li>
            @endif
            @if (auth()->check() && auth()->user()->role->name == 'user')
                <li class="nav-item">
                    <a class="nav-link" href="renew-plans">
                        <i class="bi bi-recycle"></i>
                        <span>Renew Plans</span>
                    </a>
                </li>
            @endif
            <!-- WP Material Menu -->
            @if (Auth::user()->hasPermission('WP Material Menu'))
                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#wp-material" data-bs-toggle="collapse"
                        href="#">
                        <i class="bi bi-wordpress"></i>
                        <span>Wp Material</span>
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                </li>
                <ul id="wp-material"
                    class="nav-content collapse {{ request()->is('plugins') || request()->is('themes') || request()->is('wp-version') || request()->is('plugin_categories') || request()->is('themes-categories') ? 'show' : '' }}"
                    data-bs-parent="#wp-material-nav">
                    @if (Auth::user()->hasPermission('Plugin View'))
                        <li>
                            <a href="plugins">
                                <i class="bi bi-plugin"></i>
                                <span>Plugin</span>
                            </a>
                        </li>
                    @endif
                    @if (Auth::user()->hasPermission('Themes View'))
                        <li>
                            <a href="themes">
                                <i class="bi bi-images"></i>
                                <span>Themes</span>
                            </a>
                        </li>
                    @endif
                    @if (Auth::user()->hasPermission('Version View'))
                        <li>
                            <a href="wp-version">
                                <i class="bi bi-file-earmark-diff"></i>
                                <span>Version</span>
                            </a>
                        </li>
                    @endif
                    @if (Auth::user()->hasPermission('ADD Plugin Categories View'))
                        <li>
                            <a href="{{ route('plugin_categories.index') }}">
                                <i class="bi bi-kanban-fill"></i>
                                <span>Add Plugin Categories</span>
                            </a>
                        </li>
                    @endif
                    @if (Auth::user()->hasPermission('ADD Themes Categories View'))
                        <li class="nav-item">
                            <a class="nav-link" href="themes-categories">
                                <i class="fas fa-tags"></i>
                                <span> Add Themes Categories</span>
                            </a>
                        </li>
                    @endif
                </ul>
            @endif

            @if (Auth::user()->hasPermission('Permission Menu'))
                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#permission-nav" data-bs-toggle="collapse"
                        href="#">
                        <i class="bi bi-lock"></i>
                        <span>Permission</span>
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                </li>
            @endif
            <ul id="permission-nav"
                class="nav-content collapse {{ request()->is('permission') || request()->is('managerole') ? 'show' : '' }}"
                data-bs-parent="#setting-nav">
                @if (Auth::user()->hasPermission('Add Permission View'))
                    <li>
                        <a href="permission">
                            <i class="bi bi-inbox"></i>
                            <span>Add Permission</span>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->hasPermission('Manage Role View'))
                    <li>
                        <a href="managerole">
                            <i class="bi bi-wallet"></i>
                            <span>Manage Role</span>
                        </a>
                    </li>
                @endif
            </ul>

            <!-- Setting Menu -->
            @if (Auth::user()->hasPermission('Setting Menu'))
                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-gear"></i>
                        <span>Setting</span>
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                </li>
                <ul id="tables-nav"
                    class="nav-content collapse {{ request()->is('smptsetting') || request()->is('site-setting') ? 'show' : '' }}"
                    data-bs-parent="#setting-nav">
                    @if (Auth::user()->hasPermission('SMTP View'))
                        <li>
                            <a href="smptsetting">
                                <i class="bi bi-inbox"></i>
                                <span>SMTP</span>
                            </a>
                        </li>
                    @endif

                    @if (Auth::user()->hasPermission('Site Setting View'))
                        <li>
                            <a href="site-setting">
                                <i class="bi bi-wallet"></i>
                                <span>Site Setting</span>
                            </a>
                        </li>
                    @endif
                </ul>
            @endif

            <!-- Payment Settings Menu -->
            @if (Auth::user()->hasPermission('PAYMENT Settings Menu'))
                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#payment-nav" data-bs-toggle="collapse"
                        href="#">
                        <i class="bi bi-credit-card-2-back-fill"></i>
                        <span>Payment Setting's</span>
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                </li>
                <ul id="payment-nav"
                    class="nav-content collapse {{ request()->is('payment-setting') || request()->is('plan-page') || request()->is('payment-history') || request()->is('subscription') ? 'show' : '' }}"
                    data-bs-parent="#payment-nav">

                    @if (Auth::user()->hasPermission('Payment Configuration View'))
                        <li>
                            <a href="payment-setting">
                                <i class="bi bi-sliders2-vertical"></i>
                                <span>Payment Configuration</span>
                            </a>
                        </li>
                    @endif
                    @if (Auth::user()->hasPermission('Add Plan View'))
                        <li class="nav-item">
                            <a class="nav-link" href="/plan-page">
                                <i class="bi bi-newspaper"></i>
                                <span>Add Plan</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->check() && auth()->user()->role->name == 'superadmin')
                        <li class="nav-item">
                            <a class="nav-link" href="coupons">
                                <i class="bi bi-plus-circle"></i> 
                                <span>Add Coupons</span>
                            </a>
                        </li>
                    @endif

                    @if (Auth::user()->hasPermission('Payment History View'))
                        <li>
                            <a href="payment-history">
                                <i class="bi bi-clock-history"></i>
                                <span>Payment History</span>
                            </a>
                        </li>
                    @endif

                    @if (Auth::user()->hasPermission('View Subscription View'))
                        <li class="nav-item">
                            <a class="nav-link" href="/subscription">
                                <i class="bi bi-view-list"></i>
                                <span>View Subscription</span>
                            </a>
                        </li>
                    @endif

                </ul>
            @endif


        </ul>
    </aside>

    <style>
        .sidebar-nav .nav-link span {
            text-transform: capitalize;
        }

        .sidebar {
            background-color: #0094DE;

        }

        .sidebar>i {
            color: white;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            font-size: 15px;
            font-weight: 600;
            color: #ffffff;
            transition: 0.3;
            padding: 10px 15px;
            border-radius: 4px;
        }

        .sidebar-nav .nav-link.collapsed {
            color: #ffffff;
            line-height: 2;
        }

        .sidebar-nav .nav-link.collapsed i {
            color: #899bbd;
        }

        .sidebar-nav .nav-link.collapsed i {
            color: #f7faff !important;
        }
    </style>


</div>
