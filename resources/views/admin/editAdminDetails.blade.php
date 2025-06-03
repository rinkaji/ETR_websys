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
            color: #0A28D8;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="card-custom">
            <div class="d-flex align-items-center gap-3 mb-4">
              <a href="{{ route('dashboard') }}"
                style="
                    display: inline-flex;
                    align-items: center;
                    gap: 6px;
                    background-color: white;
                    color: black;
                    padding: 8px 16px;
                    border-radius: 6px;
                    font-weight: 600;
                    font-size: 14px;
                    font-family: Arial, Helvetica, sans-serif;
                    text-decoration: none;
                    border: 1px solid #ddd;
                    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
                    transition: background-color 0.3s ease;
                "
                    onmouseover="this.style.backgroundColor='#f0f0f0'"
                    onmouseout="this.style.backgroundColor='white'">
                    <img src="{{ asset('images/back_icon.png') }}" alt="Back Icon" style="width:16px; height:16px;">
                </a>
                <h1 class="mb-0" style="font-size: 2.5rem;">Update Admin Details</h1>
            </div>


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
