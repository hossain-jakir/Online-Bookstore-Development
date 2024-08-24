<!-- resources/views/mail/appointment.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Message Reply</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #333;
        }
        .content {
            margin-bottom: 20px;
        }
        .content p {
            margin: 10px 0;
        }
        .details ul {
            list-style-type: none;
            padding: 0;
        }
        .details ul li {
            background: #fff;
            margin: 5px 0;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .details ul li a {
            color: #1a0dab;
            text-decoration: none;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        .footer p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Message Reply</h1>
        </div>
        <div class="content">
            <p>Dear {{ $data->name }},</p>
            <div class="details">
                <p>{{ $data->response }}</p>

                <br>

                <p>Your message:</p>
                <p>{{ $data->message }}</p>
            </div>
        </div>
        <div class="footer">
            @php
                $shop = \App\Models\Shop::first();
            @endphp

            <p>Best regards,</p>
            <p>{{ auth()->user()->last_name }} </p>
            <p>{{ $shop->name }}</p>
            <p>Phone: {{ $shop->phone }}</p>
            <p>Email: {{ $shop->email }}</p>
            <p>Address: {{ $shop->address }}</p>
            <p>Website: <a href="https://bookstore.techbuyinfo.com" target="_blank">BookLand</a></p>
        </div>
    </div>
</body>
</html>
