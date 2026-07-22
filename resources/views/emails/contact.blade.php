<!DOCTYPE html>
<html>
<head>
    <title>New Contact Inquiry</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>New Contact Inquiry Received</h2>
    
    <p><strong>Name:</strong> {{ $contact->name }}</p>
    <p><strong>Email:</strong> {{ $contact->email }}</p>
    <p><strong>Subject:</strong> {{ $contact->subject }}</p>
    
    <div style="margin-top: 20px; padding: 15px; border: 1px solid #ccc; background-color: #f9f9f9;">
        <p><strong>Message:</strong></p>
        <p>{{ nl2br(e($contact->message)) }}</p>
    </div>
    
    <p style="margin-top: 30px; font-size: 0.9em; color: #777;">
        This email was generated from the Sri Crackers website contact form.
    </p>
</body>
</html>
