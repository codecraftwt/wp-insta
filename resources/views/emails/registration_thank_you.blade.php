<!DOCTYPE html>
<html>

<head>
    <title>Welcome to WalstarWP</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f4f8;
            color: #4a4a4a;
        }

        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .email-header {
            background-color: #0077cc;
            color: #ffffff;
            padding: 25px;
            text-align: center;
        }

        .email-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }

        .email-body {
            padding: 30px;
            text-align: center;
        }

        .email-body h2 {
            font-size: 22px;
            color: #333333;
            margin-bottom: 15px;
        }

        .email-body p {
            font-size: 16px;
            line-height: 1.6;
            margin: 10px 0 20px;
        }

        .button {
            display: inline-block;
            margin-top: 15px;
            padding: 12px 25px;
            background-color: #0077cc;
            color: #ffffff;
            text-decoration: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
        }



        .email-footer {
            background-color: #f7f7f7;
            padding: 15px;
            font-size: 14px;
            color: #777777;
            text-align: center;
            border-top: 1px solid #dddddd;
        }

        .email-footer a {
            color: #0077cc;
            text-decoration: none;
        }

        .email-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Welcome to Walstar WP!</h1>
        </div>
        <div class="email-body">
            <h2>We're thrilled to have you with us!</h2>
            <p>Thank you for joining WalstarWP. Start exploring our features and create amazing experiences.</p>
            <p>If you ever need assistance, our team is here to help!</p>

            <!-- Display email and password -->
            <p><strong>Your Email:</strong> {{ $email }}</p>
            <p><strong>Your Password:</strong> {{ $password }}</p>

            <a href="http://127.0.0.1:8000/login" class="button">Explore Now</a>
        </div>
        <div class="email-footer">
            <p>Have questions? <a href="http://127.0.0.1:8000/contact">Visit our Help Center</a> or reply to this email.
            </p>
            <p>&copy; 2024 WalstarWP. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
