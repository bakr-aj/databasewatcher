<?php

namespace bakraj\DataBaseWatcher;

use Illuminate\Support\ServiceProvider;

class DataBaseWatcherServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'bakraj');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'bakraj');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {

            // Publishing the configuration file.
            $this->publishes([
                __DIR__.'/../config/databasewatcher.php' => config_path('databasewatcher.php'),
            ], 'databasewatcher.config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => base_path('resources/views/vendor/bakraj'),
            ], 'databasewatcher.views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/bakraj'),
            ], 'databasewatcher.views');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/bakraj'),
            ], 'databasewatcher.views');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/databasewatcher.php', 'databasewatcher');

        // Register the service the package provides.
        $this->app->singleton('databasewatcher', function ($app) {
            return new DataBaseWatcher;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['databasewatcher'];
    }
}