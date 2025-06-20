<!DOCTYPE html>
<html>

<head>
    <title>PIN Reset OTP</title>
</head>

<body>
    <h2>PIN Reset Request</h2>
    <p>You have requested to reset your withdrawal PIN. Here is your OTP code:</p>

    <div style="font-size: 24px; font-weight: bold; margin: 20px 0;">
        {{ $otp }}
    </div>

    <p>This code will expire in 15 minutes.</p>
    <p>If you didn't request this, please contact support immediately.</p>
</body>

</html>
