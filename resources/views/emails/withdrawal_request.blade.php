<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Withdrawal Request</title>
</head>

<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4; padding: 10px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: #061f6d; padding: 20px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 20px 0; font-size: 24px; font-weight: bold;">
                                New Withdrawal Request
                            </h1>
                        </td>
                    </tr>

                    <!-- Alert Banner -->
                    <tr>
                        <td style="background-color: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 0;">
                            <p style="margin: 0; color: #856404; font-size: 14px; font-weight: 600;">
                                ⚠️ A new withdrawal request requires your immediate attention and approval.
                            </p>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 20px;">
                            <h2 style="color: #333333; margin: 0 0 20px 0; font-size: 20px; border-bottom: 2px solid #667eea; padding-bottom: 10px;">
                                User Information
                            </h2>

                            <table width="100%" cellpadding="8" cellspacing="0" style="border: 1px solid #e0e0e0; border-radius: 6px; margin-bottom: 25px; width: 100%;">
                                <tr style="background-color: #f8f9fa;">
                                    <td style="font-weight: bold; color: #495057; width: 30%; border-bottom: 1px solid #e0e0e0;">
                                        User Name:
                                    </td>
                                    <td style="color: #333333; border-bottom: 1px solid #e0e0e0;">
                                        {{ $data['user']->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; color: #495057; width: 30%; border-bottom: 1px solid #e0e0e0;">
                                        Email:
                                    </td>
                                    <td style="color: #333333; border-bottom: 1px solid #e0e0e0;">
                                        {{ $data['user']->email }}
                                    </td>
                                </tr>
                            </table>

                            <h2 style="color: #333333; margin: 0 0 20px 0; font-size: 20px; border-bottom: 2px solid #667eea; padding-bottom: 10px;">
                                Withdrawal Details
                            </h2>

                            <table width="100%" cellpadding="8" cellspacing="0" style="border: 1px solid #e0e0e0; border-radius: 6px; margin-bottom: 25px; width: 100%;">
                                <tr style="background-color: #f8f9fa;">
                                    <td style="font-weight: bold; color: #495057; width: 30%; border-bottom: 1px solid #e0e0e0;">
                                        Amount:
                                    </td>
                                    <td style="color: #28a745; font-weight: bold; font-size: 18px; border-bottom: 1px solid #e0e0e0;">
                                        ${{ number_format($data['withdrawal']['amount'], 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; color: #495057; width: 30%; border-bottom: 1px solid #e0e0e0;">
                                        Payment Method:
                                    </td>
                                    <td style="color: #333333; text-transform: uppercase; font-weight: 600; border-bottom: 1px solid #e0e0e0;">
                                        {{ $data['withdrawal']['payment_method'] }}
                                    </td>
                                </tr>
                                <tr style="background-color: #f8f9fa;">
                                    <td style="font-weight: bold; color: #495057; width: 30%; border-bottom: 1px solid #e0e0e0;">
                                        Wallet Address:
                                    </td>
                                    <td style="color: #333333; word-break: break-all; font-family: monospace; font-size: 12px; border-bottom: 1px solid #e0e0e0;">
                                        {{ $data['withdrawal']['wallet_address'] }}
                                    </td>
                                </tr>
                            </table>

                            <!-- Action Button Section -->
                            <div style="text-align: center; margin-top: 30px;">
                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <tr>
                                        <td align="center">
                                            <a href="{{ url('/admin/withdrawals') }}" style="display: inline-block; padding: 12px 25px; background-color: #061f6d; color: #ffffff; text-decoration: none; border-radius: 4px; font-weight: bold;">View Withdrawal</a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
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
