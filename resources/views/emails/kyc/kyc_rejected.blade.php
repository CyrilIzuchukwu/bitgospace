<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KYC Rejected - BitGoSpace</title>
</head>

<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="background-color: #f4f4f4; padding: 10px 0;">
        <tr>
            <td align="center">
                <!-- Main Container -->
                <table cellpadding="0" cellspacing="0" border="0" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); overflow: hidden; max-width: 640px;">

                    <!-- Header -->
                    <tr>
                        <td style="background-color: #061f6d; padding: 30px; text-align: center;">
                            <img src="https://res.cloudinary.com/dpfcntrwo/image/upload/v1750386782/logo-dark_sezbb6.png" alt="BitGoSpace Logo" style="height: 40px; width: auto; display: block; margin: 0 auto;">
                        </td>
                    </tr>

                    <!-- Title -->
                    <tr>
                        <td style="padding: 40px 30px 20px; text-align: center;">
                            <h1 style="color: #061f6d; font-size: 24px; font-weight: bold; margin: 0 0 10px; line-height: 1.2;">KYC Verification Not Approved</h1>
                            <p style="color: #666666; font-size: 16px; margin: 0; line-height: 1.4;">We couldn't verify your identity with the provided documents.</p>
                        </td>
                    </tr>

                    <!-- Main Content -->
                    <tr>
                        <td style="padding: 0 30px 30px;">
                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tr>
                                    <td style="background-color: #f8f9fa; padding: 25px; border-radius: 6px; border-left: 4px solid #d32f2f;">
                                        <h2 style="color: #061f6d; font-size: 18px; font-weight: bold; margin: 0 0 15px;">Hello {{ $user->name ?? 'Valued Customer' }},</h2>
                                        <p style="color: #333333; font-size: 15px; line-height: 1.6; margin: 0 0 15px;">
                                            We regret to inform you that your KYC (Know Your Customer) verification has <strong style="color: #d32f2f;">not been approved</strong>.
                                        </p>
                                        <p style="color: #333333; font-size: 15px; line-height: 1.6; margin: 0 0 15px;">
                                            <strong>Reason:</strong> {{ $rejectionReason }}
                                        </p>
                                        <p style="color: #333333; font-size: 15px; line-height: 1.6; margin: 0;">
                                            Please review the reason above and submit new documents for verification.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Next Steps -->
                    <tr>
                        <td style="padding: 0 30px 30px;">
                            <h3 style="color: #061f6d; font-size: 18px; font-weight: bold; margin: 0 0 20px;">What To Do Next:</h3>
                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tr>
                                    <td style="padding: 15px; background-color: #ffffff; border: 1px solid #e0e0e0; border-radius: 6px; margin-bottom: 10px;">
                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                            <tr>
                                                <td style="vertical-align: top; padding-left: 15px;">
                                                    <h4 style="color: #061f6d; font-size: 16px; font-weight: bold; margin: 0 0 5px;">Review Requirements</h4>
                                                    <p style="color: #666666; font-size: 14px; margin: 0; line-height: 1.4;">Check our KYC documentation requirements</p>
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
                                                    <h4 style="color: #061f6d; font-size: 16px; font-weight: bold; margin: 0 0 5px;">Resubmit Documents</h4>
                                                    <p style="color: #666666; font-size: 14px; margin: 0; line-height: 1.4;">Upload clear, valid documents that meet our requirements</p>
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
                                                    <h4 style="color: #061f6d; font-size: 16px; font-weight: bold; margin: 0 0 5px;">Contact Support</h4>
                                                    <p style="color: #666666; font-size: 14px; margin: 0; line-height: 1.4;">If you need clarification about the rejection</p>
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
                                        <a href="{{ route('user.kyc') }}" style="background-color: #061f6d; color: #ffffff; text-decoration: none; padding: 15px 30px; border-radius: 6px; font-size: 16px; font-weight: bold; display: inline-block; text-align: center; min-width: 200px;">
                                            Resubmit KYC Documents
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
                                Our support team is available to help you with the verification process.
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
                            <p style="color: #ffffff; font-size: 14px; margin: 0 0 10px; line-height: 1.4;">
                                BitGoSpace - Your AI Arbitrage Advantage in Crypto!
                            </p>
                            <p style="color: #b3c3f7; font-size: 12px; margin: 0; line-height: 1.4;">
                                If you have any concerns about this email, please contact our support team.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
