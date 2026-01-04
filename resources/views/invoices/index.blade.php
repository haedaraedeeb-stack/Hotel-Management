<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoices</title>
</head>

<body>

    <h1>My Invoices</h1>
    @forelse ($invoices as $invoice)
        @if ($loop->first)
            <table>
                <tr>
                    <th>#</th>
                    <th>Reservation</th>
                    <th>Total Amount</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                    <th>Show Invoice</th>
                </tr>
        @endif

        <tr>
            <td>{{ $invoice->id }}</td>
            <td>#{{ $invoice->reservation->id }}</td>
            <td>{{ $invoice->total_amount }} $</td>
            <td>
                {{ $invoice->payment_method === 'cash' ? 'Cash' : 'Credit Card' }}
            </td>
            <td>
                {{ $invoice->payment_status === 'paid' ? 'Paid' : 'Unpaid' }}
            </td>
            <td>
                <a href="{{ route('invoices.show', $invoice->id) }}">Show Invoice</a>
            </td>
        </tr>

        @if ($loop->last)
            </table>
        @endif
    @empty
        <p>You have no invoices to show yet.</p>
    @endforelse
</body>

</html>
