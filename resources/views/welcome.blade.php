<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API de Mobalitycs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #142c31;
        }
        .welcome-container {
            text-align: center;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .welcome-container h1 {
            color: #333;
        }
        .welcome-container p {
            color: #666;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .welcome-container .login-button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .welcome-container .login-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <h1>Welcome to API of Mobalitycs</h1>
        <p>We are pleased to welcome you to the Mobalitycs API. Please log in to continue.</p>
        <a href="/welcome/login" class="login-button">Login</a>
    </div>
</body>
</html>
