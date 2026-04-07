<!DOCTYPE html>
<html lang="en">

<head>
    <title>Order Details</title>
</head>

<body>
    <nav>
        <a href="{{ route('dashboard') }}">Dashboard</a> |
        <a href="{{ route('orders.index') }}">Back to Orders List</a>
    </nav>
    <hr>

    <h1>Order #{{ $order->invoice_number }}</h1>
    <p>Customer: {{ $order->customer->name }}</p>
    <p>Status: <strong>{{ $order->status }}</strong></p>

    <form method="POST" action="{{ route('orders.update', $order->order_id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <select name="status">
            <option value="Ordered">Ordered</option>
            <option value="InProcess">In Process</option>
            <option value="InRoute">In Route</option>
            <option value="Delivered">Delivered</option>
        </select>
        <input type="file" name="photo">
        <button type="submit">Update</button>
    </form>
</body>

</html>