<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Ambassador Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 30px;
            border: 1px solid #e0e0e0;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            border-radius: 8px 8px 0 0;
            text-align: center;
            margin: -30px -30px 20px -30px;
        }
        .content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
        }
        .info-row {
            margin: 15px 0;
            padding: 10px;
            background-color: #f5f5f5;
            border-left: 4px solid #4CAF50;
        }
        .label {
            font-weight: bold;
            color: #555;
        }
        .value {
            color: #333;
            margin-top: 5px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            color: #777;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
      
        <div class="content">
            <p>Hello Admin,</p>

            <p>A user has requested to become an ambassador. Here are the details:</p>

            <div class="info-row">
                <div class="label">User Name:</div>
                <div class="value">{{ $user_name }}</div>
            </div>

            <div class="info-row">
                <div class="label">User Email:</div>
                <div class="value">{{ $user_email }}</div>
            </div>

            <div class="info-row">
                <div class="label">User ID:</div>
                <div class="value">{{ $user_id }}</div>
            </div>

            <p style="margin-top: 20px;">Please review this request and take appropriate action.</p>
        </div>

        <div class="footer">
            <p>This is an automated message from your application.</p>
            <p>© {{ date('Y') }} BitgoSpace. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
