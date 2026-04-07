<!DOCTYPE html>
<html lang="en">

<head>
    <title>Create Order</title>
</head>

<body>
    <h1>Create New Order</h1>
    <a href="{{ route('orders.index') }}">Back to Orders</a>
    <hr>

    <form method="POST" action="{{ route('orders.store') }}">
        @csrf
        <div>
            <label>Invoice Number:</label><br>
            <input type="number" name="invoice_number" required>
        </div><br>

        <div>
            <label>Customer:</label><br>
            <select name="customer_number" required>
                @foreach($customers as $c)
                <option value="{{ $c->customer_number }}">{{ $c->name }} ({{ $c->fiscal_data }})</option>
                @endforeach
            </select>
        </div><br>

        <div>
            <label>Notes (Optional):</label><br>
            <textarea name="notes" rows="3" cols="30"></textarea>
        </div><br>

        <button type="submit">Register Order</button>
    </form>

    @if ($errors->any())
    <p style="color:red">{{ $errors->first() }}</p>
    @endif
</body>

</html>