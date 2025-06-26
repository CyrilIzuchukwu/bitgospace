<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Deposit Approved | BitGoSpace</title>
</head>

<body style="font-family: 'Arial', sans-serif; line-height: 1.6; color: #333333; max-width: 660px; margin: 0 auto; padding: 5px;">
    <!-- Header with logo -->
    <table width="100%" cellspacing="0" cellpadding="0" style="background-color: #061f6d; padding: 25px; border-radius: 8px 8px 0 0;">
        <tr>
            <td align="center">
                <img src="https://res.cloudinary.com/dpfcntrwo/image/upload/v1750386782/logo-dark_sezbb6.png" alt="BitGoSpace Logo" style="height:40px; width:auto;">
            </td>
        </tr>
    </table>

    <!-- Main content -->
    <table width="100%" cellspacing="0" cellpadding="25" style="background-color: #ffffff; border: 1px solid #e1e1e1; border-top: none; border-radius: 0 0 8px 8px;">
        <tr>
            <td>
                <p style="margin-top: 0;">Dear {{ $data['name'] }},</p>

                <p style="line-height: 22px;">We're pleased to inform you that your deposit of <strong>${{ number_format($data['amount'], 2) }}</strong> has been approved and credited to your BitGoSpace account.</p>

                <!-- Transaction details card -->
                <table width="100%" cellspacing="0" cellpadding="0" style="background-color: #f8f9fa; border-radius: 6px; margin: 25px 0; border: 1px solid #e1e1e1;">
                    <tr>
                        <td style="padding: 15px; border-bottom: 1px solid #e1e1e1;">
                            <strong style="color: #061f6d;">Transaction Amount</strong>
                        </td>
                        <td style="padding: 15px; border-bottom: 1px solid #e1e1e1; text-align: right; font-weight: 600;">
                            ${{ number_format($data['amount'], 2) }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 15px; border-bottom: 1px solid #e1e1e1;">
                            <strong style="color: #061f6d;">Crypto Amount</strong>
                        </td>
                        <td style="padding: 15px; border-bottom: 1px solid #e1e1e1; text-align: right; font-weight: 600;">
                            {{ number_format($data['crypto_amount'], 8) }} {{ $data['currency'] }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 15px; border-bottom: 1px solid #e1e1e1;">
                            <strong style="color: #061f6d;">Approval Date</strong>
                        </td>
                        <td style="padding: 15px; border-bottom: 1px solid #e1e1e1; text-align: right;">
                            {{ $data['date'] }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 15px;">
                            <strong style="color: #061f6d;">New Account Balance</strong>
                        </td>
                        <td style="padding: 15px; text-align: right; font-weight: 600; color: #28a745;">
                            ${{ number_format($data['new_balance'], 2) }}
                        </td>
                    </tr>
                </table>

                <!-- Status badge -->
                <table width="100%" cellspacing="0" cellpadding="0" style="margin: 20px 0;">
                    <tr>
                        <td align="center" style="padding: 10px; background-color: #e6f7ee; border-radius: 4px; border: 1px solid #c3e6cb;">
                            <span style="color: #28a745; font-weight: 600;">✓ Deposit Successfully Processed</span>
                        </td>
                    </tr>
                </table>

                <!-- Action button -->
                <table width="100%" cellspacing="0" cellpadding="0" style="margin: 30px 0;">
                    <tr>
                        <td align="center">
                            <a href="{{ route('user.dashboard') }}" style="background-color: #061f6d; color: #ffffff; padding: 14px 30px; text-decoration: none; border-radius: 4px; display: inline-block; font-weight: 600; font-size: 15px;">Go to Dashboard</a>
                        </td>
                    </tr>
                </table>

                <p style="margin-bottom: 5px;">If you have any questions about this transaction, our support team is available 24/7 to assist you.</p>

                <p style="margin-top: 20px;">Best regards,<br><strong style="color: #061f6d;">The BitGoSpace Team</strong></p>
            </td>
        </tr>
    </table>

    <!-- Footer -->
    <table width="100%" cellspacing="0" cellpadding="20" style="margin-top: 20px; color: #777777; font-size: 12px;">
        <tr>
            <td align="center">
                <!-- YouTube Logo -->
                <div style="margin-bottom: 15px;">
                    <a href="https://www.youtube.com/channel/UCGcJhZzM8xEcir2O-HqR9WQ" target="_blank" style="display: inline-block;">
                        <img src="https://res.cloudinary.com/dpfcntrwo/image/upload/v1750930721/youtube1_lfeokf.jpg"
                            alt="YouTube"
                            style="width: 24px; border-radius: 2px; vertical-align: middle;">
                    </a>
                </div>

                <p style="margin: 0 0 10px 0;">© 2022 {{ config('app.name') }}. All rights reserved.</p>
                <p style="margin: 0;">
                    <a href="{{ route('privacy-policy') }}" style="color: #061f6d; text-decoration: none; margin: 0 10px;">Privacy Policy</a>
                    <a href="{{ route('terms') }}" style="color: #061f6d; text-decoration: none; margin: 0 10px;">Terms of Service</a>
                    <a href="{{ route('contact') }}" style="color: #061f6d; text-decoration: none; margin: 0 10px;">Contact Us</a>
                </p>
                <p style="margin: 10px 0 0 0;">This is an automated message, please do not reply directly.</p>
            </td>
        </tr>
    </table>
</body>

</html>
