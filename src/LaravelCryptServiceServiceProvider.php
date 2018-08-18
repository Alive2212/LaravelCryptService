<?php

namespace Alive2212\LaravelCryptService;

use Alive2212\LaravelCryptService\Console\Commands\Init;
use Illuminate\Support\ServiceProvider;

class LaravelCryptServiceServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // translations
        $this->loadTranslationsFrom(resource_path('lang/vendor/alive2212'),
            'laravel-crypt-service');

        // migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {

            // Publishing the configuration file.
            $this->publishes([
                __DIR__ . '/../config/laravel-crypt-service.php' =>
                    $this->app->basePath() .
                    '/config/' .
                    'laravel-crypt-service.php',
            ], 'laravel-crypt-service.config');

            // Publishing the translation files.
            $this->publishes([
                __DIR__ . '/../resources/lang/' => resource_path('lang/vendor/alive2212'),
            ], 'laravel-crypt-service.lang');

            // Registering package commands.
            $this->commands([
                Init::class,
            ]);

        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-crypt-service.php', 'laravel-crypt-service');

        // Register the service the package provides.
        $this->app->singleton('LaravelCryptService', function ($app) {
            return new LaravelCryptService;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['LaravelCryptService'];
    }
}