<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\AuthRepository;
use App\Interfaces\AuthRepositoryInterface;
use App\Repositories\CategoryRepository;
use App\Interfaces\CategoryRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Interfaces\ProductRepositoryInterface;
use App\Repositories\BrandRepository;
use App\Interfaces\BrandRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );

        $this->app->bind(
            AuthRepositoryInterface::class,
            AuthRepository::class
        );

        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );
        $this->app->bind(
            BrandRepositoryInterface::class,
            BrandRepository::class
       );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
