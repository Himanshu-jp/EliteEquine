<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Your Product Has a Winning Bidder</title>
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
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }
        .details {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            margin-top: 15px;
        }
        .details p {
            margin: 5px 0;
        }
        .footer {
            font-size: 12px;
            color: #777;
            text-align: center;
            margin-top: 30px;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Your Product Has a Winning Bidder!</h1>
    </div>

    <p>Dear {{ $owner->name }},</p>

    <p>We are pleased to inform you that your product has received a winning bid.</p>

    <h2>{{ $product->name }}</h2>

    <div class="details">
        <h3>Winner Details:</h3>
        <p><strong>Name:</strong> {{ $winner->name }}</p>
        <p><strong>Email:</strong> <a href="mailto:{{ $winner->email }}">{{ $winner->email }}</a></p>
        @if(!empty($winner->phone_no))
        <p><strong>Phone:</strong> {{ $winner->phone_no }}</p>
        @endif
        {{-- Add more winner details if needed --}}
    </div>

    <p>Please contact the winner to proceed with the transaction.</p>

    <p>Thank you for using {{ config('app.name') }}!</p>

    <p>Best regards,<br>
    The {{ config('app.name') }} Team</p>

    <div class="footer">
        <p>This is an automated message, please do not reply.</p>
    </div>
</div>
</body>
</html>
