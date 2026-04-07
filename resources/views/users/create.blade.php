<!DOCTYPE html>
<html lang="en">

<head>
    <title>Create User</title>
</head>

<body>
    <h1>Create New User</h1>
    <a href="{{ route('users.index') }}">Back to Users List</a>
    <hr>

    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        <div>
            <label>Username:</label><br>
            <input type="text" name="username" required>
        </div><br>

        <div>
            <label>Password:</label><br>
            <input type="password" name="password" required>
        </div><br>

        <div>
            <label>Department (Role):</label><br>
            <select name="role" required>
                <option value="Sales">Sales</option>
                <option value="Purchasing">Purchasing</option>
                <option value="Warehouse">Warehouse</option>
                <option value="Route">Route</option>
            </select>
        </div><br>

        <button type="submit">Save User</button>
    </form>

    @if ($errors->any())
    <p style="color:red">{{ $errors->first() }}</p>
    @endif
</body>

</html>