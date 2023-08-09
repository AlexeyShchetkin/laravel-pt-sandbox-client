<?php

declare(strict_types=1);

namespace AlexeyShchetkin\PtSandboxClient\ValueObjects;

final class PtSandboxClientConfiguration
{
    private string $baseUrl = '';
    private float $connectTimeout = 5.0;
    private float $timeout = 60.0;
    private string $token = '';

    private function __construct()
    {
    }

    public static function loadFromConfig(): self
    {
        $configuration = new self();
        $configuration->baseUrl = (string)config('laravel_pt_sandbox_client.base_url', '');
        $configuration->token = (string)config('laravel_pt_sandbox_client.token', '');
        $configuration->connectTimeout = (float)config('laravel_pt_sandbox_client.connect_timeout', 5.0);
        $configuration->timeout = (float)config('laravel_pt_sandbox_client.timeout', 60.0);
        return $configuration;
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return float
     */
    public function getConnectTimeout(): float
    {
        return $this->connectTimeout;
    }

    /**
     * @return float
     */
    public function getTimeout(): float
    {
        return $this->timeout;
    }
}
