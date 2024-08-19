<!DOCTYPE html>
<html>
<head>
    <title>Redirecting to PayPal</title>
</head>
<body>
    <form id="paypalForm" action="{{ route('checkout.paypal.due') }}" method="POST">
        @csrf
        <input type="hidden" name="order_id" value="{{ $order_id }}">
    </form>
    <script>
        document.getElementById('paypalForm').submit();
    </script>
</body>
</html>
