<?php

declare(strict_types=1);

namespace Tests\Feature\PtSandboxClient;

use AlexeyShchetkin\PtSandboxClient\Exceptions\CheckHealthException;
use AlexeyShchetkin\PtSandboxClient\Exceptions\ClientException;
use AlexeyShchetkin\PtSandboxClient\Exceptions\CommunicationException;
use AlexeyShchetkin\PtSandboxClient\Services\PtSandboxClient;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CheckHealthTest extends TestCase
{
    /**
     * @throws CommunicationException
     * @throws CheckHealthException
     * @throws ClientException
     */
    public function test_check_health_returns_a_successful_response()
    {
        $client = app(PtSandboxClient::class);
        $fakeResponse = file_get_contents(__DIR__ . '/Fixtures/healthcheck_success_response.json');
        Http::fake([
            '*' => Http::response($fakeResponse)
        ]);

        $response = $client->checkHealth();

        $this->assertEquals('OK', $response->getData()->getStatus());
    }

    /**
     * @throws CommunicationException
     * @throws ClientException
     */
    public function test_check_health_returns_failed_response()
    {
        $client = app(PtSandboxClient::class);
        $fakeResponse = file_get_contents(__DIR__ . '/Fixtures/healthcheck_failed_response.json');
        Http::fake([
            '*' => Http::response($fakeResponse)
        ]);
        $this->expectException(CheckHealthException::class);

        $response = $client->checkHealth();

        $this->assertEmpty($response->getData()->getStatus());
        $this->assertNotEmpty($response->getErrors()[0]->getMessage());
    }

    /**
     * @throws CommunicationException
     * @throws ClientException|CheckHealthException
     */
    public function test_check_health_returns_404()
    {
        $client = app(PtSandboxClient::class);
        Http::fake([
            '*' => Http::response('', Response::HTTP_NOT_FOUND)
        ]);
        $this->expectException(CommunicationException::class);

        $client->checkHealth();
    }

    /**
     * @return void
     * @throws ClientException
     * @throws CommunicationException
     * @throws CheckHealthException
     */
    public function test_check_health_returns_500()
    {
        $client = app(PtSandboxClient::class);
        Http::fake([
            '*' => Http::response('', Response::HTTP_INTERNAL_SERVER_ERROR)
        ]);

        $this->expectException(CommunicationException::class);

        $client->checkHealth();
    }
}

