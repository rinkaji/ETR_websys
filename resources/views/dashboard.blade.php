<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    @auth
        @if(auth()->user()->role === 'admin')
            @include('admin.dashboard')
        @else
            @include('office.dashboard')
        @endif
    @else
        <div class="container py-4">
            <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
        </div>
    @endauth
</body>
</html>