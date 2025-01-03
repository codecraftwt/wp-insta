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
    // document.querySelectorAll('.next-step').forEach(button => {
    //     button.addEventListener('click', function () {
    //         var siteName = document.getElementById('siteName').value.trim();
    //         var userName = document.getElementById('user_name').value.trim();
    //         var password = document.getElementById('password').value.trim();
    //         var wpVersion = document.getElementById('wpVersion').value;
    //         var folder_name = document.getElementById('folder_name').value;

    //         if (!siteName || !userName || !password || !wpVersion || !folder_name) {
    //             Swal.fire({
    //                 icon: 'error',
    //                 title: 'All fields in Step 1 are required!',
    //                 showConfirmButton: false,
    //                 timer: 3000,
    //                 timerProgressBar: true
    //             });
    //             return; // Stop the navigation to Step 2
    //         }

    //         document.getElementById('step1').classList.add('d-none');
    //         document.getElementById('step2').classList.remove('d-none');
    //         $('#siteCreationModalLabel').text('Select  Plugins');
    //     });
    // });

    // // Next step from Step 2 to Step 3
    // document.querySelectorAll('.next-step2').forEach(button => {
    //     button.addEventListener('click', function () {
    //         document.getElementById('step2').classList.add('d-none');
    //         document.getElementById('step3').classList.remove('d-none');
    //         $('#siteCreationModalLabel').text('Select  Themes');
    //     });
    // });

    // // Next step from Step 3 to Step 4
    // document.querySelectorAll('.next-step3').forEach(button => {
    //     button.addEventListener('click', function () {
    //         document.getElementById('step3').classList.add('d-none');
    //         document.getElementById('step4').classList.remove('d-none');
    //         $('#siteCreationModalLabel').text('Login Credentials');
    //     });
    // });

    // // Navigate back from Step 2 to Step 1
    // document.querySelectorAll('.prev-step').forEach(button => {
    //     button.addEventListener('click', function () {
    //         document.getElementById('step2').classList.add('d-none');
    //         document.getElementById('step1').classList.remove('d-none');
    //     });
    // });

    // // Navigate back from Step 3 to Step 2
    // document.querySelectorAll('.prev-step2').forEach(button => {
    //     button.addEventListener('click', function () {
    //         document.getElementById('step3').classList.add('d-none');
    //         document.getElementById('step2').classList.remove('d-none');
    //     });
    // });

    // // Navigate back from Step 4 to Step 3
    // document.querySelectorAll('.prev-step3').forEach(button => {
    //     button.addEventListener('click', function () {
    //         document.getElementById('step4').classList.add('d-none');
    //         document.getElementById('step3').classList.remove('d-none');
    //     });
    // });


    document.querySelectorAll('.next-step').forEach(button => {
        button.addEventListener('click', function () {
            var siteName = document.getElementById('siteName').value.trim();
            var userName = document.getElementById('user_name').value.trim();
            var password = document.getElementById('password').value.trim();
            var wpVersion = document.getElementById('wpVersion').value;
            var folder_name = document.getElementById('folder_name').value;

            if (!siteName || !userName || !password || !wpVersion || !folder_name) {
                Swal.fire({
                    icon: 'error',
                    title: 'All fields in Step 1 are required!',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
                return; // Stop the navigation to Step 01
            }

            // Step 1 to Step 01 transition
            document.getElementById('step1').classList.add('d-none');
            document.getElementById('step01').classList.remove('d-none');
            $('#siteCreationModalLabel').text('Select One Template for Your Bussiness');
        });
    });

    // Step 01 to Step 2
    document.querySelectorAll('.next-step01').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('step01').classList.add('d-none');
            document.getElementById('step2').classList.remove('d-none');
            $('#siteCreationModalLabel').text('Select Plugins');
        });
    });

    // Step 2 to Step 3 (Already Defined)
    document.querySelectorAll('.next-step2').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('step2').classList.add('d-none');
            document.getElementById('step3').classList.remove('d-none');
            $('#siteCreationModalLabel').text('Select Themes');
        });
    });

    // Step 3 to Step 4 (Already Defined)
    document.querySelectorAll('.next-step3').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('step3').classList.add('d-none');
            document.getElementById('step4').classList.remove('d-none');
            document.getElementById('step01').classList.add('d-none');
            $('#siteCreationModalLabel').text('Login Credentials');
        });
    });

    // Navigate back from Step 01 to Step 1
    document.querySelectorAll('.prev-step').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('step01').classList.add('d-none');
            document.getElementById('step1').classList.remove('d-none');
        });
    });

    // Navigate back from Step 2 to Step 01
    document.querySelectorAll('.prev-step01').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('step2').classList.add('d-none');
            document.getElementById('step01').classList.remove('d-none');
        });
    });

    // Navigate back from Step 2 to Step 1
    document.querySelectorAll('.prev-step2').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('step2').classList.add('d-none');
            document.getElementById('step1').classList.remove('d-none');
        });
    });

    // Navigate back from Step 3 to Step 2
    document.querySelectorAll('.prev-step3').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('step3').classList.add('d-none');

            document.getElementById('step2').classList.remove('d-none');
        });
    });

    // Navigate back from Step 4 to Step 3
    document.querySelectorAll('.prev-step4').forEach(button => {
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

    $(document).on('input', '#folder_name', function () {
        const folder_name = $(this).val();
        const invalidRegex = /[^a-zA-Z]/; // Only allow letters (a-z, A-Z)

        $('#folder_name').removeClass('is-valid is-invalid'); // Reset classes
        $('.feedback-message').remove(); // Remove old messages

        if (invalidRegex.test(folder_name)) {
            // If invalid characters are found
            $('#folder_name').addClass('is-invalid');
            $('#folder_name').after(`
    <div class="invalid-feedback feedback-message">
        Domain names can only contain letters (a-z, A-Z). No symbols, numbers, or spaces are allowed.
    </div>
`);
            return;
        }

        if (folder_name) {
            $.ajax({
                url: '/suggesstionname',
                method: 'GET',
                data: {
                    name: folder_name
                },
                success: function (response) {
                    if (response.status === 'taken') {
                        $('#folder_name').addClass('is-invalid');
                        $('#folder_name').after(`
                <div class="invalid-feedback feedback-message">
                    This domain name is already taken. Try this instead: <strong>${response.suggestion}</strong>
                </div>
            `);
                    } else {
                        $('#folder_name').addClass('is-valid');
                        $('#folder_name').after(`

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
