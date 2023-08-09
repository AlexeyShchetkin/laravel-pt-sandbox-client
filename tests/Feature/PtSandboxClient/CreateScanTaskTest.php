<?php

declare(strict_types=1);

namespace Tests\Feature\PtSandboxClient;

use AlexeyShchetkin\PtSandboxClient\Exceptions\ClientException;
use AlexeyShchetkin\PtSandboxClient\Exceptions\CommunicationException;
use AlexeyShchetkin\PtSandboxClient\Exceptions\FileNotFoundException;
use AlexeyShchetkin\PtSandboxClient\Exceptions\MethodNotAllowedException;
use AlexeyShchetkin\PtSandboxClient\Exceptions\UnauthorizedException;
use AlexeyShchetkin\PtSandboxClient\Services\PtSandboxClient;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CreateScanTaskTest extends TestCase
{
    /**
     * @var PtSandboxClient
     */
    private mixed $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = app(PtSandboxClient::class);
    }

    /**
     * @throws ClientException
     * @throws CommunicationException
     * @throws MethodNotAllowedException|UnauthorizedException|FileNotFoundException
     */
    public function test_create_scan_task_returns_a_successful_response()
    {
        $fakeResponse = file_get_contents(__DIR__ . '/Fixtures/create_scan_task_success_response_short.json');
        Http::fake([
            '*' => Http::response($fakeResponse)
        ]);

        $response = $this->client->createScanTask(__DIR__ . '/Fixtures/create_scan_task_success_response_short.json');
        $this->assertNotEmpty($response->getData()->getScanId());
    }

    /**
     * @return void
     * @throws ClientException
     * @throws CommunicationException
     * @throws MethodNotAllowedException|UnauthorizedException|FileNotFoundException
     */
    public function test_create_scan_task_returns_401()
    {
        Http::fake([
            '*' => Http::response('', Response::HTTP_UNAUTHORIZED)
        ]);
        $this->expectException(UnauthorizedException::class);

        $this->client->createScanTask('');
    }

    /**
     * @return void
     * @throws ClientException
     * @throws CommunicationException
     * @throws MethodNotAllowedException|UnauthorizedException|FileNotFoundException
     */
    public function test_create_scan_task_returns_404()
    {
        Http::fake([
            '*' => Http::response('', Response::HTTP_NOT_FOUND)
        ]);
        $this->expectException(FileNotFoundException::class);

        $this->client->createScanTask('');
    }

    /**
     * @return void
     * @throws ClientException
     * @throws CommunicationException
     * @throws MethodNotAllowedException|UnauthorizedException|FileNotFoundException
     */
    public function test_create_scan_task_returns_405()
    {
        Http::fake([
            '*' => Http::response('', Response::HTTP_METHOD_NOT_ALLOWED)
        ]);
        $this->expectException(MethodNotAllowedException::class);

        $this->client->createScanTask('');
    }

    /**
     * @return void
     * @throws ClientException
     * @throws CommunicationException
     * @throws MethodNotAllowedException|UnauthorizedException|FileNotFoundException
     */
    public function test_create_scan_task_returns_500()
    {
        Http::fake([
            '*' => Http::response('', Response::HTTP_INTERNAL_SERVER_ERROR)
        ]);

        $this->expectException(CommunicationException::class);

        $this->client->createScanTask('');
    }
}

