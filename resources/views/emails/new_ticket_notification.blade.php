<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Support Ticket</title>
</head>

<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa; line-height: 1.5;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f8f9fa; padding: 20px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 30px 20px; text-align: center; background-color: #667eea;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 24px; font-weight: 600;">
                                New Support Ticket
                            </h1>
                            <p style="margin: 8px 0 0 0; color: rgba(255,255,255,0.9); font-size: 15px;">
                                Ticket #{{ $data['ticketReference'] }}
                            </p>
                        </td>
                    </tr>

                    <!-- Main Content -->
                    <tr>
                        <td style="padding: 30px;">
                            <p style="margin: 0 0 20px 0; font-size: 16px; color: #5a6c7d; text-align: center;">
                                A new support ticket requires your attention
                            </p>

                            <!-- Ticket Details -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 0 0 25px 0; border-collapse: collapse;">
                                <tr>
                                    <td style="padding: 12px; border-bottom: 1px solid #e9ecef; font-weight: 600; color: #34495e;">Reference ID</td>
                                    <td style="padding: 12px; border-bottom: 1px solid #e9ecef; color: #2c3e50;">{{ $data['ticketReference'] }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px; border-bottom: 1px solid #e9ecef; font-weight: 600; color: #34495e;">Subject</td>
                                    <td style="padding: 12px; border-bottom: 1px solid #e9ecef; color: #2c3e50;">{{ $data['subject'] }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px; border-bottom: 1px solid #e9ecef; font-weight: 600; color: #34495e;">Customer</td>
                                    <td style="padding: 12px; border-bottom: 1px solid #e9ecef; color: #2c3e50;">{{ $data['userName'] }} ({{ $data['userEmail'] }})</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px; font-weight: 600; color: #34495e;">Created</td>
                                    <td style="padding: 12px; color: #7f8c8d;">{{ $data['createdAt'] }}</td>
                                </tr>
                            </table>

                            <!-- Message Content -->
                            <div style="margin: 25px 0;">
                                <h3 style="margin: 0 0 12px 0; color: #2c3e50; font-size: 18px; font-weight: 600; text-align: center;">
                                    Message
                                </h3>
                                <div style="background-color: #f8f9fa; border-radius: 6px; padding: 15px; font-size: 15px; color: #495057;">
                                    {{ $data['message'] }}
                                </div>
                            </div>

                            <!-- Action Button -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 25px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ route('admin.dashboard') }}" style="display: inline-block; padding: 10px 25px; background-color: #667eea; color: #ffffff; text-decoration: none; border-radius: 4px; font-weight: 500;">
                                            View Ticket in Dashboard
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Footer Note -->
                            <p style="margin: 20px 0 0 0; color: #6c757d; font-size: 13px; text-align: center;">
                                This is an automated notification. Please do not reply to this email.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
