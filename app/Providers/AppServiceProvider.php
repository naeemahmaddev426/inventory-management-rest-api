<?php

namespace app\Providers;

use Illuminate\Support\ServiceProvider;
use app\Repositories\AuthRepository;
use app\Interfaces\AuthRepositoryInterface;
use app\Repositories\CategoryRepository;
use app\Interfaces\CategoryRepositoryInterface;
use app\Repositories\ProductRepository;
use app\Interfaces\ProductRepositoryInterface;
use app\Repositories\BrandRepository;
use app\Interfaces\BrandRepositoryInterface;
use App\Interfaces\UnitRepositoryInterface;
use App\Repositories\UnitRepository;

class appServiceProvider extends ServiceProvider
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
       $this->app->bind(
            UnitRepositoryInterface::class,
            UnitRepository::class
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
