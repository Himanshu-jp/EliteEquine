<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            background-color: #f2f3f8;
            font-family: 'Open Sans', sans-serif;
        }

        .email-container {
            max-width: 670px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 6px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .email-header {
            background-color: #00A591;
            padding: 20px;
            text-align: center;
        }

        .email-header img {
            width: 80px;
        }

        .email-body {
            padding: 40px 35px;
            text-align: left;
        }

        .email-body h2 {
            color: #1e1e2d;
            margin-bottom: 10px;
        }

        .email-body p {
            color: #455056;
            font-size: 15px;
            line-height: 24px;
            margin: 10px 0;
        }

        .product-info {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-top: 15px;
        }

        .email-footer {
            text-align: center;
            padding: 20px;
            font-size: 13px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <a href="{{ url('/') }}">
                <img src="{{ asset('front/home/assets/images/logo/logo.svg') }}" alt="EliteQueen Logo">
            </a>
        </div>

        <div class="email-body">
            <h2>Thank you for your purchase, {{ $order->user->name }}!</h2>
            <p>Your order for <strong>{{ $product->title }}</strong> has been placed successfully.</p>
            <p>We will notify the seller to begin processing your order.</p>
            <p><strong>Order ID:</strong> {{ $order->id }}</p>

            <div class="product-info">
                <p><strong>Product Title:</strong> {{ $product->title }}</p>
                <p><strong>Category:</strong> {{ $product->category->name ?? 'N/A' }}</p>
                <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                <p><strong>Location:</strong> {{ $product->productDetail->city ?? 'N/A' }}, {{ $product->productDetail->state ?? 'N/A' }}</p>
                <p><strong>Description:</strong><br>
                    {{ \Illuminate\Support\Str::limit($product->description, 300) }}
                </p>
            </div>
        </div>

        <div class="email-footer">
            &copy; {{ date('Y') }} <strong>EliteQueen</strong>. All rights reserved.
        </div>
    </div>
</body>

</html>
