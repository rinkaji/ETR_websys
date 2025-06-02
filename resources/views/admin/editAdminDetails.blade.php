<h1>This is edit admin details page</h1>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Inter Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #0A28D8;
            font-family: 'Inter', sans-serif;
        }

        .card-custom {
            background-color: white;
            border-radius: 13px;
            padding: 2rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 4rem auto;
        }

        h1 {
            text-align: center;
            color: #0A28D8;
            margin-bottom: 1.5rem;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="card-custom">
            <h1>Update Admin Details</h1>
            {{-- <p>The created account will be used by an office or department to submit requests to the Supply Office.
            </p> --}}

            {{-- @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif --}}

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{route('updateAdminDetails')}}">
                @csrf

                <div class="mb-3">
                    <label for="office" class="form-label">Office</label>
                    <input type="text" name="office" class="form-control" value="{{$user->office}}" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{$user->email}}" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Enter New Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Update</button>
            </form>
        </div>
    </div>

</body>

</html>