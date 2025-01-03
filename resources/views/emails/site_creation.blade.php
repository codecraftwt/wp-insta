<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Site Creation Notification</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
        }

        .email-container {
            max-width: 700px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            border: 1px solid #ddd;
        }

        .email-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .email-header img {
            max-width: 150px;
            height: auto;
        }

        .email-body {
            font-size: 18px;
            line-height: 1.8;
            color: #444;
            margin-bottom: 30px;
        }

        .email-body strong {
            color: #2F67F6;
        }

        .email-footer {
            text-align: center;
            font-size: 16px;
            color: #777;
            margin-top: 20px;
        }

        .email-footer a {
            color: #2F67F6;
            text-decoration: none;
        }

        .email-footer a:hover {
            text-decoration: underline;
        }

        .btn {
            display: inline-block;
            background-color: #2F67F6;
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
        }

        .btn:hover {
            background-color: #1E4EB8;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header Section -->
        <div class="email-header">
            <img src="{{ $imageUrl }}" alt="Website Logo">
        </div>

        <!-- Body Section -->
        <div class="email-body">
            <p>Hello,</p>
            <p>We are pleased to inform you that your site <strong>{{ $siteName }}</strong> has been successfully
                created.</p>

            <p>As part of the setup process, we have allocated a storage space for your site. Please be aware that your
                site has reached <strong>50% of its storage capacity</strong>. We recommend ensuring that your storage
                is sufficient for future growth. You can manage your storage and other settings directly from your
                account.</p>

            <p>If you have any questions or need assistance, please feel free to reach out to our support team. We're
                here to help you!</p>

            <a href="https://instantwebsitedevelopment.com" class="btn">Visit Support Center</a>
        </div>

        <!-- Footer Section -->
        <div class="email-footer">
            <p>
                Best regards, <br>
                <strong>Instant Website Development Team</strong><br>
                <a href="https://instantwebsitedevelopment.com">Visit our website</a>
            </p>
        </div>
    </div>
</body>

</html>
