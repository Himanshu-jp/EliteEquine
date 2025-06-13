<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Congratulations! You Won the Bid</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
            color: #333333;
            line-height: 1.6;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 30px 20px;
            border: 1px solid #dddddd;
            border-radius: 5px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .header {
            background-color: #00A591;
            color: #ffffff;
            padding: 20px;
            border-radius: 5px 5px 0 0;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        h2 {
            color: #00A591;
        }

        .button {
            display: inline-block;
            background-color: #00A591;
            color: #ffffff !important;
            padding: 14px 30px;
            margin: 30px auto;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            font-size: 16px;
        }

        .footer {
            font-size: 12px;
            color: #777777;
            text-align: center;
            margin-top: 40px;
        }

        .content p {
            margin: 10px 0;
        }
        .commen_btn {
            border-radius: 5px;
            background: linear-gradient(191deg, #d6b868 7.84%, #ffecb6 92.19%);
            flex-shrink: 0;
            display: flex
        ;
            align-items: center;
            justify-content: center;
            color: #080808 !important;
            text-align: center !important;
            font-family: var(--poppins_font) !important;
            font-size: 16px !important;
            font-style: normal !important;
            font-weight: 500 !important;
            line-height: 120% !important;
            padding: 11px 23px;
            text-decoration: none;
        }

        @media only screen and (max-width: 600px) {
            .container {
                padding: 20px 15px;
            }

            .button {
                padding: 12px 20px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Congratulations, {{ $user->name }}!</h1>
    </div>

    <div class="content">
        <p>We're thrilled to let you know that you’ve <strong>won the bid</strong> for the following product:</p>

        <h2>{{ $product->name }}</h2>

        <p>To view the product details and complete any next steps, click the button below:</p>

        <p style="text-align: center;">
            <a href="{{ $link }}" class="button commen_btn" target="_blank" rel="noopener noreferrer">
                View Product Details
            </a>
        </p>

        <p>If you have any questions or need help, please don't hesitate to contact our support team.</p>

        <p>Thank you for participating in the auction!</p>

        <p>Best regards,<br>
            The {{ config('app.name') }} Team</p>
    </div>

    <div class="footer">
        <p>This is an automated message. Please do not reply.</p>
    </div>
</div>

</body>
</html>
