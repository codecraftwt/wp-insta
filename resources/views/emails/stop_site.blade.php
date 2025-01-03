<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Site Stop Notification</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
        }

        .stop-container {
            max-width: 700px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            border: 1px solid #ddd;
        }

        .stop-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .stop-header img {
            max-width: 180px;
            height: auto;
        }

        .stop-body {
            font-size: 18px;
            line-height: 1.8;
            color: #444;
            margin-bottom: 30px;
        }

        .stop-body strong {
            color: #2F67F6;
        }

        .stop-footer {
            text-align: center;
            font-size: 16px;
            color: #777;
            margin-top: 20px;
        }

        .stop-footer a {
            color: #2F67F6;
            text-decoration: none;
        }

        .stop-footer a:hover {
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
    <div class="stop-container">
        <!-- Header Section -->
        <div class="stop-header">
            <img src="{{ $imageUrl }}" alt="Walstar Logo">
        </div>

        <!-- Body Section -->
        <div class="stop-body">
            <p>Hello <strong>{{ $userName }}</strong>,</p>
            <p>
                We regret to inform you that the site "<strong>{{ $siteName }}</strong>" has been successfully
                stopped.
            </p>
            <p>
                If this action was unintentional or if you need any assistance, please do not hesitate to contact our
                support team.
            </p>
            <p>
                You can also reach out to us if you'd like to restore your site or need further guidance.
            </p>
            <p style="text-align: center;">
                <a href="https://instantwebsitedevelopment.com" class="btn">Contact Support</a>
            </p>
        </div>

        <!-- Footer Section -->
        <div class="stop-footer">
            <p>
                Best regards, <br>
                <strong>Instant Website Development</strong><br>
                <a href="https://instantwebsitedevelopment.com">instantwebsitedevelopment.com</a>
            </p>
        </div>
    </div>
</body>

</html>
