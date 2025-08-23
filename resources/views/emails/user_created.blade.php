<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to Menu-AR</title>
    <style>
        body {
            background-color: #f1f1f1;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #000;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 40px 50px;
            border-radius: 50px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 90%;
        }

        h2 {
            color: #000;
            margin-top: 0;
        }

        p {
            line-height: 1.6;
            margin: 15px 0;
        }

        strong {
            color: #000;
        }

        .footer {
            margin-top: 30px;
            font-style: italic;
        }

        a {
            color: #000;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome, {{ $name }}!</h2>
        <p>Your account has been successfully created.</p>
        <p><strong>Email:</strong> {{ $email }}</p>
        <p><strong>Password:</strong> {{ $password }}</p>
        <p>
            To get started, please visit
            <a href="https://menu-ar.com" target="_blank">menu-ar.com</a>
            and create your dish groups and dishes. This will allow us to set up your images and 3D models.
        </p>
        <p class="footer">Best regards,<br>The Menu-AR Team</p>
    </div>
</body>
</html>
