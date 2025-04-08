<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('Logo.png') }}" alt="TraditionMe Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">TraditionMe</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- General Heading -->
                <li class="nav-header">NAVIGATION</li>

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link" name="dashboard">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Product Management -->
                <li class="nav-item">
                    <a href="{{ route('admin.product.index') }}" class="nav-link" name="product">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>Products</p>
                    </a>
                </li>

                <!-- Orders -->
                <li class="nav-item">
                    <a href="{{ route('order.index') }}" class="nav-link" name="order">
                        <i class="nav-icon fas fa-shopping-basket"></i>
                        <p>Orders</p>
                    </a>
                </li>

                <!-- Customers -->
                <!-- <li class="nav-item">
                    <a href="index.php?page=customerList" class="nav-link" name="customerList">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Customers</p>
                    </a>
                </li> -->

                <!-- Reports -->
                <!-- <li class="nav-item">
                    <a href="index.php?page=reports" class="nav-link" name="reports">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Reports</p>
                    </a>
                </li> -->

                <!-- Account Heading -->
                <li class="nav-header">ACCOUNT</li>

                <!-- Profile -->
                <li class="nav-item">
                    <a href="{{ route('profile.edit') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-circle"></i>
                        <p>My Profile</p>
                    </a>
                </li>
                <!-- Logout -->
                <li class="nav-item">
                    <a href="#" class="nav-link logout-link text-red">
                        <i class="fas fa-sign-out-alt"></i>
                        <p>Log Out</p>
                    </a>
                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
