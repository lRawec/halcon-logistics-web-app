<!DOCTYPE html>
<html lang="en">

<head>
    <title>Archived Orders</title>
</head>

<body>
    <h1>Archived Orders (Trash)</h1>
    <a href="{{ route('dashboard') }}">Back to Dashboard</a> |
    <a href="{{ route('orders.index') }}">View Active Orders</a>
    <hr>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Invoice #</th>
                <th>Customer</th>
                <th>Status</th>
                <th>Deleted At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $o)
            <tr>
                <td>{{ $o->invoice_number }}</td>
                <td>{{ $o->customer->name }}</td>
                <td>{{ $o->status }}</td>
                <td>{{ $o->deleted_at }}</td>
                <td>
                    <form action="{{ route('orders.restore', $o->order_id) }}" method="POST">
                        @csrf
                        <button type="submit">Restore Order</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>