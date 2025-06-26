<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BitGoSpace Email Verification</title>
</head>

<body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color:#f5f7fa;">
    <!-- Main Container -->
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#f5f7fa; padding:40px 0;">
        <tr>
            <td align="center">
                <!-- Email Container -->
                <table width="630" border="0" cellspacing="0" cellpadding="0" style="background:#ffffff; border-radius:8px; box-shadow:0 4px 12px rgba(0,0,0,0.1); overflow:hidden;">
                    <!-- Header with Gradient -->
                    <tr>
                        <td style="background: #061f6d; padding:30px 0; text-align:center;">
                            <img src="https://res.cloudinary.com/dpfcntrwo/image/upload/v1750386782/logo-dark_sezbb6.png" alt="BitGoSpace Logo" style="height:40px; width:auto;">
                        </td>
                    </tr>

                    <!-- Content Area -->
                    <tr>
                        <td style="padding:40px 30px; text-align:center;">
                            <h1 style="margin:0 0 20px 0; color:#2d3748; font-size:24px; font-weight:600;">Verify Your Email Address</h1>

                            <p style="margin:0 0 25px 0; color:#4a5568; font-size:16px; line-height:28px;">
                                Thank you for registering with BitGoSpace. To complete your registration, please use the following One-Time Password (OTP) to verify your email address:
                            </p>

                            <!-- OTP Box -->
                            <div style="background:#f8fafc; border-radius:6px; padding:15px 0; margin:0 auto 30px auto; width:80%; max-width:300px; border:1px dashed #e2e8f0;">
                                <span style="font-size:28px; font-weight:700; letter-spacing:5px; color:#061f6d;">{{ $otp_code }}</span>
                            </div>

                            <p style="margin:0 0 25px 0; color:#4a5568; font-size:14px; line-height:28px;">
                                If you didn't request this, please ignore this email.
                            </p>

                            <div style="border-top:1px solid #e2e8f0; padding-top:25px; margin-top:25px;">
                                <p style="margin:0; color:#718096; font-size:12px;">
                                    For security reasons, do not share this code with anyone.
                                </p>
                            </div>
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
