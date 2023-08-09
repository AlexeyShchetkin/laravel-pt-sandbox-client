<?php

declare(strict_types=1);

return [
    /*
     * Sandbox base URL
     */
    'base_url' => env('PT_SANDBOX_BASE_URL', ''),
    /*
     * Sandbox base URL
     */
    'token' => env('PT_SANDBOX_TOKEN', ''),
    /*
     * Sandbox connect timeout
     */
    'connect_timeout' => env('PT_SANDBOX_CONNECT_TIMEOUT', 5),
    /*
     * Sandbox timeout
     */
    'timeout' => env('PT_SANDBOX_TIMEOUT', 60),
];
