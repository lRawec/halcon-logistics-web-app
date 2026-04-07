<!DOCTYPE html>
<html lang="en">

<head>
    <title>Orders List</title>
</head>

<body>
    <h1>Orders List</h1>
    <a href="{{ route('dashboard') }}">Back to Dashboard</a> |
    <a href="{{ route('orders.create') }}">Create New Order</a>
    <hr>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Invoice #</th>
                <th>Customer</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $o)
            <tr>
                <td>{{ $o->invoice_number }}</td>
                <td>{{ $o->customer->name }}</td>
                <td>{{ $o->order_date_time }}</td>
                <td><strong>{{ $o->status }}</strong></td>
                <td>
                    <a href="{{ route('orders.show', $o->order_id) }}">View / Edit</a> |

                    <form action="{{ route('orders.destroy', $o->order_id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Send to trash?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>