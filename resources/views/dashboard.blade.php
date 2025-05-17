<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    @auth
        @if(auth()->user()->role === 'admin')
            @include('admin.dashboard', ['supplies' => \App\Models\Supply::all()])
        @else
            @include('office.dashboard')
        @endif
    @else
        <a href="{{ route('login') }}">Login</a>
    @endauth
</body>
</html>