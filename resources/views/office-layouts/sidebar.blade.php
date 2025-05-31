<style>
    .icon {
        height: 25px;
    }

    .nav-item {
        margin-bottom: .5rem;
    }
</style>


<div class="d-flex flex-column p-3 " style="width: 250px; min-height: 100vh;">
    <!-- <h4 class="mb-3">Admin Panel</h4> -->
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <div class="d-flex align-items-center gap-2">
                <img class="icon" src="{{ asset('images/check-list.svg') }}">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    Summary
                </a>
            </div>
        </li>
        <li class="nav-item">
            <div class="d-flex align-items-center gap-2">
                <img class="icon" src="{{ asset('images/return-request.svg') }}">
                <a href="{{ route('request.create') }}" class="nav-link {{ request()->routeIs('request.create') ? 'active' : '' }}">
                    Create Request
                </a>
            </div>
        </li>
        <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </li>
    </ul>
</div>