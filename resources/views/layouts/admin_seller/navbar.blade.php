<nav class="main-header navbar navbar-expand navbar-white navbar-light" style="margin:0%">
    <!-- Left navbar links -->
    <ul class="navbar-nav navbar-dark">
        <a href="{{ url('dashboard') }}" class="brand-link">
            <span class="brand-text font-weight-light text-dark">TraditionMe</span>
            <img src="{{ asset('Logo-removebg.png') }}" alt="TraditionMe Logo" class="brand-image img-circle"
                style="opacity: .8">
        </a>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('switch.view', 'end_user') }}">Switch to Buyer View</a>
        </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        @if (Auth::check())
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <div class="profile-picture">
                        <img style="height: 20px; width: 20px;" src="{{ Auth::user()->profileImage() }}"
                            alt="User profile picture" class="profile-img img-fluid rounded-circle">
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right p-3 profile-dropdown">
                    <div class="profile-info text-center">
                        <div class="profile-picture mb-2">
                            <img style="height: 50px; width: 50px;" src="{{ Auth::user()->profileImage() }}"
                                alt="User profile picture" class="profile-user-img rounded-circle img-thumbnail">
                        </div>
                        <div class="profile-details">
                            <h4 class="profile-username">{{ Auth::user()->username }}</h4>
                            <p class="profile-email">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <div class="dropdown-divider my-4"></div>
                    <a href="{{ url('/profile') }}" class="dropdown-item mr-2"><i class="fas fa-user"></i> My
                        Profile</a>
                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger mr-2">
                            <i class="fas fa-sign-out-alt"></i> Log Out
                        </button>
                    </form>

                </div>
            </li>
        @else
            <li class="nav-item">
                <a href="{{ url('/login') }}" class="nav-link">Login</a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/register') }}" class="nav-link">Register</a>
            </li>
        @endif
    </ul>
</nav>
