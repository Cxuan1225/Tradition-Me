<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Product;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Dashboard extends Component
{
    public $product;

    public $totalProducts;

    public $orders;

    public $totalOrders;

    public $totalPendingOrders;

    public $totalRevenue;

    //LivewireChart
    public $firstRun = true;

    public $harmoniousColors = [
        '#1f77b4', // Blue
        '#ff7f0e', // Orange
        '#2ca02c', // Green
        '#d62728', // Red
        '#9467bd', // Purple
        '#8c564b', // Brown
        '#e377c2', // Pink
        '#7f7f7f', // Gray
        '#bcbd22', // Olive
        '#17becf',  // Teal
    ];

    public function createColumnChart($title, $data, $nameField, $valueField)
    {
        $columnChartModel = LivewireCharts::columnChartModel()
            ->setTitle($title)
            ->setAnimated(true)
            ->withOnColumnClickEventName('onColumnClick')
            ->setLegendVisibility(true)
            ->setDataLabelsEnabled(true)
            ->setColors([
                '#1f77b4', // Blue
                '#ff7f0e', // Orange
                '#2ca02c', // Green
                '#d62728', // Red
                '#9467bd', // Purple
            ])
            ->setColumnWidth(90)
            ->withGrid();
        $colors = array_slice($this->harmoniousColors, 0, $data->count());
        foreach ($data as $item) {
            $columnChartModel->addColumn($item->$nameField, $item->$valueField, $colors);
        }

        return $columnChartModel;
    }

    public function getPopularProductsChart()
    {
        $popularProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(order_items.quantity) as total_quantity'))
            ->groupBy('products.name')
            ->orderBy('total_quantity', 'desc')
            ->limit(5)
            ->get();

        // Initialize the Pie Chart Model
        $pieChartModel = $popularProducts->reduce(
            function ($pieChartModel, $data) {
                $name = $data->name;
                $quantity = (float) $data->total_quantity;

                return $pieChartModel->addSlice($name, $quantity, '#'.str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, '0', STR_PAD_LEFT)); // Random color for each slice
            },
            LivewireCharts::pieChartModel()
                ->setTitle('Top 5 Popular Products')
                ->setAnimated(true)
                ->asDonut()
                ->withOnSliceClickEvent('onSliceClick')
                ->setDataLabelsEnabled(true)
                ->legendPositionBottom()
                ->legendHorizontallyAlignedCenter()
                ->setColors(['#FF5733', '#33FF57', '#3357FF', '#F3FF33', '#FF33A1'])
        );

        return $pieChartModel;
    }

    public function getMonthlySalesChart()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $monthlySales = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->select(
                'order_items.product_name',
                DB::raw('DATE_FORMAT(orders.created_at, "%Y-%m") as month'),
                DB::raw('SUM(order_items.quantity * order_items.price_per_unit) as total_sales')
            )
            ->whereBetween(DB::raw('DATE_FORMAT(orders.created_at, "%Y-%m")'), [$startOfMonth->format('Y-m'), $endOfMonth->format('Y-m')])
            ->whereNotIn('orders.status', ['pending', 'cancel', 'refunded'])
            ->groupBy('order_items.product_name', 'month')
            ->orderBy('total_sales', 'desc')
            ->limit(5)
            ->get();

        return $this->createColumnChart('Highest Monthly Sales', $monthlySales, 'product_name', 'total_sales');
    }

    public function getYearlySales($year)
    {
        return DB::table('order_items')
            ->select(DB::raw('MONTH(created_at) as month, SUM(quantity * price_per_unit) as total_sales'))
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
    }

    public function createYearlySalesChart($yearlySales, $year)
    {
        $yearlySalesChart = LivewireCharts::lineChartModel()
            ->setTitle("Sales Report for Year $year")
            ->setAnimated(true)
            ->setSmoothCurve()
            ->setXAxisVisible(true)
            ->setDataLabelsEnabled(true)
            ->withLegend()
            ->singleLine()
            ->setColors(['#1f77b4'])
            ->setXAxisCategories(
                collect(range(1, 12))->map(function ($month) use ($year) {
                    return "{$year}-".str_pad($month, 2, '0', STR_PAD_LEFT);
                })->toArray()
            )
            ->sparklined();

        $monthlySales = collect(range(1, 12))->mapWithKeys(function ($month) use ($yearlySales) {
            $sales = $yearlySales->firstWhere('month', $month);

            return [$month => $sales ? $sales->total_sales : 0];
        });

        $monthlySales->each(function ($value, $month) use ($yearlySalesChart) {
            $yearlySalesChart->addPoint("Month $month", $value);
        });

        return $yearlySalesChart;
    }

    public function getMontlyRevenueByCategories()
    {
        $monthlyRevenueByCategory = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select(DB::raw('DATE_FORMAT(order_items.created_at, "%Y-%m") as month'), 'products.category', DB::raw('SUM(order_items.quantity * order_items.price_per_unit) as total_sales'))
            ->groupBy('month', 'products.category')
            ->orderBy('month', 'asc')
            ->get();

        $categories = $monthlyRevenueByCategory->pluck('category')->unique();
        $lineChartModel = LivewireCharts::lineChartModel()
            ->setTitle('Monthly Revenue by Category')
            ->setAnimated(true)
            ->setSmoothCurve()
            ->setXAxisVisible(true)
            ->setDataLabelsEnabled(true)
            ->withLegend()
            ->multiLine()
            ->setColors(['#1f77b4', '#ff7f0e', '#2ca02c'])
            ->setXAxisCategories($monthlyRevenueByCategory->pluck('month')->unique()->toArray())
            ->sparklined();

        foreach ($categories as $category) {
            $categoryData = $monthlyRevenueByCategory->where('category', $category);

            foreach ($categoryData as $data) {
                $month = $data->month;
                $totalSales = $data->total_sales;
                $lineChartModel->addSeriesPoint($category, $month, $totalSales);
            }
        }

        return $lineChartModel;
    }

    #[Layout('layouts.admin_seller.app')]
    public function render()
    {
        $this->orders = Order::latest()->take(5)->get();
        $this->totalProducts = Product::count();
        $this->totalOrders = Order::count();
        $this->totalPendingOrders = Order::where('status', 'pending')->count();
        $this->totalRevenue = Order::whereNotIn('status', ['pending', 'cancel', 'refunded'])->sum('total_price');
        $highestSalesChart = $this->getMonthlySalesChart();
        $popularProductChart = $this->getPopularProductsChart();
        $lineChartModel = $this->getMontlyRevenueByCategories();
        $specificYear = 2024;
        $yearlySales = $this->getYearlySales($specificYear);
        $yearlySalesChart = $this->createYearlySalesChart($yearlySales, $specificYear);
        $this->firstRun = false;

        return view('livewire.dashboard', [
            'order' => $this->orders,
            'totalProducts' => $this->totalProducts,
            'totalOrders' => $this->totalOrders,
            'totalPendingOrders' => $this->totalPendingOrders,
            'totalRevenue' => $this->totalRevenue,
            'popularProductChart' => $popularProductChart,
            'highestSalesChart' => $highestSalesChart,
            'lineChartModel' => $lineChartModel,
            'yearlySalesChart' => $yearlySalesChart,
        ]);
    }
}
