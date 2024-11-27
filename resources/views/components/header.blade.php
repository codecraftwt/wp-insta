<div>
  


    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <a href="home" class="logo d-flex align-items-center">
                <img src="assets/img/walstarLogo.png" alt="">
                <span class="d-none d-lg-block"></span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn" id="toggleSidebar"></i>
        </div>

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center mb-0">
                <!-- Notifications -->
                <li class="nav-item dropdown ms-3">
                    @if (auth()->check() && auth()->user()->role && auth()->user()->role->name === 'superadmin')
                        <a class="nav-link" href="#" id="notificationsDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-bell"></i>
                            <span class="badge bg-danger rounded-pill" id="notificationCount">0</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" id="notificationsDropdownMenu"
                            aria-labelledby="notificationsDropdown" style="min-width: 300px;">
                            <li><a class="dropdown-item text-muted">No new notifications</a></li>
                        </ul>
                    @endif
                </li>

                <!-- User Dropdown -->
                <li class="nav-item dropdown ms-3">
                    @if (Auth::check())
                        <a class="nav-link dropdown-toggle m-1" href="#" id="editProfileBtn" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Hello, {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="editProfileBtn">
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                    data-bs-target="#editProfileModal">
                                    <i class="bi bi-person-fill"></i> Edit Profile
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="dropdown-item">
                                    <i class="bi bi-box-arrow-right"></i> Log Out
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    @endif
                </li>
            </ul>
        </nav>
    </header>

</div>
