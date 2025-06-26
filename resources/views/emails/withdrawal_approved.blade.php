<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Withdrawal Approved</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333333; max-width: 650px; margin: 0 auto; padding: 10px;">
    <!-- Header with logo -->
    <table width="100%" cellspacing="0" cellpadding="0" style="background-color: #061f6d; padding: 20px; border-radius: 8px 8px 0 0;">
        <tr>
            <td align="center">
                <img src="https://res.cloudinary.com/dpfcntrwo/image/upload/v1750386782/logo-dark_sezbb6.png" alt="BitGoSpace Logo" style="height:40px; width:auto;">
            </td>
        </tr>
    </table>

    <!-- Main content -->
    <table width="100%" cellspacing="0" cellpadding="20" style="background-color: #ffffff; border: 1px solid #e1e1e1; border-top: none; border-radius: 0 0 8px 8px;">
        <tr>
            <td>
                <h2 style="color: #061f6d; margin-top: 0;">Withdrawal Successfully Processed</h2>

                <p>Dear {{ $withdrawal->user->name }},</p>

                <p style="line-height: 22px;">We're pleased to inform you that your withdrawal request has been approved and processed successfully.</p>

                <!-- Transaction details -->
                <table width="100%" cellspacing="0" cellpadding="15" style="background-color: #f8f9fa; border-radius: 6px; margin: 20px 0;">
                    <tr>
                        <td width="40%" style="padding: 10px; border-bottom: 1px solid #e1e1e1;"><strong>Amount:</strong></td>
                        <td style="padding: 10px; border-bottom: 1px solid #e1e1e1;">${{ number_format($withdrawal->amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td width="40%" style="padding: 10px; border-bottom: 1px solid #e1e1e1;"><strong>Payment Method:</strong></td>
                        <td style="padding: 10px; border-bottom: 1px solid #e1e1e1;">{{ ucfirst($withdrawal->payment_method) }}</td>
                    </tr>
                    <tr>
                        <td width="40%" style="padding: 10px; border-bottom: 1px solid #e1e1e1;"><strong>Wallet Address:</strong></td>
                        <td style="padding: 10px; border-bottom: 1px solid #e1e1e1;">{{ $withdrawal->wallet_address }}</td>
                    </tr>
                    <tr>
                        <td width="40%" style="padding: 10px;"><strong>Reference Number:</strong></td>
                        <td style="padding: 10px;">{{ $withdrawal->reference }}</td>
                    </tr>
                </table>

                <p>The funds should be credited to your account according to your payment provider's processing times.</p>

                <!-- Action button -->
                <table width="100%" cellspacing="0" cellpadding="0" style="margin: 25px 0;">
                    <tr>
                        <td align="center">
                            <a href="{{ route('user.withdrawal.history') }}" style="background-color: #061f6d; color: #ffffff; padding: 12px 25px; text-decoration: none; border-radius: 4px; display: inline-block; font-weight: bold;">View Transaction History</a>
                        </td>
                    </tr>
                </table>

                <p>If you have any questions about this transaction, please don't hesitate to contact our support team.</p>

                <p>Best regards,<br>The BitGoSpace Team</p>
            </td>
        </tr>
    </table>

    <!-- Footer -->
    <table width="100%" cellspacing="0" cellpadding="15" style="margin-top: 20px; color: #777777; font-size: 12px;">
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

                <p>© 2022 {{ config('app.name') }}. All rights reserved.</p>
                <p>
                    <a href="{{ route('privacy-policy') }}" style="color: #061f6d; text-decoration: none;">Privacy Policy</a> |
                    <a href="{{ route('terms') }}" style="color: #061f6d; text-decoration: none;">Terms of Service</a>
                </p>
            </td>
        </tr>
    </table>
</body>

</html>
