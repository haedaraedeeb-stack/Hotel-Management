<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Invoice</title>
</head>
<body>

    <h1>Create an Invoice</h1>

    <div>
        <p>Reservation: <strong>{{ $reservation->id }}</strong></p>
        <p>Client: <strong>{{ $reservation->user->name }}</strong></p>
        <p>Room: <strong>{{ $reservation->room->room_number }}</strong></p>
    </div>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('invoices.store', $reservation->id) }}">
        @csrf

        <div>
            <label for="payment_method">Payment Method</label>
            <select name="payment_method" id="payment_method">
                <option value="cash" @selected(old('payment_method') === 'cash')>Cash</option>
                <option value="credit_card" @selected(old('payment_method') === 'credit_card')>
                    Credit Card
                </option>
            </select>
        </div>

        <div>
            <label for="payment_status">Payment Status</label>
            <select name="payment_status" id="payment_status">
                <option value="unpaid" @selected(old('payment_status', 'unpaid') === 'unpaid')>
                    Unpaid
                </option>
                <option value="paid" @selected(old('payment_status') === 'paid')>
                    Paid
                </option>
            </select>
        </div>

        <button type="submit">Create</button>
        <a href="{{ url()->previous() }}">Cancel</a>
    </form>

</body>
</html>
