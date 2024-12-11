$(document).ready(function () {
    $.ajax({
        url: '/upgradeplans',
        type: 'GET',
        success: function (data) {
            if (data.length > 0 && data[0] === "1") {

                $('#renewplanButton').hide();

            } else {

                $('#renewplanButton').show();

            }
        },
        error: function (xhr, status, error) {
            console.error('Error:', error); // Handle errors here
        }
    });
    // Next step from Step 1 to Step 2
    document.querySelectorAll('.next-step').forEach(button => {
        button.addEventListener('click', function () {
            var siteName = document.getElementById('siteName').value.trim();
            var userName = document.getElementById('user_name').value.trim();
            var password = document.getElementById('password').value.trim();
            var wpVersion = document.getElementById('wpVersion').value;
            var DomainName = document.getElementById('DomainName').value;

            if (!siteName || !userName || !password || !wpVersion || !DomainName) {
                Swal.fire({
                    icon: 'error',
                    title: 'All fields in Step 1 are required!',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
                return; // Stop the navigation to Step 2
            }

            document.getElementById('step1').classList.add('d-none');
            document.getElementById('step2').classList.remove('d-none');
            $('#siteCreationModalLabel').text('Select  Plugins');
        });
    });

    // Next step from Step 2 to Step 3
    document.querySelectorAll('.next-step2').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('step2').classList.add('d-none');
            document.getElementById('step3').classList.remove('d-none');
            $('#siteCreationModalLabel').text('Select  Themes');
        });
    });

    // Next step from Step 3 to Step 4
    document.querySelectorAll('.next-step3').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('step3').classList.add('d-none');
            document.getElementById('step4').classList.remove('d-none');
            $('#siteCreationModalLabel').text('Login Credentials');
        });
    });

    // Navigate back from Step 2 to Step 1
    document.querySelectorAll('.prev-step').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('step2').classList.add('d-none');
            document.getElementById('step1').classList.remove('d-none');
        });
    });

    // Navigate back from Step 3 to Step 2
    document.querySelectorAll('.prev-step2').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('step3').classList.add('d-none');
            document.getElementById('step2').classList.remove('d-none');
        });
    });

    // Navigate back from Step 4 to Step 3
    document.querySelectorAll('.prev-step3').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('step4').classList.add('d-none');
            document.getElementById('step3').classList.remove('d-none');
        });
    });

    // Fetch active users count
    $.ajax({
        url: '/countUsers',
        method: 'GET',
        success: function (response) {
            $('#users_count').text(response.active + response.inactive);
            $('#active_uses').text(response.active);
            $('#inactive_uses').text(response.inactive);
        },
        error: function (xhr, status, error) {
            console.error("Error fetching data:", error);
        }
    });

    $(document).on('input', '#DomainName', function () {
        const domainName = $(this).val();
        const invalidRegex = /[^a-zA-Z]/; // Only allow letters (a-z, A-Z)

        $('#DomainName').removeClass('is-valid is-invalid'); // Reset classes
        $('.feedback-message').remove(); // Remove old messages

        if (invalidRegex.test(domainName)) {
            // If invalid characters are found
            $('#DomainName').addClass('is-invalid');
            $('#DomainName').after(`
    <div class="invalid-feedback feedback-message">
        Domain names can only contain letters (a-z, A-Z). No symbols, numbers, or spaces are allowed.
    </div>
`);
            return;
        }

        if (domainName) {
            $.ajax({
                url: '/suggesstionname',
                method: 'GET',
                data: {
                    name: domainName
                },
                success: function (response) {
                    if (response.status === 'taken') {
                        $('#DomainName').addClass('is-invalid');
                        $('#DomainName').after(`
                <div class="invalid-feedback feedback-message">
                    This domain name is already taken. Try this instead: <strong>${response.suggestion}</strong>
                </div>
            `);
                    } else {
                        $('#DomainName').addClass('is-valid');
                        $('#DomainName').after(`

            `);
                    }
                }
            });
        }
    });

    $('#close-notification-btn').on('click', function () {
        // Hide the notification
        $('#subscription-notification').fadeOut();

        // Store that the user has dismissed the notification using AJAX
        $.ajax({
            url: '/dismiss-notification',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}', // Add CSRF token for security
            },
            success: function (data) {
                if (data.status === 'success') {
                    // You can perform any other actions here after successful dismissal.
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error); // Handle errors here
            }
        });
    });
});
