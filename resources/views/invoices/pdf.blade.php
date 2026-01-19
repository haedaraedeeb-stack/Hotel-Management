<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <h2>Invoice #{{ $invoice->id }}</h2>
    <p>Room: {{ $invoice->reservation->room->room_number }}</p>
    <p>Customer: {{ $invoice->reservation->user->name }}</p>
    <p>Total: ${{ number_format($invoice->total_amount, 2) }}</p>
    <p>Payment Method:{{ $invoice->payment_method }}</p>
    <p>Payment Status: {{ $invoice->payment_status }}</p>
    <p>Date:{{ $invoice->created_at->format('Y-m-d') }}</p>
</body>

</html>
