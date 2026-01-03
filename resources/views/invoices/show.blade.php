<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Invoice</title>
</head>
<body>

    <h1>Invoice #{{ $invoice->id }}</h1>

    <div>
        <div>
            <h2>Hotel Name</h2>
            <p>Invoice NO. #{{ $invoice->id }}</p>
            <p>Date: {{ $invoice->created_at->format('Y-m-d') }}</p>
        </div>

        <div style="margin-bottom:20px">
            <h4>Client: {{ $invoice->reservation->user->name }}</h4>
            <p>Email: {{ $invoice->reservation->user->email }}</p>
        </div>

        <div style="margin-bottom:20px">
            <p>Reservation NO.: <strong>#{{ $invoice->reservation->id }}</strong></p>
            <p>Room NO.: <strong>{{ $invoice->reservation->room->room_number }}</strong></p>
            <p>From: <strong>{{ $invoice->reservation->check_in }}</strong></p>
            <p>To: <strong>{{ $invoice->reservation->check_out }}</strong></p>
        </div>

        <div style="border-top:1px solid #000; padding-top:10px">
            <p>Total Amount: <strong>{{ $invoice->total_amount }} $</strong></p>

            <p>
                Payment Method:
                <strong>
                    {{ $invoice->payment_method === 'cash' ? 'Cash' : 'Credit Card' }}
                </strong>
            </p>

            <p>
                <strong>Payment Status:</strong>
                <span>
                    {{ $invoice->payment_status === 'paid' ? 'Paid' : 'Not paid' }}
                </span>
            </p>
        </div>
    </div>

    <a href="{{ route('invoices.index') }}">Back</a>
    <button onclick="window.print()">Print</button>

</body>
</html>
