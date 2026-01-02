<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deleted Invoices</title>
</head>
<body>

    <h1>Deleted Invoices</h1>

    <div style="margin-bottom:20px">
        <a href="{{ route('invoices.index') }}">Back to Invoices</a>
    </div>

    @forelse ($invoices as $invoice)
        @if ($loop->first)
            <table>
                <tr>
                    <th>#</th>
                    <th>Reservation</th>
                    <th>Total Amount</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                    <th>Deleted At</th>
                    <th>Actions</th>
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
                {{ optional($invoice->deleted_at)->format('Y-m-d H:i:s') ?? 'N/A' }}
            </td>
            <td>
                <form action="{{ route('invoices.restore', $invoice->id) }}"
                      method="POST"
                      style="display:inline-block">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                        onclick="return confirm('Are you sure you want to restore this invoice?')">
                        Restore
                    </button>
                </form>

                <form action="{{ route('invoices.forceDelete', $invoice->id) }}"
                      method="POST"
                      style="display:inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        style="color:red"
                        onclick="return confirm('Are you sure you want to permanently delete this invoice? This action cannot be undone.')">
                        Permanently Delete
                    </button>
                </form>
            </td>
        </tr>

        @if ($loop->last)
            </table>
            
        @endif
    @empty
        <p>You have no deleted invoices.</p>
    @endforelse

</body>
</html>
