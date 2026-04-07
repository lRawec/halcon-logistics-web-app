<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Halcon Logistics - Public Tracking</title>
</head>

<body style="font-family: sans-serif; padding: 20px;">
    <h1>Track your Order</h1>
    <p>Enter your invoice number to see the status and delivery evidence.</p>

    <form method="GET" action="{{ route('home') }}">
        <input type="number" name="invoice" placeholder="Invoice # (e.g. 1002)" required
            style="padding: 10px; width: 200px;">
        <button type="submit" style="padding: 10px;">Search</button>
    </form>

    @if(isset($order))
    <hr>
    <h2>Status: {{ $order->status }}</h2>
    <p>Order Date: {{ $order->order_date_time }}</p>

    @if($order->photoEvidences->count() > 0)
    <h3>Evidence Photos:</h3>
    @foreach($order->photoEvidences as $photo)
    <div style="margin-bottom: 20px;">
        <p>Type: {{ $photo->type }}</p>
        <img src="/storage/{{ str_replace('storage/', '', $photo->file_path) }}" width="400">
    </div>
    @endforeach
    @else
    <p>No evidence photos available yet.</p>
    @endif
    @elseif(request('invoice'))
    <p style="color: red;">Invoice number not found. Please check and try again.</p>
    @endif

    <br><br>
    <hr>
    <a href="{{ route('login') }}">Employee Access (Login)</a>
</body>

</html>