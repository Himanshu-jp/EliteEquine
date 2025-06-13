<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Congratulations! You Won the Bid</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            background: #f9f9f9;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }
        .contact-info {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            margin-top: 15px;
        }
        .contact-info p {
            margin: 5px 0;
        }
        .footer {
            font-size: 12px;
            color: #777;
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Congratulations, {{ $user->name }}!</h1>
    </div>

    <p>You have won the bid for the product:</p>

    <h2>{{ $product->name }}</h2>

    <p>This transaction is a buyer-to-seller arrangement. Please contact the product owner directly to proceed with the purchase.</p>

    <div class="contact-info">
        <h3>Product Owner Contact Details:</h3>
        <p><strong>Name:</strong> {{ $owner->name }}</p>
        <p><strong>Email:</strong> <a href="mailto:{{ $owner->email }}">{{ $owner->email }}</a></p>
        @if(!empty($owner->phone_no))
        <p><strong>Phone:</strong> {{ $owner->phone_no }}</p>
        @endif
        {{-- Add more owner details if needed --}}
    </div>

    <p>If you have any questions or need assistance, please don't hesitate to contact our support team.</p>

    <p>Thank you for participating in the auction!</p>

    <p>Best regards,<br>
    The {{ config('app.name') }} Team</p>

    <div class="footer">
        <p>This is an automated message, please do not reply.</p>
    </div>
</div>
</body>
</html>
