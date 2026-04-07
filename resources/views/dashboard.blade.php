<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard - Halcon</title>
</head>

<body>
    <h1>Administration Dashboard</h1>
    <p>Welcome, <strong>{{ Auth::user()->username }}</strong></p>
    <p>Department: {{ Auth::user()->role }}</p>

    <hr>
    <nav>
        <ul>
            @if(Auth::user()->role == 'Admin')
            <li><a href="{{ route('users.index') }}">Manage Users</a></li>
            @endif
            <li><a href="{{ route('orders.index') }}">Orders List</a></li>
            <li><a href="{{ route('orders.archived') }}">Archived Orders (Trash)</a></li>
        </ul>
    </nav>

    <hr>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>

</html>