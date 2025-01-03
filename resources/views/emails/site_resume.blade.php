<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Site Resume Notification</title>
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
        }

        .resume-container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border: 1px solid #ddd;
        }

        .resume-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .resume-header img {
            max-width: 150px;
            height: auto;
        }

        .resume-body {
            font-size: 16px;
            line-height: 1.6;
            color: #333;
        }

        .resume-body strong {
            color: #2F67F6;
        }

        .resume-footer {
            text-align: center;
            font-size: 14px;
            color: #777;
            margin-top: 20px;
        }

        .resume-footer a {
            color: #2F67F6;
            text-decoration: none;
        }

        .resume-footer a:hover {
            text-decoration: underline;
        }

        .btn {
            display: inline-block;
            background-color: #2F67F6;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 20px;
        }

        .btn:hover {
            background-color: #1E4EB8;
        }
    </style>
</head>

<body>
    <div class="resume-container">
        <div class="resume-header">
            <img src="{{ $imageUrl }}" alt="Walstar Logo">
        </div>

        <div class="resume-body">
            <p>Hello <strong>{{ $userName }}</strong>,</p>
            <p>
                We would like to inform you that the site "<strong>{{ $siteName }}</strong>" has been successfully
                resumed
                and is now back online.
            </p>
            <p>
                Feel free to visit and continue building your site. If you encounter any issues or need assistance,
                don't hesitate to reach out to our support team.
            </p>
            <p>We hope you enjoy creating your site with us!</p>
        </div>

        <div class="resume-footer">
            <p>
                Best regards, <br>
                <strong>Instant Website Development</strong><br>
                <a href="https://instantwebsitedevelopment.com">instantwebsitedevelopment.com</a>
            </p>
        </div>
    </div>
</body>

</html>
