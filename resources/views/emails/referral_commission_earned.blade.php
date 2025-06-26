<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Referral Commission Earned - BitGoSpace</title>
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
                            <h1 style="color: #061f6d; font-size: 28px; font-weight: bold; margin: 0 0 10px; line-height: 1.2;">Commission Earned!</h1>
                            <p style="color: #666666; font-size: 16px; margin: 0; line-height: 1.4;">Congratulations! You've earned a referral commission from your network.</p>
                        </td>
                    </tr>

                    <!-- Main Content -->
                    <tr>
                        <td style="padding: 0 30px 30px;">
                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tr>
                                    <td style="background-color: #f8f9fa; padding: 25px; border-radius: 6px; border-left: 4px solid #4CAF50;">
                                        <h2 style="color: #061f6d; font-size: 18px; font-weight: bold; margin: 0 0 15px;">Hello {{ $referrer->name }},</h2>
                                        <p style="color: #333333; font-size: 15px; line-height: 1.6; margin: 0 0 15px;">
                                            Great news! You've earned a <strong style="color: #4CAF50;">Level {{ $level }} referral commission</strong> from {{ $investor->name }}'s recent investment.
                                        </p>
                                        <p style="color: #333333; font-size: 15px; line-height: 1.6; margin: 0;">
                                            Your commission has been automatically credited to your wallet and is ready to use.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Commission Details -->
                    <tr>
                        <td style="padding: 0 30px 30px;">
                            <h3 style="color: #061f6d; font-size: 18px; font-weight: bold; margin: 0 0 20px;">Commission Details:</h3>
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="background-color: #ffffff; border: 2px solid #4CAF50; border-radius: 8px; width: 100% !important; table-layout: fixed;">
                                <tr>
                                    <td style="padding: 25px;">
                                        <table cellpadding="0" cellspacing="0" border="0" width="100%" style="width: 100% !important; table-layout: fixed;">
                                            <!-- Commission Amount -->
                                            <tr>
                                                <td style="padding: 10px 0; border-bottom: 1px solid #e0e0e0;">
                                                    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="width: 100%; table-layout: fixed;">
                                                        <tr>
                                                            <td style="color: #666666; font-size: 14px; font-weight: bold; padding-right: 10px;">Commission Amount:</td>
                                                            <td style="color: #4CAF50; font-size: 18px; font-weight: bold; text-align: right;">${{ number_format($commission, 2) }}</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>

                                            <!-- Commission Level -->
                                            <tr>
                                                <td style="padding: 10px 0; border-bottom: 1px solid #e0e0e0;">
                                                    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="width: 100%; table-layout: fixed;">
                                                        <tr>
                                                            <td style="color: #666666; font-size: 14px; padding-right: 10px;">Commission Level:</td>
                                                            <td style="color: #333333; font-size: 14px; text-align: right;">Level {{ $level }}</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>

                                            <!-- Investor -->
                                            <tr>
                                                <td style="padding: 10px 0; border-bottom: 1px solid #e0e0e0;">
                                                    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="width: 100%; table-layout: fixed;">
                                                        <tr>
                                                            <td style="color: #666666; font-size: 14px; padding-right: 10px;">Investor:</td>
                                                            <td style="color: #333333; font-size: 14px; text-align: right;">{{ $investor->name }}</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>

                                            <!-- Date Earned -->
                                            <tr>
                                                <td style="padding: 10px 0;">
                                                    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="width: 100%; table-layout: fixed;">
                                                        <tr>
                                                            <td style="color: #666666; font-size: 14px; padding-right: 10px;">Date Earned:</td>
                                                            <td style="color: #333333; font-size: 14px; text-align: right;">{{ now()->format('M d, Y') }}</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <!-- Benefits Section -->
                    <tr>
                        <td style="padding: 0 30px 30px;">
                            <h3 style="color: #061f6d; font-size: 18px; font-weight: bold; margin: 0 0 20px;">Keep Growing Your Network:</h3>
                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tr>
                                    <td style="padding: 15px; background-color: #ffffff; border: 1px solid #e0e0e0; border-radius: 6px; margin-bottom: 10px;">
                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                            <tr>
                                                <td style="vertical-align: top; padding-left: 15px;">
                                                    <h4 style="color: #061f6d; font-size: 16px; font-weight: bold; margin: 0 0 5px;">📈 Level 1: 6% Commission</h4>
                                                    <p style="color: #666666; font-size: 14px; margin: 0; line-height: 1.4;">Direct referrals earn you the highest commission rate</p>
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
                                                    <h4 style="color: #061f6d; font-size: 16px; font-weight: bold; margin: 0 0 5px;">📊 Level 2: 2.5% Commission</h4>
                                                    <p style="color: #666666; font-size: 14px; margin: 0; line-height: 1.4;">Earn from your referrals' referrals</p>
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
                                                    <h4 style="color: #061f6d; font-size: 16px; font-weight: bold; margin: 0 0 5px;">🎯 Level 3: 1% Commission</h4>
                                                    <p style="color: #666666; font-size: 14px; margin: 0; line-height: 1.4;">Build a deeper network for passive income</p>
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
                                        <a href="{{ route('login') }}" style="background-color: #4CAF50; color: #ffffff; text-decoration: none; padding: 15px 30px; border-radius: 6px; font-size: 16px; font-weight: bold; display: inline-block; text-align: center; min-width: 200px;">
                                            View Your Wallet
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            <p style="color: #666666; font-size: 12px; margin: 15px 0 0; line-height: 1.4;">
                                Share your referral link to earn more commissions!
                            </p>
                        </td>
                    </tr>

                    <!-- Support Section -->
                    <tr>
                        <td style="background-color: #f8f9fa; padding: 25px 30px; border-top: 1px solid #e0e0e0;">
                            <h3 style="color: #061f6d; font-size: 16px; font-weight: bold; margin: 0 0 15px;">Need Help?</h3>
                            <p style="color: #666666; font-size: 14px; line-height: 1.5; margin: 0 0 15px;">
                                If you have any questions about your referral commissions or need assistance, our support team is here to help you 24/7.
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
                            <!-- YouTube Logo on its own line -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 0 auto 15px;">
                                <tr>
                                    <td style="padding-bottom: 8px;" align="center">
                                        <a href="https://www.youtube.com/channel/UCGcJhZzM8xEcir2O-HqR9WQ" target="_blank">
                                            <img src="https://res.cloudinary.com/dpfcntrwo/image/upload/v1750930721/youtube1_lfeokf.jpg"
                                                alt="YouTube"
                                                style="width: 24px; border-radius: 2px; display: inline-block; vertical-align: middle;">
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="color: #ffffff; font-size: 14px; margin: 0 0 10px; line-height: 1.4;">
                                Thank you for growing the BitGoSpace community
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
