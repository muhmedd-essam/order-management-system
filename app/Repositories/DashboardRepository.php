<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class DashboardRepository implements DashboardRepositoryInterface
{
    public function totalOrders(): int
    {
        return Order::count();
    }

    public function totalRevenue(): float
    {
        return (float) Order::sum('total');
    }

    public function topCustomers(int $limit = 5)
    {
        return Customer::withSum('orders', 'total')
            ->orderByDesc('orders_sum_total')
            ->limit($limit)
            ->get();
    }

    public function export(): array
    {
        return Customer::withCount('orders')
            ->withSum('orders', 'total')
            ->orderByDesc('orders_count')
            ->get()
            ->map(function ($customer) {
                return [
                    'name' => $customer->name,
                    'orders_count' => $customer->orders_count,
                    'total_spent' => $customer->orders_sum_total,
                ];
            })
            ->toArray();
    }
}
