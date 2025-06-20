<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Verification Code</title>
</head>

<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f7f9fc;">
    <!-- Main container -->
    <table width="100%" cellspacing="0" cellpadding="0" style="max-width: 650px; margin: 0 auto;">
        <tr>
            <td style="padding: 10px;">
                <!-- Card container -->
                <table width="100%" cellspacing="0" cellpadding="0" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);">
                    <!-- Header with logo -->
                    <tr>
                        <td style="background-color: #061f6d; padding: 20px; text-align: center; border-radius: 8px 8px 0 0;">
                            <img src="https://res.cloudinary.com/dpfcntrwo/image/upload/v1750386782/logo-dark_sezbb6.png" alt="BitGoSpace Logo" style="height:40px; width:auto;">
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 30px;">
                            <h2 style="margin: 0 0 20px 0; font-size: 20px; color: #333333;">New Email Verification Code</h2>

                            <p style="margin: 0 0 15px 0; line-height: 22px;">Hello,</p>

                            <p style="margin: 0 0 15px 0; line-height: 22px;">Here is your new verification code:</p>

                            <!-- OTP Container -->
                            <table width="100%" cellspacing="0" cellpadding="0" style="background-color: #f3f7fe; border: 1px dashed #4986DB; border-radius: 6px; padding: 15px; text-align: center; margin: 25px 0;">
                                <tr>
                                    <td>
                                        <p style="font-size: 32px; font-weight: 600; letter-spacing: 3px; color: #4986DB; margin: 10px 0;">{{ $otp }}</p>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 15px 0; line-height: 22px;">Please do not share this code with anyone.</p>

                            <p style="margin: 15px 0; line-height: 22px;">If you didn't request this code, you can safely ignore this email.</p>

                            <p style="margin: 15px 0 0 0; line-height: 22px;">
                                Thank you,<br>
                                {{ config('app.name') }}
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="text-align: center; padding: 20px; color: #666666; font-size: 12px; border-top: 1px solid #eeeeee;">
                            <p style="margin: 0;">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
