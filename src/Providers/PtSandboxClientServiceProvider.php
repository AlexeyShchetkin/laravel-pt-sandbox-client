<?php

declare(strict_types=1);

namespace AlexeyShchetkin\PtSandboxClient\Providers;

use AlexeyShchetkin\PtSandboxClient\Services\PtSandboxClient;
use AlexeyShchetkin\PtSandboxClient\ValueObjects\PtSandboxClientConfiguration;
use Illuminate\Support\ServiceProvider;

final class PtSandboxClientServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(PtSandboxClientConfiguration::class, function () {
            return PtSandboxClientConfiguration::loadFromConfig();
        });
        $this->app->singleton(PtSandboxClient::class, function () {
            return new PtSandboxClient(app(PtSandboxClientConfiguration::class));
        });
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config' => config_path(),
            ], 'laravel-pt-sandbox-client');
        }
    }
}
