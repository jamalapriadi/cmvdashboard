<?php

namespace App\Providers;

use Illuminate\Pagination\BootstrapFourPresenter;
use Illuminate\Support\Facades\Paginator;
use Illuminate\Support\ServiceProvider;

class PaginationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        \Paginator::presenter(function($paginator)
        {
            return new BootstrapFourPresenter($paginator);
        });
    }
}
