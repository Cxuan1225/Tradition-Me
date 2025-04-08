<header id="header" class="site-header header-scrolled position-fixed text-black bg-light">
    <nav id="header-nav" class="navbar navbar-expand-lg px-3 mb-3">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('Logo-removebg.png') }}" class="logo small-logo">
            </a>
            <button class="navbar-toggler d-flex d-lg-none order-3 p-2" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#bdNavbar" aria-controls="bdNavbar" aria-expanded="false"
                aria-label="Toggle navigation">
                <svg class="navbar-icon">
                    <use xlink:href="#navbar-icon"></use>
                </svg>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="bdNavbar" aria-labelledby="bdNavbarOffcanvasLabel">
                <div class="offcanvas-header px-4 pb-0">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ asset('Logo-removebg.png') }}" class="logo small-logo">
                    </a>
                    <button type="button" class="btn-close btn-close-black" data-bs-dismiss="offcanvas"
                        aria-label="Close" data-bs-target="#bdNavbar"></button>
                </div>
                <div class="offcanvas-body">
                    <ul id="navbar"
                        class="navbar-nav text-uppercase justify-content-end align-items-center flex-grow-1 pe-3">
                        <ul class="nav">
                            <ul class="nav">
                                <li class="nav-item">
                                    <a class="nav-link me-4 {{ request()->is('/') ? 'active' : '' }}"
                                        href="{{ url('/') }}">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link me-4 {{ request()->is('end_user/product/showCategory/Malay') ? 'active' : '' }}"
                                        href="{{ route('end_user.product.showCategory', 'Malay') }}">Malay Products</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link me-4 {{ request()->is('end_user/product/showCategory/Chinese') ? 'active' : '' }}"
                                        href="{{ route('end_user.product.showCategory', 'Chinese') }}">Chinese
                                        Products</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link me-4 {{ request()->is('end_user/product/showCategory/Indian') ? 'active' : '' }}"
                                        href="{{ route('end_user.product.showCategory', 'Indian') }}">Indian
                                        Products</a>
                                </li>
                            </ul>

                            @if (Auth::check())
                                <li class="nav-item">
                                    <div class="user-items ps-5">
                                        <ul class="d-flex justify-content-end align-items-center list-unstyled">
                                            @livewire('cart-dropdown')
                                            <li class="nav-item dropdown dropdown-menu-right pe-3">
                                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown"
                                                    data-bs-toggle="dropdown">
                                                    <img style="height: 40px; width: 40px; border:none;"
                                                        src="{{ Auth::user()->profileImage() }}"
                                                        alt="User profile picture"
                                                        class="profile-user-img rounded-circle img-thumbnail">
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-right"
                                                    aria-labelledby="userDropdown" data-toggle="dropdown"
                                                    aria-haspopup="true">
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('profile.edit') }}">Profile</a></li>
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('order.index') }}">Order</a></li>
                                                    @auth
                                                        @if (Auth::user()->role === 'admin')
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('switch.view', 'admin') }}">Admin<br>
                                                                    View</a>
                                                            </li>
                                                        @endif
                                                    @endauth
                                                    <li>
                                                        <form id="logout-form" action="{{ url('/logout') }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item">
                                                                Log Out
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            @else
                                <li class="nav-item">
                                    <div class="user-items ps-5">
                                        <ul class="d-flex justify-content-end align-items-center list-unstyled">
                                            <li class="pe-3">
                                                <a href="{{ route('login') }}">Login</a>
                                            </li>
                                            <li class="pe-3">
                                                <a href="{{ route('register') }}">Register</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            @endif
                        </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
