<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KYC Approved - BitGoSpace</title>
</head>

<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="background-color: #f4f4f4; padding: 10px 0;">
        <tr>
            <td align="center">
                <!-- Main Container -->
                <table cellpadding="0" cellspacing="0" border="0" width="600" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); overflow: hidden;">

                    <!-- Header -->
                    <tr>
                        <td style="background-color: #061f6d; padding: 30px; text-align: center;">
                            <img src="https://res.cloudinary.com/dpfcntrwo/image/upload/v1750386782/logo-dark_sezbb6.png" alt="BitGoSpace Logo" style="height: 40px; width: auto; display: block; margin: 0 auto;">
                        </td>
                    </tr>

                    <!-- Success Icon and Title -->
                    <tr>
                        <td style="padding: 40px 30px 20px; text-align: center;">

                            <h1 style="color: #061f6d; font-size: 28px; font-weight: bold; margin: 0 0 10px; line-height: 1.2;">KYC Verification Approved!</h1>
                            <p style="color: #666666; font-size: 16px; margin: 0; line-height: 1.4;">Congratulations! Your identity verification has been successfully completed.</p>
                        </td>
                    </tr>

                    <!-- Main Content -->
                    <tr>
                        <td style="padding: 0 30px 30px;">
                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tr>
                                    <td style="background-color: #f8f9fa; padding: 25px; border-radius: 6px; border-left: 4px solid #061f6d;">
                                        <h2 style="color: #061f6d; font-size: 18px; font-weight: bold; margin: 0 0 15px;">Hello {{ $user->name ?? 'Valued Customer' }},</h2>
                                        <p style="color: #333333; font-size: 15px; line-height: 1.6; margin: 0 0 15px;">
                                            We're excited to inform you that your KYC (Know Your Customer) verification has been <strong style="color: #4CAF50;">successfully approved</strong>!
                                        </p>
                                        <p style="color: #333333; font-size: 15px; line-height: 1.6; margin: 0;">
                                            Your account is now fully verified and you can access all features and services on our platform without any restrictions.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Features Unlocked -->
                    <tr>
                        <td style="padding: 0 30px 30px;">
                            <h3 style="color: #061f6d; font-size: 18px; font-weight: bold; margin: 0 0 20px;">What's Now Available:</h3>
                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tr>
                                    <td style="padding: 15px; background-color: #ffffff; border: 1px solid #e0e0e0; border-radius: 6px; margin-bottom: 10px;">
                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                            <tr>
                                                <td style="vertical-align: top; padding-left: 15px;">
                                                    <h4 style="color: #061f6d; font-size: 16px; font-weight: bold; margin: 0 0 5px;">Higher Transaction Limits</h4>
                                                    <p style="color: #666666; font-size: 14px; margin: 0; line-height: 1.4;">Enjoy increased deposit and withdrawal limits</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr style="margin-top: 4px;">
                                    <td style="padding: 15px; background-color: #ffffff; border: 1px solid #e0e0e0; border-radius: 6px; margin-bottom: 10px;">
                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                            <tr>

                                                <td style="vertical-align: top; padding-left: 15px;">
                                                    <h4 style="color: #061f6d; font-size: 16px; font-weight: bold; margin: 0 0 5px;">Enhanced Security</h4>
                                                    <p style="color: #666666; font-size: 14px; margin: 0; line-height: 1.4;">Your account is now fully secured and protected</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr style="margin-top: 4px;">
                                    <td style="padding: 15px; background-color: #ffffff; border: 1px solid #e0e0e0; border-radius: 6px;">
                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                            <tr>
                                                <td style="vertical-align: top; padding-left: 15px;">
                                                    <h4 style="color: #061f6d; font-size: 16px; font-weight: bold; margin: 0 0 5px;">Premium Features</h4>
                                                    <p style="color: #666666; font-size: 14px; margin: 0; line-height: 1.4;">Access to all platform features and services</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- CTA Button -->
                    <tr>
                        <td style="padding: 0 30px 40px; text-align: center;">
                            <table cellpadding="0" cellspacing="0" border="0" style="margin: 0 auto;">
                                <tr>
                                    <td>
                                        <a href="{{ route('login') }}" style="background-color: #061f6d; color: #ffffff; text-decoration: none; padding: 15px 30px; border-radius: 6px; font-size: 16px; font-weight: bold; display: inline-block; text-align: center; min-width: 200px;">
                                            Access Your Account
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Support Section -->
                    <tr>
                        <td style="background-color: #f8f9fa; padding: 25px 30px; border-top: 1px solid #e0e0e0;">
                            <h3 style="color: #061f6d; font-size: 16px; font-weight: bold; margin: 0 0 15px;">Need Help?</h3>
                            <p style="color: #666666; font-size: 14px; line-height: 1.5; margin: 0 0 15px;">
                                If you have any questions or need assistance, our support team is here to help you 24/7.
                            </p>
                            <table cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="padding-right: 20px;">
                                        <a href="mailto:support@bitgospace.com" style="color: #061f6d; text-decoration: none; font-size: 14px; font-weight: bold;">
                                            📧 support@bitgospace.com
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #061f6d; padding: 25px 30px; text-align: center;">
                            <!-- YouTube Logo -->
                            <div style="margin-bottom: 15px;">
                                <a href="https://www.youtube.com/channel/UCGcJhZzM8xEcir2O-HqR9WQ" target="_blank" style="display: inline-block;">
                                    <img src="https://res.cloudinary.com/dpfcntrwo/image/upload/v1750930721/youtube1_lfeokf.jpg"
                                        alt="YouTube"
                                        style="width: 24px; border-radius: 2px; vertical-align: middle;">
                                </a>
                            </div>

                            <p style="color: #ffffff; font-size: 14px; margin: 0 0 10px; line-height: 1.4;">
                                Thank you for choosing BitGoSpace
                            </p>
                            <p style="color: #b3c3f7; font-size: 12px; margin: 0; line-height: 1.4;">
                                If you have any concerns about this email, please contact our support team.
                            </p>

                            <table cellpadding="0" cellspacing="0" border="0" style="margin: 20px auto 0;">
                                <tr>
                                    <td style="padding: 0 10px;">
                                        <a href="{{ route('privacy-policy') }}" target="_blank" style="color: #ffffff; text-decoration: none; font-size: 12px;">Privacy Policy</a>
                                    </td>
                                    <td style="color: #b3c3f7; font-size: 12px;">|</td>
                                    <td style="padding: 0 10px;">
                                        <a href="{{ route('terms') }}" target="_blank" style="color: #ffffff; text-decoration: none; font-size: 12px;">Terms of Service</a>
                                    </td>
                                    <td style="color: #b3c3f7; font-size: 12px;">|</td>
                                    <td style="padding: 0 10px;">
                                        <a href="{{ route('contact') }}" target="_blank" style="color: #ffffff; text-decoration: none; font-size: 12px;">Contact Us</a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Copyright text -->
                            <p style="color: #b3c3f7; font-size: 12px; margin: 20px 0 0; line-height: 1.4;">
                                © 2022 {{ config('app.name') }}. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>
