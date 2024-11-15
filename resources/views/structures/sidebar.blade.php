<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link" href="home">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        @if (auth()->check() && auth()->user()->role && auth()->user()->role->name === 'superadmin')
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#wp-material" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-wordpress"></i>
                    <span>WP Material</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="wp-material" class="nav-content collapse" data-bs-parent="#wp-material-nav">
                    <li>
                        <a href="plugins">
                            <i class="bi bi-plugin"></i>
                            <span>Plugin</span>
                        </a>
                    </li>
                    <li>
                        <a href="themes">
                            <i class="bi bi-images"></i>
                            <span>Themes</span>
                        </a>
                    </li>
                    <li>
                        <a href="wp-version">
                            <i class="bi bi-file-earmark-diff"></i>
                            <span>Version</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('plugin_categories.index') }}">
                            <i class="bi bi-kanban-fill"></i>
                            <span>ADD Plugin Categories</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-gear"></i>
                    <span>Setting</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="tables-nav" class="nav-content collapse" data-bs-parent="#setting-nav">
                    <li>
                        <a href="smptsetting">
                            <i class="bi bi-inbox"></i>
                            <span>SMTP</span>
                        </a>
                    </li>
                    <li>
                        <a href="managerole">
                            <i class="bi bi-wallet"></i>
                            <span>Manage Role</span>
                        </a>
                    </li>
                    <li>
                        <a href="site-setting">
                            <i class="bi bi-wallet"></i>
                            <span>Site Setting</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="manageusers">
                            <i class="bi bi-kanban-fill"></i>
                            <span>Manage Users</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="managesites">
                            <i class="bi bi-sliders2-vertical"></i>
                            <span>Manage Site's</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Payment Section -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#payment-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-credit-card-2-back-fill"></i>
                    <span>PAYMENT Setting's</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="payment-nav" class="nav-content collapse" data-bs-parent="#payment-nav">
                    <li>
                        <a href="payment-setting">
                            <i class="bi bi-sliders2-vertical"></i>
                            <span>Payment Configuration</span>
                        </a>
                    </li>
                    <li>
                        <a href="payment-history">
                            <i class="bi bi-clock-history"></i>
                            <span>Payment History</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/subscription">
                            <i class="bi bi-view-list"></i>
                            <span>View Subscription</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/plan-page">
                            <i class="bi bi-newspaper"></i>
                            <span>Add Plan</span>
                        </a>
                    </li>
                </ul>
            <li class="nav-item">
                <a class="nav-link" href="sites-info">
                    <i class="fas fa-info-circle"></i>
                    <span>ALL SITES</span>

                </a>
            </li>
            </li>
        @endif
    </ul>
</aside>
