<!DOCTYPE html>
<html>
<head>
    <title>New Contact Form Submission</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <!-- Email Container -->
    <div style="background-color: #f9f9f9; border: 1px solid #e1e1e1; border-radius: 4px; padding: 25px;">
        <!-- Header -->
        <div style="text-align: center; margin-bottom: 25px; border-bottom: 1px solid #e1e1e1; padding-bottom: 15px;">
            <h1 style="color: #2c3e50; margin: 0; font-size: 24px;">New Contact Form Submission</h1>
            <p style="color: #7f8c8d; margin: 5px 0 0; font-size: 14px;">{{ now()->format('F j, Y, g:i a') }}</p>
        </div>

        <!-- Contact Details Table -->
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <tr>
                <td style="padding: 8px 0; border-bottom: 1px solid #e1e1e1; width: 30%; font-weight: bold;">Name:</td>
                <td style="padding: 8px 0; border-bottom: 1px solid #e1e1e1;">{{ $data['name'] }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; border-bottom: 1px solid #e1e1e1; width: 30%; font-weight: bold;">Email:</td>
                <td style="padding: 8px 0; border-bottom: 1px solid #e1e1e1;">
                    <a href="mailto:{{ $data['email'] }}" style="color: #3498db; text-decoration: none;">{{ $data['email'] }}</a>
                </td>
            </tr>
            <tr>
                <td style="padding: 8px 0; border-bottom: 1px solid #e1e1e1; width: 30%; font-weight: bold;">Subject:</td>
                <td style="padding: 8px 0; border-bottom: 1px solid #e1e1e1;">{{ $data['subject'] }}</td>
            </tr>
        </table>

        <!-- Message Section -->
        <div style="background-color: #ffffff; border: 1px solid #e1e1e1; border-radius: 4px; padding: 15px; margin-bottom: 20px;">
            <h3 style="color: #2c3e50; margin-top: 0; margin-bottom: 10px;">Message:</h3>
            <p style="margin: 0; white-space: pre-line;">{{ $data['message'] }}</p>
        </div>

        <!-- Footer -->
        <div style="text-align: center; font-size: 12px; color: #7f8c8d; border-top: 1px solid #e1e1e1; padding-top: 15px;">
            <p style="margin: 0;">This message was sent from the contact form on your website.</p>
            <p style="margin: 5px 0 0;">
                <a href="{{ url('/') }}" style="color: #3498db; text-decoration: none;">{{ config('app.name') }}</a>
                &bull;
                {{ now()->format('Y') }}
            </p>
        </div>
    </div>
</body>
</html>
