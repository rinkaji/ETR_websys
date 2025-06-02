<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            font-family: 'Inter', sans-serif;
        }

        .layout-wrapper {
            display: flex;
            flex-direction: column;
            height: 100vh;
            background-color: #EEEEEE;
        }

        .header {
            height: 80px;
            background-color: #1D70B8;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
        }

        .header .logo {
            font-weight: bold;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header .user-info img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
        }

        .content-wrapper {
            display: flex;
            flex: 1;
            margin: 20px;
            background-color: white;
            border-radius: 13px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar {
            width: 250px;
            background-color: #1D70B8;
            padding: 1rem;
            color: white;
            border-top-left-radius: 13px;
            border-bottom-left-radius: 13px;
        }

        .sidebar,
        .sidebar a,
        .sidebar .nav-link {
            color: white;
        }


        .main-content {
            flex-grow: 1;
            overflow-y: auto;
            padding: 5rem;
            background-color: white;
            border-top-right-radius: 13px;
            border-bottom-right-radius: 13px;
        }

        .logo img {
            height: 60px;
            width: 60px;
        }

        #user-details {
            line-height: 97%;
            font-size: medium;
        }

        #right-nav-bar {
            display: flex;
            align-items: center;
            gap: 2rem;
            line-height: 98%;
        }

        #live-clock {
            text-align: right;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <div class="layout-wrapper">

        <!-- Header -->
        <div class="header">
            <div class="logo">
                <a href="/dashboard"><img src="{{ asset('images/psu-logo.png') }}" alt="Logo"><a>
                        Supply Office Management
            </div>

            <div class="user-info">
                <a href="{{route('editAdminDetails')}}"><img
                        src="https://images.emojiterra.com/google/noto-emoji/unicode-16.0/color/share/1f981.jpg"
                        alt="Profile" style="object-fit: cover;"></a>
                <div id="user-details">
                    <a><b>{{ auth()->user()->office }}</b></a><br>
                    <a>{{ auth()->user()->email }}</a>

            <div id="right-nav-bar">
                <div id="live-clock"></div>
                <div class="user-info">
                    <img src="https://static.vecteezy.com/system/resources/previews/009/292/244/non_2x/default-avatar-icon-of-social-media-user-vector.jpg" alt="Profile" style="object-fit: cover;">
                    <div id="user-details">
                        <a><b>{{ auth()->user()->office }}</b></a><br>
                        <a>{{ auth()->user()->email }}</a>
                    </div>

                </div>
            </div>
        </div>

        <!-- Sidebar + Content ditoo -->
        <div class="content-wrapper">
            <div class="sidebar">
                @include('layouts.sidebar')
            </div>
            <div class="main-content">
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        function updateClock() {
            const now = new Date();

            const dateOptions = {
                weekday: 'short',
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            };
            const dateString = now.toLocaleDateString(undefined, dateOptions);

            const timeString = now.toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            });

            const clockEl = document.getElementById('live-clock');
            if (clockEl) {
                clockEl.innerHTML = `${dateString}<br>${timeString}`;
            }
        }

        setInterval(updateClock, 1000);
        updateClock();
    </script>
</body>

</html>