<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Inter Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #0A28D8;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem !important;
        }

        .card-custom {
            background-color: white;
            border-radius: 13px;
            padding: 2rem;
            /* box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1); */
            max-width: 600px;
            margin: 0.3rem auto;
        }

        h1 {
            text-align: center;
            color: #0A28D8;
            margin-bottom: 2rem;
            font-weight: 900 !important;
        }

        .card-custom p {
            margin-bottom: 4rem;
        }

        .card-custom h1 {
            margin-bottom: 1rem;
        }

        .icon-register {
            height: 50px !important;
            width: 50px !important;
            display: block;
            margin: 1rem auto;
        }

        .form-label {
            font-weight: bold;
        }
    </style>
</head>

<body>

    {{-- @extends('layouts.app')

    @section('title', 'Admin Dashboard')

    @section('content') --}}


    <div class="card-custom">
        <img class="icon-register" src="{{ asset('images/add-multiple-people.svg') }}">
        <h1>Register a user</h1>
        <p>The created account will be used by an office or department to submit requests to the Supply Office.</p>

        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select name="role" class="form-select" required>
                    <option value="admin">Admin</option>
                    <option value="office">Office</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="office" class="form-label">Office</label>
                <input type="text" name="office" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
    </div>


    {{-- @endsection --}}

</body>

</html>