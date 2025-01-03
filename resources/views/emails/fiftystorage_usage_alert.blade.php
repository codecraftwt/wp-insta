<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Storage Alert: 50% Usage</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
        }

        .storage-usage-container {
            max-width: 700px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            border: 1px solid #ddd;
        }

        .storage-usage-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .storage-usage-header img {
            max-width: 180px;
            height: auto;
        }

        .storage-usage-body {
            font-size: 18px;
            line-height: 1.8;
            color: #444;
            margin-bottom: 30px;
        }

        .storage-usage-body strong {
            color: #2F67F6;
        }

        .storage-usage-footer {
            text-align: center;
            font-size: 16px;
            color: #777;
            margin-top: 20px;
        }

        .storage-usage-footer a {
            color: #2F67F6;
            text-decoration: none;
        }

        .storage-usage-footer a:hover {
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
    <div class="storage-usage-container">
        <!-- Header Section -->
        <div class="storage-usage-header">
            <img src="{{ $imageUrl }}" alt="Walstar Logo">
        </div>

        <!-- Body Section -->
        <div class="storage-usage-body">
            <p>Hello <strong>{{ $name }}</strong>,</p>

            <p>We would like to inform you that you have used 50% of your storage capacity. Please ensure you have
                enough space for future data usage.</p>

            <p>If you need assistance or wish to upgrade your storage, feel free to reach out.</p>
        </div>

        <!-- Footer Section -->
        <div class="storage-usage-footer">
            <p>
                Best regards, <br>
                <strong>Instant Website Development</strong><br>
                <a href="https://instantwebsitedevelopment.com">instantwebsitedevelopment.com</a>
            </p>
        </div>
    </div>
</body>

</html>
