<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <style>
        /* Reset styles */
        body,
        html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            color: #000000;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .content {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo">
            <!-- Your logo goes here -->
            <img src="https://example.com/logo.png" alt="Logo">
        </div>
        <div class="content">
            <h2>Password Reset</h2>
            <p>Hello,</p>
            <p>We received a request to reset your password. Click the link below to reset it:</p>
            <p><a href="http://localhost:5174/auth/resetpassword/{{ $token }}">Reset Password</a></p>
            <p>If you didn't request a password reset, you can safely ignore this email.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Your Company. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
