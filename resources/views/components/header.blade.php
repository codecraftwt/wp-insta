<div>
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <a href="dashboard" class="logo d-flex align-items-center">
                <img src="assets/img/walstarLogo.png" alt="">
                <span class="d-none d-lg-block"></span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn" id="toggleSidebar"></i>
        </div><!-- End Logo -->


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
                        <!-- Dropdown toggle for user profile -->
                        <a class="nav-link dropdown-toggle m-1" href="#" id="editProfileBtn" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Hello, {{ Auth::user()->name }}
                        </a>

                        <!-- Dropdown menu -->
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="editProfileBtn">
                            <!-- Edit Profile option -->
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                    data-bs-target="#editProfileModal">
                                    <i class="bi bi-person-fill"></i> Edit Profile
                                </a>
                            </li>

                            <!-- Log Out option -->
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

    <!-- Modal for editing profile -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name_profile" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name_profile" name="name_profile"
                                value="{{ Auth::user()->name }}">
                        </div>

                        <div class="mb-3">
                            <label for="email_profile" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email_profile" name="email_profile"
                                value="{{ Auth::user()->email }}">
                        </div>
                        <div class="mb-3">
                            <label for="password_profile" class="form-label">New Password</label>
                            <input type="password" class="form-control" name="password_profile" id="password_profile">
                        </div>

                        <div class="mb-3">
                            <label for="password_profile_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" name="password_profile_confirmation"
                                id="password_profile_confirmation">
                        </div>


                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Function to fetch new notifications
            function fetchNotifications() {
                $.ajax({
                    url: '/notifications/new-register',
                    type: 'GET',
                    success: function(response) {
                        const notifications = response.data;
                        const $notificationCount = $('#notificationCount');
                        const $notificationsDropdownMenu = $('#notificationsDropdownMenu');

                        if (notifications.length > 0) {
                            $notificationCount.text(notifications.length).removeClass(
                                'd-none'); // Show badge
                            $notificationsDropdownMenu.html(''); // Clear previous notifications

                            // Build notification list
                            $.each(notifications, function(index, notification) {
                                $notificationsDropdownMenu.append(
                                    `<li>
                                <a class="dropdown-item notification-item" style="cursor: pointer;" data-id="${notification.id}">
                                    ${notification.name} (${notification.email})
                                </a>
                             </li>`
                                );
                            });
                        } else {
                            $notificationCount.text(0).addClass('d-none'); // Hide badge
                            $notificationsDropdownMenu.html(
                                '<li><a class="dropdown-item text-muted">No new notifications</a></li>'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching notifications:', error);
                    },
                });
            }

            // Function to mark all notifications as read
            function markAllNotificationsAsRead() {
                $.ajax({
                    url: '/notifications/mark-read', // Endpoint to mark all notifications as read
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function() {
                        $('#notificationCount').text(0).addClass('d-none'); // Hide badge
                        $('#notificationsDropdownMenu').html(
                            '<li><a class="dropdown-item text-muted">No new notifications</a></li>'
                        ); // Replace notifications with "No new notifications"
                    },
                    error: function(xhr, status, error) {
                        console.error('Error marking notifications as read:', error);
                    },
                });
            }

            // Delegate click event to mark all notifications as read
            $(document).on('click', '.notification-item', function() {
                markAllNotificationsAsRead(); // Mark all as read when any notification is clicked
            });

            // Fetch notifications on page load
            fetchNotifications();
        });
    </script>
