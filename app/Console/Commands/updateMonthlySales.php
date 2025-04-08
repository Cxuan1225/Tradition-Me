<?php

namespace App\Console\Commands;

use App\Models\MonthlySales;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class updateMonthlySales extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:update-monthly-sales';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update montly sales report';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $startOfMonth = Carbon::now()->startOfMonth()->toDateTimeString();
            $endOfMonth = Carbon::now()->endOfMonth()->toDateTimeString();

            $sales = DB::table('order_items')
                ->select(DB::raw('product_name, SUM(quantity * price_per_unit) as total_sales, DATE_FORMAT(created_at, "%Y-%m") as month'))
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->groupBy('product_name', 'month')
                ->get();

            foreach ($sales as $sale) {
                MonthlySales::updateOrCreate(
                    [
                        'product_name' => $sale->product_name,
                        'month' => $sale->month,
                    ],
                    [
                        'total_sales' => $sale->total_sales,
                    ]
                );
            }

            $this->info('Monthly sales report updated successfully!');
        } catch (\Exception $e) {
            $this->error('Failed to update monthly sales report: '.$e->getMessage());
        }
    }
}
