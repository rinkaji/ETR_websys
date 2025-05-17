<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li style="color: red">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div>
            <label for="role">Role: </label>
            <select name="role" required>
                <option value="admin">Admin</option>
                <option value="office">Office</option>
            </select>
        </div>
        <div>
            <label for="email">Email: </label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div>
            <label for="password">Password: </label>
            <input type="password" name="password" required>
        </div>
        <button type="submit">Login</button>
    </form>

</body>
</html>