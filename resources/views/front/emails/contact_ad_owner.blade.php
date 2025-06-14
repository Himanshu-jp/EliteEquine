<!doctype html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Contact Ad Owner</title>
    <meta name="description" content="Contact Ad Owner Email">
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,500,700|Open+Sans:400,600" rel="stylesheet">
    <style>
        a:hover { text-decoration: underline !important; }
    </style>
</head>
<body style="margin: 0; background-color: #f5f7fb; font-family: 'Open Sans', sans-serif;">
    <table width="100%" bgcolor="#f5f7fb" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td>
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 670px; margin: 0 auto;">
                    <tr><td style="height: 40px;">&nbsp;</td></tr>
                    
                    <!-- Logo -->
                    <tr>
                        <td style="text-align: center;">
                            <a href="#" target="_blank">
                                <img width="80" src="{{ asset('front/home/assets/images/logo/logo.svg')}}" alt="logo">
                            </a>
                        </td>
                    </tr>

                    <tr><td style="height: 20px;">&nbsp;</td></tr>

                    <!-- Email Body -->
                    <tr>
                        <td>
                            <table width="95%" align="center" cellpadding="0" cellspacing="0" style="background: linear-gradient(145deg, #ffffff, #f1f1f1); border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); padding: 30px;">
                                <tr>
                                    <td style="text-align: center;">
                                        <h1 style="color: #4b4f56; font-size: 26px; font-weight: 700; margin: 0 0 10px;">You've Got a New Contact Request 📨</h1>
                                        <p style="font-size: 16px; color: #555;">Someone is interested in your horse listing. Below are the details:</p>

                                        <hr style="border: 0; border-top: 1px solid #ddd; margin: 25px 0;">

                                        <table width="100%" style="text-align: left; color: #333; font-size: 16px;">
                                            <tr>
                                                <td style="padding: 8px 0;"><strong style="color:#4caf50;">Name:</strong> {{$mailData['name']}}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0;"><strong style="color:#4caf50;">Email:</strong> {{$mailData['email']}}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0;"><strong style="color:#4caf50;">Message:</strong><br>
                                                    <div style="background: #f0f8ff; padding: 12px; border-radius: 6px; margin-top: 5px;">
                                                        {{$mailData['message']}}
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 20px 0;">
                                                    <a href="{{ $mailData['link'] }}" target="_blank" style="background: linear-gradient(90deg, #20e277, #28c76f); padding: 12px 24px; border-radius: 30px; font-weight: 600; color: white; text-transform: uppercase; text-decoration: none;">Go To Product</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr><td style="height: 30px;">&nbsp;</td></tr>
                    <tr>
                        <td style="text-align: center;">
                            <p style="color: #9a9a9a; font-size: 14px;">&copy; <strong style="color: #222;">EliteQueen</strong> – All Rights Reserved</p>
                        </td>
                    </tr>
                    <tr><td style="height: 40px;">&nbsp;</td></tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
