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
use App\Interfaces\UnitRepositoryInterface;
use App\Repositories\UnitRepository;
use App\Interfaces\TaxRepositoryInterface;
use App\Repositories\TaxRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any Application services.
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
        $this->app->bind(
            UnitRepositoryInterface::class,
            UnitRepository::class
        );
        $this->app->bind(
            TaxRepositoryInterface::class,
            TaxRepository::class
        );
    }

    /**
     * Bootstrap any Application services.
     */
    public function boot(): void
    {
        //
    }
}
