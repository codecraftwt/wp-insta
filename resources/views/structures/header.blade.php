<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="home" class="logo d-flex align-items-center">
            <img src="assets/img/walstarLogo.png" alt="">
            <span class="d-none d-lg-block"></span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item dropdown">
                @if (Auth::check())
                    <!-- Trigger element for dropdown, showing the user's name -->
                    <a class="nav-link dropdown-toggle" href="#" id="editProfileBtn" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Hello {{ Auth::user()->name }}
                    </a>

                    <!-- Dropdown menu that appears when hovered -->
                    <ul class="dropdown-menu" aria-labelledby="editProfileBtn">
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                data-bs-target="#editProfileModal">

                                <!-- Logo image with small size -->
                                <i class="bi bi-person-fill"></i> <!-- Bootstrap icon for a user -->
                                Edit Profile
                            </a>
                        </li>
                        <!-- You can add more items here if needed -->
                    </ul>
                @endif
            </li>


            <li class="nav-item dropdown pe-3 ms-3">
                @if (Auth::check())
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="btn btn-primary d-flex align-items-center">
                        <i class="bi bi-box-arrow-right"></i> <!-- Logout icon -->
                    </a>
                @endif
            </li>
        </ul>
    </nav>
</header>

<!-- Modal for editing profile, moved outside of header -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Profile update form -->
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Name field -->
                    <div class="mb-3">
                        <label for="name_profile" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name_profile" name="name_profile"
                            value="{{ Auth::user()->name }}">
                    </div>

                    <!-- Email field -->
                    <div class="mb-3">
                        <label for="email_profile" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email_profile" name="email_profile"
                            value="{{ Auth::user()->email }}">
                    </div>

                    <!-- Password field (optional) -->
                    <div class="mb-3">
                        <label for="password_profile" class="form-label">Password (leave blank to keep current)</label>
                        <input type="password" class="form-control" id="password_profile" name="password_profile">
                    </div>

                    <!-- Password confirmation field -->
                    <div class="mb-3">
                        <label for="password_confirmation_profile" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation_profile"
                            name="password_confirmation_profile">
                    </div>

                    <!-- Submit button -->
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>


            </div>
            <div class="modal-footer">
                <!-- "Come Back" / Cancel Button -->
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Come Back</button>
            </div>
        </div>
    </div>
</div>
