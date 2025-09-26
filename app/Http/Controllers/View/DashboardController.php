<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\DashboardRepositoryInterface;


class DashboardController extends Controller
{
    protected $dashboard;

    public function __construct(DashboardRepositoryInterface $dashboard)
    {
        $this->dashboard = $dashboard;
    }

    public function index()
    {
        $totalOrders = $this->dashboard->totalOrders();
        $totalRevenue = $this->dashboard->totalRevenue();
        $topCustomers = $this->dashboard->topCustomers();

        return view('dashboard', compact('totalOrders', 'totalRevenue', 'topCustomers'));
    }

    public function export()
    {
        $data = $this->dashboard->export();
        $filename = 'dashboard_' . date('Y-m-d_H-i-s') . '.csv';

        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['Customer', 'Orders Count', 'Total Spent']);

        foreach ($data as $row) {
            fputcsv($handle, [$row['name'], $row['orders_count'], $row['total_spent']]);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }
}
