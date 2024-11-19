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
            <!-- User Dropdown -->
            <li class="nav-item dropdown">
                @if (Auth::check())
                    <!-- Trigger element for dropdown, showing the user's name -->
                    <a class="nav-link dropdown-toggle" href="#" id="editProfileBtn" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Hello {{ Auth::user()->name }}
                    </a>

                    <!-- Dropdown menu that appears when hovered -->
                    <ul class="dropdown-menu" aria-labelledby="editProfileBtn">
                        <li>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                data-bs-target="#editProfileModal">
                                <i class="bi bi-person-fill"></i> <!-- Bootstrap icon for a user -->
                                Edit Profile
                            </a>
                        </li>
                    </ul>
                @endif
            </li>

            <!-- Notifications -->
            <li class="nav-item dropdown ms-3">
                @if (auth()->check() && auth()->user()->role && auth()->user()->role->name === 'superadmin')
                    <a class="nav-link" href="#" id="notificationsDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-danger rounded-pill" id="notificationCount">0</span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end" id="notificationsDropdownMenu"
                        aria-labelledby="notificationsDropdown" style="min-width: 300px;"> <!-- Increased width -->
                        <!-- Notification list will be populated here -->
                        <li><a class="dropdown-item text-muted">No new notifications</a></li>
                    </ul>
                @endif
            </li>








            <!-- Logout -->
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

{{-- 
<script>
    $(document).ready(function() {
        // Fetch new notifications every 5 seconds or on demand
        function fetchNotifications() {
            $.ajax({
                url: '/notifications/new-register', // Route for notificationNewRegister
                method: 'GET',
                success: function(response) {
                    // Assuming response contains an array of users with unread notifications
                    const notifications = response.data;

                    // Update the notification count in the UI
                    $('#notificationCount').text(notifications.length);

                    // Populate the dropdown with new notifications
                    let notificationList = '';
                    if (notifications.length === 0) {
                        notificationList =
                            '<li><a class="dropdown-item text-muted">No new notifications</a></li>';
                        $('#markAsReadButton').hide(); // Hide the button if no new notifications
                    } else {
                        notifications.forEach(function(notification) {
                            notificationList +=
                                `<li><a class="dropdown-item">${notification.name} has registered</a></li>`;
                        });
                        $('#markAsReadButton')
                            .show(); // Show the button if there are new notifications
                    }

                    // Populate the dropdown with notification list
                    $('#notificationsDropdownMenu').html(notificationList);
                }
            });
        }

        // Call the function to fetch notifications when the page loads
        fetchNotifications();

        // Optional: Fetch new notifications periodically (every 5 seconds)
        setInterval(fetchNotifications, 5000); // 5 seconds

        // Mark notifications as read when the "Mark as Read" button is clicked
        $('#markAsReadButton').click(function() {
            $.ajax({
                url: '/notifications/mark-read', // Route for markNotificationsAsRead
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function() {
                    // After marking as read, update the notification count and message
                    $('#notificationCount').text(0);
                    $('#notificationsDropdownMenu').html(
                        '<li><a class="dropdown-item text-muted">No new notifications</a></li>'
                    );
                    $('#markAsReadButton').hide(); // Hide the button after marking as read
                }
            });
        });
    });
</script> --}}


<script>
    $(document).ready(function() {
        // Fetch new notifications every 5 seconds or on demand
        function fetchNotifications() {
            $.ajax({
                url: '/notifications/new-register', // Route for notificationNewRegister
                method: 'GET',
                success: function(response) {
                    // Assuming response contains an array of users with unread notifications
                    const notifications = response.data;

                    // Update the notification count in the UI
                    $('#notificationCount').text(notifications.length);

                    // Populate the dropdown with new notifications
                    let notificationList = '';
                    if (notifications.length === 0) {
                        notificationList =
                            '<li><a class="dropdown-item text-muted">No new notifications</a></li>';
                    } else {
                        notifications.forEach(function(notification) {
                            notificationList +=
                                `<li><a class="dropdown-item notification-item" href="#" data-id="${notification.id}">${notification.name} has registered</a></li>`;
                        });
                    }
                    $('#notificationsDropdownMenu').html(notificationList);
                }
            });
        }

        // Call the function to fetch notifications when the page loads
        fetchNotifications();

        // Optional: Fetch new notifications periodically (every 5 seconds)
        setInterval(fetchNotifications, 5000); // 5 seconds

        // Show more details when a notification is clicked
        $(document).on('click', '.notification-item', function() {
            var notificationId = $(this).data('id'); // Get the notification ID
            $.ajax({
                url: '/notifications/mark-read/' + notificationId,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Assuming the response contains the details of the notification
                    var details = response.data;
                    // Create a custom dropdown or modal for more details
                    var detailContent = `
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Name:</strong> ${details.name}</li>
                        <li class="list-group-item"><strong>Details:</strong> ${details.message}</li>
                    </ul>
                `;

                    // Show the details in a new dropdown or modal
                    var detailDropdown =
                        `<li class="dropdown-item" style="width: 350px;">${detailContent}</li>`;
                    $('#notificationsDropdownMenu').append(detailDropdown);
                }
            });
        });
    });
</script>
