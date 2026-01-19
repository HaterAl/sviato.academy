<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey Access Required</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background: white;
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            padding: 60px 40px;
            text-align: center;
            max-width: 600px;
            width: 100%;
        }

        .icon {
            font-size: 64px;
            margin-bottom: 24px;
            color: #ff6b6b;
        }

        .title {
            font-size: 2rem;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 16px;
        }

        .message {
            color: #666;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 32px;
        }

        .steps {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 32px;
            text-align: left;
        }

        .steps h3 {
            color: #1a1a2e;
            margin-bottom: 16px;
            text-align: center;
        }

        .steps ol {
            padding-left: 20px;
        }

        .steps li {
            margin-bottom: 8px;
            color: #666;
        }

        .btn {
            display: inline-block;
            padding: 14px 32px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(102, 126, 234, 0.4);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">🔒</div>
        <h1 class="title">Survey Access Required</h1>
        <p class="message">
            This survey requires a valid access token. You need to use a special survey link to participate.
        </p>
        
        <div class="steps">
            <h3>How to access the survey:</h3>
            <ol>
                <li>Check your email for the survey invitation</li>
                <li>Click the unique survey link provided</li>
                <li>The link will contain your personal access token</li>
                <li>Complete the survey using that link</li>
            </ol>
        </div>
        
        <p class="message">
            If you don't have a survey link or need assistance, please contact our support team.
        </p>
    </div>
</body>
</html>