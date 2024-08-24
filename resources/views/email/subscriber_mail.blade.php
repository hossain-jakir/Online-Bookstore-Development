<!DOCTYPE html>
<html>
<head>
    <title>New Book Alert</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background-color: #0073e6;
            color: #fff;
            padding: 20px;
            border-radius: 10px 10px 0 0;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-body {
            padding: 20px;
        }
        .email-body h2 {
            font-size: 22px;
            margin-top: 0;
        }
        .email-body p {
            margin: 10px 0;
        }
        .book-details {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
        }
        .book-details img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .cta-button {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 15px;
            background-color: #28a745;
            color: #fff;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-size: 18px;
        }
        .cta-button:hover {
            background-color: #218838;
        }
        .footer {
            text-align: center;
            color: #777;
            font-size: 12px;
            margin-top: 30px;
        }
        .unsubscribe-link {
            display: block;
            margin-top: 20px;
            color: #0073e6;
            text-decoration: none;
        }
        .unsubscribe-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>📚 New Book Release!</h1>
        </div>

        <!-- Body -->
        <div class="email-body">
            <h2>{{ $book->title }}</h2>
            <p>{{ $book->description }}</p>

            <!-- Book Details -->
            <div class="book-details">
                <p><strong>Title:</strong> {{ $book->title }}</p>
                <p><strong>Price:</strong> £{{ $book->sale_price }}</p>
                <p><strong>Publisher:</strong> {{ $book->publisher }}</p>
            </div>

            <!-- Call to Action -->
            <a href="{{ url('/book/' . base64_encode($book->id)) }}" class="cta-button">Get Your Copy Now!</a>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for subscribing to our newsletter!</p>
            <p>&copy; {{ date('Y') }} BookStore. All rights reserved.</p>
            <!-- Unsubscribe Link -->
            <a href="{{ route('unsubscribe', ['email' => urlencode($subscriber->email)]) }}" class="unsubscribe-link">Unsubscribe from this list</a>
        </div>
    </div>
</body>
</html>
