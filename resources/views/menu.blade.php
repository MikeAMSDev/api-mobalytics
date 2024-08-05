<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index - API of Mobalitycs</title>
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
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .welcome-container h1 {
            color: #333;
            margin-bottom: 20px;
        }
        .welcome-container p {
            color: #666;
            font-size: 18px;
            margin-bottom: 30px;
        }
        .welcome-container a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }
        .welcome-container a:hover {
            text-decoration: underline;
        }
        .welcome-container button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }
        .welcome-container button:hover {
            background-color: #0056b3;
        }
        .logout-button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <h1>¡Welcome!</h1>
        <p>You are now logged in. You can now continue with your activities.</p>
        <button onclick="window.location.href='/log-viewer';">Go to logs</button>
        <button onclick="window.location.href='/docs/api';">Go to documentation</button>
        <form id="logout-form" action="/welcome/logout" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="logout-button">Logout</button>
        </form>
    </div>
</body>
</html>