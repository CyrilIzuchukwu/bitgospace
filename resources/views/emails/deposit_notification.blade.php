<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Deposit Notification</title>
</head>

<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4; padding: 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: #061f6d; padding: 20px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: bold;">
                                New Deposit Request
                            </h1>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 30px;">
                            <p style="margin: 0 0 20px 0;">Hello Admin,</p>
                            <p style="margin: 0 0 20px 0;">A new deposit request has been submitted and requires verification:</p>

                            <table width="100%" cellpadding="8" cellspacing="0" style="border: 1px solid #e0e0e0; border-radius: 6px; margin-bottom: 25px;">
                                <tr style="background-color: #f8f9fa;">
                                    <td style="font-weight: bold; color: #495057; width: 30%; border-bottom: 1px solid #e0e0e0;">User Name:</td>
                                    <td style="color: #333333; border-bottom: 1px solid #e0e0e0;">{{ $data['user']->name }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; color: #495057; width: 30%; border-bottom: 1px solid #e0e0e0;">User Email:</td>
                                    <td style="color: #333333; border-bottom: 1px solid #e0e0e0;">{{ $data['user']->email }}</td>
                                </tr>
                                <tr style="background-color: #f8f9fa;">
                                    <td style="font-weight: bold; color: #495057; width: 30%; border-bottom: 1px solid #e0e0e0;">Amount:</td>
                                    <td style="color: #333333; border-bottom: 1px solid #e0e0e0;">{{ number_format($data['deposit']['amount'], 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; color: #495057; width: 30%; border-bottom: 1px solid #e0e0e0;">Crypto Amount:</td>
                                    <td style="color: #333333; border-bottom: 1px solid #e0e0e0;">{{ $data['deposit']['crypto_amount'] }} {{ $data['deposit']['currency'] }}</td>
                                </tr>
                                <tr style="background-color: #f8f9fa;">
                                    <td style="font-weight: bold; color: #495057; width: 30%; border-bottom: 1px solid #e0e0e0;">Payment Method:</td>
                                    <td style="color: #333333; border-bottom: 1px solid #e0e0e0;">{{ $data['deposit']['payment_method'] }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; color: #495057; width: 30%; border-bottom: 1px solid #e0e0e0;">Transaction Hash:</td>
                                    <td style="color: #333333; word-break: break-all; font-family: monospace; font-size: 12px; border-bottom: 1px solid #e0e0e0;">{{ $data['deposit']['transaction_hash'] }}</td>
                                </tr>
                                <tr style="background-color: #f8f9fa;">
                                    <td style="font-weight: bold; color: #495057; width: 30%; border-bottom: 1px solid #e0e0e0;">Reference:</td>
                                    <td style="color: #333333; border-bottom: 1px solid #e0e0e0;">{{ $data['deposit']['reference'] }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; color: #495057; width: 30%;">Time:</td>
                                    <td style="color: #333333;">{{ $data['time'] }}</td>
                                </tr>
                            </table>

                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center" style="padding: 15px 0 0 0;">
                                        <a href="{{ url('/admin/deposits') }}" style="display: inline-block; padding: 12px 25px; background-color: #3498db; color: #ffffff; text-decoration: none; border-radius: 4px; font-weight: bold;">View Deposit</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8f9fa; padding: 20px; text-align: center; border-top: 1px solid #e0e0e0;">
                            <p style="margin: 0; color: #7f8c8d; font-size: 12px;">© 2022 {{ config('app.name') }}. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
