<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Invoice</title>
</head>
<body>

    <h1>Edit Invoice #{{ $invoice->id }}</h1>

    <div>
        <p>Reservation: <strong>#{{ $invoice->reservation->id }}</strong></p>
        <p>Client: <strong>{{ $invoice->reservation->user->name }}</strong></p>
        <p>Room: <strong>{{ $invoice->reservation->room->room_number }}</strong></p>
        <p>Total Amount: <strong>{{ $invoice->total_amount }} $</strong></p>
    </div>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li style="color:red">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('invoices.update', $invoice->id) }}">
        @csrf
        @method('PUT')

        <div>
            <label for="payment_method">Payment Method</label>
            <select name="payment_method" id="payment_method">
                <option value="cash"
                    @selected(old('payment_method', $invoice->payment_method) === 'cash')>
                    Cash
                </option>
                <option value="credit_card"
                    @selected(old('payment_method', $invoice->payment_method) === 'credit_card')>
                    Credit Card
                </option>
            </select>
        </div>

        <div>
            <label for="payment_status">Payment Status</label>
            <select name="payment_status" id="payment_status">
                <option value="unpaid"
                    @selected(old('payment_status', $invoice->payment_status) === 'unpaid')>
                    Unpaid
                </option>
                <option value="paid"
                    @selected(old('payment_status', $invoice->payment_status) === 'paid')>
                    Paid
                </option>
            </select>
        </div>

        <button type="submit">Update Invoice</button>
        <a href="{{ route('invoices.show', $invoice->id) }}">Cancel</a>
    </form>

</body>
</html>
