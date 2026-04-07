<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login - Halcon Logistics</title>
</head>

<body>
    <div style="margin: 50px auto; width: 300px; border: 1px solid #ccc; padding: 20px;">
        <h2>Internal Access</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div>
                <label>Username:</label><br>
                <input type="text" name="username" required autofocus>
            </div><br>
            <div>
                <label>Password:</label><br>
                <input type="password" name="password" required>
            </div><br>
            <button type="submit">Login</button>
        </form>

        @if ($errors->any())
        <p style="color:red">{{ $errors->first() }}</p>
        @endif
    </div>
</body>

</html>