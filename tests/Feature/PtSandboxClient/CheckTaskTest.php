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

class CheckTaskTest extends TestCase
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
    public function test_check_task_returns_a_wait_response()
    {
        $fakeResponse = file_get_contents(__DIR__ . '/Fixtures/CheckTask/wait_response.json');
        Http::fake([
            '*' => Http::response($fakeResponse)
        ]);

        $response = $this->client->checkTask('test');
        $this->assertNull($response->getData()->getResult());
        $this->assertNotEmpty($response->getData()->getScanId());
    }

    /**
     * @throws ClientException
     * @throws CommunicationException
     * @throws MethodNotAllowedException|UnauthorizedException|FileNotFoundException
     */
    public function test_check_task_returns_a_clean_response()
    {
        $fakeResponse = file_get_contents(__DIR__ . '/Fixtures/CheckTask/finished_clean_response.json');
        Http::fake([
            '*' => Http::response($fakeResponse)
        ]);

        $response = $this->client->checkTask('test');
        $this->assertTrue($response->isClean());
        $this->assertFalse($response->isUnwanted());
        $this->assertFalse($response->isDangerous());
    }

    /**
     * @throws ClientException
     * @throws CommunicationException
     * @throws MethodNotAllowedException|UnauthorizedException|FileNotFoundException
     */
    public function test_check_task_returns_a_unwanted_response()
    {
        $fakeResponse = file_get_contents(__DIR__ . '/Fixtures/CheckTask/finished_unwanted_response.json');
        Http::fake([
            '*' => Http::response($fakeResponse)
        ]);

        $response = $this->client->checkTask('test');
        $this->assertFalse($response->isClean());
        $this->assertTrue($response->isUnwanted());
        $this->assertFalse($response->isDangerous());
    }

    /**
     * @throws ClientException
     * @throws CommunicationException
     * @throws MethodNotAllowedException|UnauthorizedException|FileNotFoundException
     */
    public function test_check_task_returns_a_dangerous_response()
    {
        $fakeResponse = file_get_contents(__DIR__ . '/Fixtures/CheckTask/finished_dangerous_response.json');
        Http::fake([
            '*' => Http::response($fakeResponse)
        ]);

        $response = $this->client->checkTask('test');
        $this->assertFalse($response->isClean());
        $this->assertFalse($response->isUnwanted());
        $this->assertTrue($response->isDangerous());
    }

    /**
     * @return void
     * @throws ClientException
     * @throws CommunicationException
     * @throws MethodNotAllowedException|UnauthorizedException|FileNotFoundException
     */
    public function test_check_task_returns_401()
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
    public function test_check_task_returns_404()
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
    public function test_check_task_returns_405()
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
    public function test_check_task_returns_500()
    {
        Http::fake([
            '*' => Http::response('', Response::HTTP_INTERNAL_SERVER_ERROR)
        ]);

        $this->expectException(CommunicationException::class);

        $this->client->createScanTask('');
    }
}

