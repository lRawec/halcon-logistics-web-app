<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit User</title>
</head>

<body>
    <h1>Edit User: {{ $user->username }}</h1>
    <a href="{{ route('users.index') }}">Back to Users List</a>
    <hr>

    <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf
        @method('PUT')

        <div>
            <label>Username:</label><br>
            <input type="text" name="username" value="{{ $user->username }}" required>
        </div><br>

        <div>
            <label>Password (Leave blank to keep current):</label><br>
            <input type="password" name="password">
        </div><br>

        <div>
            <label>Department (Role):</label><br>
            <select name="role" required>
                <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>Admin</option>
                <option value="Sales" {{ $user->role == 'Sales' ? 'selected' : '' }}>Sales</option>
                <option value="Purchasing" {{ $user->role == 'Purchasing' ? 'selected' : '' }}>Purchasing</option>
                <option value="Warehouse" {{ $user->role == 'Warehouse' ? 'selected' : '' }}>Warehouse</option>
                <option value="Route" {{ $user->role == 'Route' ? 'selected' : '' }}>Route</option>
            </select>
        </div><br>

        <div>
            <label>
                <input type="checkbox" name="is_active" value="1" {{ $user->is_active ? 'checked' : '' }}>
                Active User
            </label>
        </div><br>

        <button type="submit">Update User</button>
    </form>

    @if ($errors->any())
    <p style="color:red">{{ $errors->first() }}</p>
    @endif
</body>

</html>