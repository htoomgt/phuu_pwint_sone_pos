<?php

namespace App\Providers;

use App\Repositories\Interfaces\ProductReadRepositoryInterface;
use App\Repositories\Interfaces\ProductWriteRepositoryInterface;
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
        $this->app->bind(ProductReadRepositoryInterface::class, \App\Repositories\ProductReadRepository::class);
        $this->app->bind(ProductWriteRepositoryInterface::class, \App\Repositories\ProductWriteRepository::class);

        $this->app->bind(ProductCriteriaChangeLogReadRepositoryInterface::class, \App\Repositories\ProductCriteriaChangeLogReadRepository::class);
        $this->app->bind(ProductCriteriaChangeLogWriteRepositoryInterface::class, \App\Repositories\ProductCriteriaChangeLogWriteRepository::class);
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
