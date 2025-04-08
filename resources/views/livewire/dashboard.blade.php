<div>
    @section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <!-- Add breadcrumbs or additional information if needed -->
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- Total Products -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $totalProducts }}</h3>
                                <p>Total Products</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-box"></i>
                            </div>
                            <a href="{{ route('admin.product.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- Total Orders -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totalOrders }}</h3>
                                <p>Total Orders</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('order.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- Total Pending Orders -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>{{ $totalPendingOrders }}</h3>
                                <p>Total Pending Orders</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-hourglass-half"></i>
                            </div>
                            <a href="{{ route('order.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- Total Revenue -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>RM{{ number_format($totalRevenue, 2) }}</h3>
                                <p>Total Revenue</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <a href="{{ route('order.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Highest Monthly Product Sales -->
                    <section class="col-lg-7 connectedSortable">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <h3 class="card-title">Highest Monthly Product Sales</h3>
                            </div>
                            <div class="card-body"style="height: 500px">
                                <livewire:livewire-column-chart key="{{ $highestSalesChart->reactiveKey() }}"
                                    :column-chart-model="$highestSalesChart" />
                            </div>
                            <div class="card-footer bg-primary">
                                <small class="text-muted text-white">Sales data for the current month.</small>
                            </div>
                        </div>

                        <!-- Monthly Revenue By Category -->
                        <div class="card">
                            <div class="card-header bg-primary">
                                <h3 class="card-title">Monthly Revenue by Category</h3>
                            </div>
                            <div class="card-body">
                                <livewire:livewire-line-chart key="{{ $lineChartModel->reactiveKey() }}"
                                    :line-chart-model="$lineChartModel" />
                            </div>
                            <div class="card-footer bg-primary">
                                <small class="text-muted text-white">The chart represents the monthly revenue distribution
                                    by
                                    category.</small>
                            </div>
                        </div>

                        <!-- Yearly Sales Trend -->
                        <div class="card">
                            <div class="card-header bg-primary">
                                <h3 class="card-title">Yearly Sales Trend</h3>
                            </div>
                            <div class="card-body">
                                <livewire:livewire-line-chart key="{{ $yearlySalesChart->reactiveKey() }}"
                                    :line-chart-model="$yearlySalesChart" />
                            </div>
                            <div class="card-footer bg-primary">
                                <small class="text-muted text-white">Tracks annual performance and identifies trends over
                                    time.</small>
                            </div>
                        </div>
                    </section>

                    <!-- Most Popular Products & Latest Orders -->
                    <section class="col-lg-5 connectedSortable">
                        <!-- Most Popular Products -->
                        <div class="card">
                            <div class="card-header bg-primary">
                                <h3 class="card-title">Most Popular Products</h3>
                            </div>
                            <div class="card-body" style="height: 500px">
                                <livewire:livewire-pie-chart :pie-chart-model="$popularProductChart" />
                            </div>
                            <div class="card-footer bg-primary">
                                <small class="text-muted text-white">Top products based on quantity sold.</small>
                            </div>
                        </div>

                        <!-- Latest Orders -->
                        <div class="card">
                            <div class="card-header bg-primary border-transparent">
                                <h3 class="card-title">Latest Orders</h3>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped m-0">
                                        <thead>
                                            <tr>
                                                <th>Index</th>
                                                <th>Customer ID</th>
                                                <th>Status</th>
                                                <th>Total</th>
                                                <th>Created Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $order->user_id }}</td>
                                                    <td><span
                                                            class="badge bg-{{ $order->status_color }}">{{ ucfirst($order->status) }}</span>
                                                    </td>
                                                    <td>RM{{ number_format($order->total_price, 2) }}</td>
                                                    <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer bg-primary clearfix">
                                <a href="{{ route('order.index') }}" class="btn btn-sm btn-success float-right">View
                                    All
                                    Orders</a>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    @endsection
</div>
