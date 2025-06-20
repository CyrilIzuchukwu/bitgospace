<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New KYC Submission</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <!-- Header -->
    <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 20px;">
        <tr>
            <td style="text-align: center; padding: 20px 0; background-color: #f8f9fa; border-bottom: 1px solid #e9ecef;">
                <h1 style="margin: 0; color: #2d3748;">{{ config('app.name') }}</h1>
            </td>
        </tr>
    </table>

    <!-- Main Content -->
    <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 30px;">
        <tr>
            <td style="padding: 0 0 20px 0;">
                <h2 style="margin: 0 0 15px 0; color: #2d3748;">New KYC Submission Received</h2>
                <p style="margin: 0 0 15px 0;">Hello Admin,</p>
                <p style="margin: 0 0 20px 0;">A new KYC verification request has been submitted:</p>

                <!-- User Details Table -->
                <table width="100%" cellpadding="8" cellspacing="0" style="margin-bottom: 25px; border-collapse: collapse;">
                    <tr>
                        <td width="30%" style="border-bottom: 1px solid #e9ecef; padding: 8px 0;"><strong>User:</strong></td>
                        <td width="70%" style="border-bottom: 1px solid #e9ecef; padding: 8px 0;">{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid #e9ecef; padding: 8px 0;"><strong>Email:</strong></td>
                        <td style="border-bottom: 1px solid #e9ecef; padding: 8px 0;">{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid #e9ecef; padding: 8px 0;"><strong>Document Type:</strong></td>
                        <td style="border-bottom: 1px solid #e9ecef; padding: 8px 0;">{{ $kyc->document_type }}</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid #e9ecef; padding: 8px 0;"><strong>Country:</strong></td>
                        <td style="border-bottom: 1px solid #e9ecef; padding: 8px 0;">{{ $kyc->country }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0;"><strong>Submitted:</strong></td>
                        <td style="padding: 8px 0;">{{ $kyc->submitted_at->format('M j, Y g:i a') }}</td>
                    </tr>
                </table>

                <!-- Action Button -->
                <table width="100%" cellpadding="0" cellspacing="0" style="margin: 25px 0;">
                    <tr>
                        <td align="center">
                            <a href="{{ $url }}" style="display: inline-block; padding: 12px 24px; background-color: #4299e1; color: #ffffff; text-decoration: none; border-radius: 4px; font-weight: bold;">Review Submission</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Footer -->
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f8f9fa; border-top: 1px solid #e9ecef;">
        <tr>
            <td style="padding: 20px; text-align: center; color: #718096; font-size: 12px;">
                <p style="margin: 0;">© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                <p style="margin: 10px 0 0 0;">If you didn't request this email, please ignore it.</p>
            </td>
        </tr>
    </table>
</body>

</html>
