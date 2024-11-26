<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $siteSetting->site_title ?? 'InstaWP' }}</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Simple background with soft color */
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fa; /* Light grayish blue */
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .thank-you-container {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }

        .thank-you-header {
            font-size: 2.5rem;
            font-weight: bold;
            color: #2d3e50;
            margin-bottom: 20px;
        }

        .thank-you-message {
            font-size: 1.2rem;
            color: #6c757d;
            margin-bottom: 30px;
        }

        .thank-you-button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 12px 25px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .thank-you-button:hover {
            background-color: #0056b3;
        }

        /* Responsive layout for smaller screens */
        @media (max-width: 768px) {
            .thank-you-header {
                font-size: 2rem;
            }
            .thank-you-message {
                font-size: 1rem;
            }
            .thank-you-button {
                font-size: 0.9rem;
                padding: 10px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="thank-you-container">
        <div class="thank-you-header">
            Thank You!
        </div>
        <div class="thank-you-message">
            Your submission has been successfully received. We'll get back to you shortly.
        </div>
        <button class="thank-you-button" onclick="window.location.href='/login'">Go Back to Homepage</button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
