<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DRBS Test Page</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .status {
            display: inline-block;
            padding: 10px 20px;
            background: #4CAF50;
            border-radius: 50px;
            margin: 20px 0;
            font-weight: bold;
        }

        .info {
            background: rgba(255, 255, 255, 0.2);
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: left;
        }

        .info h3 {
            margin-bottom: 10px;
            color: #fff;
        }

        .info ul {
            list-style: none;
            padding-left: 0;
        }

        .info li {
            padding: 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .info li:last-child {
            border-bottom: none;
        }

        .links {
            margin-top: 30px;
        }

        .links a {
            display: inline-block;
            padding: 12px 30px;
            background: white;
            color: #764ba2;
            text-decoration: none;
            border-radius: 50px;
            margin: 10px;
            font-weight: bold;
            transition: transform 0.3s ease;
        }

        .links a:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        }

        .check {
            display: inline-block;
            color: #4CAF50;
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>✓ DRBS Internet</h1>
        <div class="status">Server Running Successfully</div>

        <div class="info">
            <h3>System Status</h3>
            <ul>
                <li><span class="check">✓</span> Laravel Framework: Working</li>
                <li><span class="check">✓</span> Blade Templates: Working</li>
                <li><span class="check">✓</span> Routes: Working</li>
                <li><span class="check">✓</span> Server: Active</li>
            </ul>
        </div>

        <div class="info">
            <h3>Server Information</h3>
            <ul>
                <li><strong>PHP Version:</strong> {{ phpversion() }}</li>
                <li><strong>Laravel Version:</strong> {{ app()->version() }}</li>
                <li><strong>Environment:</strong> {{ app()->environment() }}</li>
                <li><strong>Current Time:</strong> {{ now()->format('Y-m-d H:i:s') }}</li>
            </ul>
        </div>

        <div class="links">
            <a href="/">Go to Landing Page</a>
            <a href="/register">Registration Page</a>
            <a href="/support">Support Page</a>
        </div>

        <p style="margin-top: 30px; opacity: 0.8;">
            If you can see this page, your Laravel installation is working correctly!
        </p>
    </div>
</body>
</html>
