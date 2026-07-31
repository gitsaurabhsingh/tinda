<!DOCTYPE html>
<html>
<head>
    <title>New Contact Enquiry</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>New Contact Enquiry Received</h2>
    <p>You have received a new message from the contact form on your website.</p>
    
    <div style="background: #f4f4f4; padding: 15px; border-radius: 5px;">
        <p><strong>Name:</strong> {{ $contactData['name'] }}</p>
        <p><strong>Email:</strong> {{ $contactData['email'] }}</p>
        <p><strong>Subject:</strong> {{ $contactData['subject'] ?? 'No Subject' }}</p>
        <p><strong>Message:</strong></p>
        <p style="white-space: pre-wrap;">{{ $contactData['message'] }}</p>
    </div>
    
    <p>Regards,<br>{{ config('app.name') }}</p>
</body>
</html>
