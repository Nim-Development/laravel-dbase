<?php

namespace NimDevelopment\DBase;

use Illuminate\Support\ServiceProvider;
use NimDevelopment\DBase\Classes\DBase;

class DBaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('DBase', function(){
            return new DBase();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //publish to main app
        $this->publishes([
            __DIR__.'/config.php' => config_path('DBase.php'),
            __DIR__.'/DBase' => base_path(config('DBase.migration_path')),
        ]);

        // package scope
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views', 'DBase');

        /* Include the migration path published migrations path so that it will by recorgnized by artisan migrate */
        $this->loadMigrationsFrom(config('DBase.migration_path'));

    }
}
