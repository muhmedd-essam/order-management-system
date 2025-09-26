<?php

namespace App\Providers;

use App\Repositories\CustomerRepository;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\DashboardRepository;
use App\Repositories\DashboardRepositoryInterface;
use App\Repositories\EloquentUserRepository;
use App\Repositories\OrderRepository;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);

        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);

        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);

        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);

        $this->app->bind(DashboardRepositoryInterface::class, DashboardRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
