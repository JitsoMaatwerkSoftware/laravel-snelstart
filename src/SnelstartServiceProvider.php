<?php

namespace Jitso\LaravelSnelstart;

use Illuminate\Support\ServiceProvider;
use Jitso\LaravelSnelstart\Auth\TokenManager;
use Jitso\LaravelSnelstart\Client\SnelstartClient;

class SnelstartServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/snelstart.php', 'snelstart');

        $this->app->singleton(TokenManager::class, function ($app) {
            return new TokenManager(
                tokenUrl: config('snelstart.token_url'),
                clientKey: config('snelstart.client_key'),
                clientSecret: config('snelstart.client_secret'),
                cacheToken: config('snelstart.cache_token', true),
            );
        });

        $this->app->singleton(SnelstartClient::class, function ($app) {
            return new SnelstartClient(
                tokenManager: $app->make(TokenManager::class),
                baseUrl: config('snelstart.base_url'),
                subscriptionKey: config('snelstart.subscription_key'),
            );
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/snelstart.php' => config_path('snelstart.php'),
        ], 'snelstart-config');
    }
}
