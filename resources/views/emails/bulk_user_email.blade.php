<!DOCTYPE html>
<html>
<head>
    <title>{{ $emailData['subject'] }}</title>
</head>
<body>
    <h2>Hello {{ $emailData['recipient_name'] }},</h2>

    <div>
        {!! nl2br(e($emailData['message'])) !!}
    </div>

    <br>
    <p>Best regards,</p>
    <p>{{ config('app.name') }}</p>
</body>
</html>
