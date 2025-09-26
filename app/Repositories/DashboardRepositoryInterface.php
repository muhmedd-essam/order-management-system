<?php

namespace App\Repositories;

interface DashboardRepositoryInterface
{
    public function totalOrders(): int;

    public function totalRevenue(): float;

    public function topCustomers(int $limit = 5);

    public function export(): array;

}
