<!DOCTYPE html>
<html>
<head>
    <title>New Contact Form Submission</title>
</head>
<body>
    <h2>New Contact Form Submission</h2>
    
    <p><strong>Name:</strong> {{ $name }}</p>
    <p><strong>Email:</strong> {{ $email }}</p>
    @if($phone)
        <p><strong>Phone:</strong> {{ $phone }}</p>
    @endif
    <p><strong>Subject:</strong> {{ $subject ?? 'General Enquiry' }}</p>
    <p><strong>Message:</strong></p>
    <p>{{ $message }}</p>
</body>
</html>