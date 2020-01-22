<?php

namespace App\Providers;

use App\Services\Cart\Repositories\CacheCartRepository;
use App\Services\Cart\Repositories\CartRepositoryInterface;
use App\Services\Cart\Repositories\RedisCartRepository;
use App\Services\Orders\Repositories\EloquentOrderRepository;
use App\Services\Orders\Repositories\OrderRepositoryInterface;
use App\Services\Users\Repositories\EloquentUserRepository;
use App\Services\Users\Repositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
//        $this->app->bind(CartRepositoryInterface::class, RedisCartRepository::class);
        $this->app->bind(CartRepositoryInterface::class, CacheCartRepository::class);
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, EloquentOrderRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
