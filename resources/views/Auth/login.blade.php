<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
    <!-- Import Inter font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet" />
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #1D70B8;
            font-family: 'Inter', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .card {
            background-color: white;
            border-radius: 13px;
            padding: 2rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center; /* center content */
        }

        .card img.logo {
            max-width: 150px;
            margin-bottom: 1.5rem;
        }

        .card form > div {
            margin-bottom: 1rem;
            text-align: left; /* keep label/input left aligned */
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
        }

        input,
        select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 0.75rem;
            background-color: #1D70B8;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
        }

        .error-list {
            color: red;
            margin-bottom: 1rem;
            text-align: left;
        }

        .success-message {
            color: green;
            margin-bottom: 1rem;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="card">
        <!-- Logo at the top -->
        <img src="{{ asset('images/soms-blue.png') }}" alt="SOMS Logo" class="logo" />

        @if(session('success'))
        <div class="success-message">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
        <div class="error-list">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            {{-- <div>
                <label for="role">Role</label>
                <select name="role" required>
                    <option value="admin">Admin</option>
                    <option value="office">Office</option>
                </select>
            </div> --}}
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required />
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" name="password" required />
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>
