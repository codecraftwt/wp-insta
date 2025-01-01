<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Site Deletion Notification</title>
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }

        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            border: 1px solid #ddd;
        }

        .email-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .email-header img {
            width: 100%;

        }

        .email-body {
            text-align: left;
            font-size: 16px;
            color: #555;
        }

        .email-footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 20px;
        }

        .btn {
            background-color: #2F67F6;
            color: white;
            padding: 15px 25px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <img src="{{ $imageUrl }}" alt="Walstar Logo">
        </div>
        <div class="email-body">
            <h2>Site Deletion </h2>
            <p>Hello {{ $userName }}!</p>
            <p>We regret to inform you that the site "<strong>{{ $siteName }}</strong>" has been successfully
                deleted.</p>
            <p>This action was taken due to the request you made, or if this was unintentional, please reach out to our
                support team for assistance.</p>
            <p>If you have any questions or need help with restoring your site, don't hesitate to contact us.</p>
            <p style="text-align: center;">
                <a href="https://instantwebsitedevelopment.com" class="btn">Contact Support</a>
            </p>
        </div>
        <div class="email-footer">
            <p>Best regards, <br> WalstarWP<br> <a href="https://instantwebsitedevelopment.com"
                    style="color:#2F67F6;">instantwebsitedevelopment.com</a></p>
        </div>
    </div>
</body>

</html>
