<?php

namespace App\Providers;

use App\Services\Category\ComposeService;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer([
            'shop.index',
            'shop.includes.navigation',
            'shop.includes.main-header',
            'shop.listProducts',
        ], ComposeService::class);
    }
}
