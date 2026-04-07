<!DOCTYPE html>
<html lang="en">

<head>
    <title>Manage Users</title>
</head>

<body>
    <h1>Users List</h1>
    <a href="{{ route('dashboard') }}">Back to Dashboard</a> |
    <a href="{{ route('users.create') }}">Create New User</a>
    <hr>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Department (Role)</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $u)
            <tr>
                <td>{{ $u->id }}</td>
                <td>{{ $u->username }}</td>
                <td>{{ $u->role }}</td>
                <td>
                    @if($u->is_active)
                    <span style="color: green;">Active</span>
                    @else
                    <span style="color: red;">Inactive</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('users.edit', $u) }}">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>