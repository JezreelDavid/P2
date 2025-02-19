<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .success-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            text-align: center;
        }

        .success-icon {
            color: #28a745;
            font-size: 48px;
            margin-bottom: 20px;
        }

        h1 {
            color: #28a745;
            margin-bottom: 20px;
        }

        p {
            color: #666;
            margin-bottom: 20px;
        }

        .buttons {
            margin-top: 30px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 0 10px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #0056b3;
        }

        .home-button {
            background-color: #28a745;
        }

        .home-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-icon">✓</div>
        <h1>Booking Successful!</h1>
        <p class="mb-4">Thank you for submitting your application. We will review your information and contact you soon.</p>
        <p>Please wait for the confirmation of your schedule through email or text message.</p>
        <p>Thank you for choosing our services!</p>
        <div class="buttons">
            <a href="index.php" class="button home-button">Return to Home</a>
            <a href="calend.php" class="button">Book Another Service</a>
        </div>
    </div>
</body>
</html> 