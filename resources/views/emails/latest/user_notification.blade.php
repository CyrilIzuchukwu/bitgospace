<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $emailData['subject'] }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            color: #333;
            padding: 20px;
        }

        .email-wrapper {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .email-header {
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
        }

        .email-body {
            line-height: 1.6;
        }

        .email-footer {
            margin-top: 30px;
            font-size: 12px;
            color: #999;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <div class="email-header">
            <h2>Hello {{ $emailData['recipient_name'] ?? 'User' }},</h2>
        </div>

        <div class="email-body">
            <p>{!! $emailData['message'] !!}</p>
        </div>

        <div class="email-footer">
            <p>&copy; {{ date('Y') }} Your Company. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
