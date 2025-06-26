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

                    <tr>
                        <td style="background-color: #f8f9fa; padding: 20px; padding-top: 15px; padding-bottom: 15px; border-top: 1px solid #e0e0e0;" align="center">

                            <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                                <tr>
                                    <td style="padding-bottom: 8px;" align="center">
                                        <a href="https://www.youtube.com/channel/UCGcJhZzM8xEcir2O-HqR9WQ" target="_blank">
                                            <img src="https://res.cloudinary.com/dpfcntrwo/image/upload/v1750930721/youtube1_lfeokf.jpg" alt="YouTube" style="width: 24px; border-radius: 2px; display: inline-block; vertical-align: middle;">
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="middle" style="font-size: 12px; color: #7f8c8d;">
                                        © 2022 {{ config('app.name') }}. All rights reserved.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
