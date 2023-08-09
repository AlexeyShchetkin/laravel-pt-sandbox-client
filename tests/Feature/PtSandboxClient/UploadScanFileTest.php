<?php

declare(strict_types=1);

namespace Tests\Feature\PtSandboxClient;

use AlexeyShchetkin\PtSandboxClient\Exceptions\ClientException;
use AlexeyShchetkin\PtSandboxClient\Exceptions\CommunicationException;
use AlexeyShchetkin\PtSandboxClient\Exceptions\MethodNotAllowedException;
use AlexeyShchetkin\PtSandboxClient\Exceptions\UnauthorizedException;
use AlexeyShchetkin\PtSandboxClient\Services\PtSandboxClient;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UploadScanFileTest extends TestCase
{
    /**
     * @throws ClientException
     * @throws CommunicationException
     * @throws MethodNotAllowedException
     * @throws UnauthorizedException
     */
    public function test_upload_scan_file_returns_a_successful_response()
    {
        $client = app(PtSandboxClient::class);
        $fakeResponse = file_get_contents(__DIR__ . '/Fixtures/upload_scan_file_success_response.json');
        Http::fake([
            '*' => Http::response($fakeResponse)
        ]);
        $filename = __DIR__ . '/Fixtures/upload_scan_file_success_response.json';
        $response = $client->uploadScanFile($filename, file_get_contents($filename));

        $this->assertNotEmpty($response->getData()->getFileUri());
    }

    /**
     * @return void
     * @throws ClientException
     * @throws CommunicationException
     * @throws MethodNotAllowedException
     * @throws UnauthorizedException
     */
    public function test_upload_scan_file_returns_401()
    {
        $client = app(PtSandboxClient::class);
        Http::fake([
            '*' => Http::response('', Response::HTTP_UNAUTHORIZED)
        ]);
        $this->expectException(UnauthorizedException::class);

        $filename = __DIR__ . '/Fixtures/upload_scan_file_success_response.json';
        $client->uploadScanFile($filename, file_get_contents($filename));
    }

    /**
     * @return void
     * @throws ClientException
     * @throws CommunicationException
     * @throws MethodNotAllowedException
     * @throws UnauthorizedException
     */
    public function test_upload_scan_file_returns_405()
    {
        $client = app(PtSandboxClient::class);
        Http::fake([
            '*' => Http::response('', Response::HTTP_METHOD_NOT_ALLOWED)
        ]);

        $this->expectException(MethodNotAllowedException::class);

        $filename = __DIR__ . '/Fixtures/upload_scan_file_success_response.json';
        $client->uploadScanFile($filename, file_get_contents($filename));
    }

    /**
     * @return void
     * @throws ClientException
     * @throws CommunicationException
     * @throws MethodNotAllowedException
     * @throws UnauthorizedException
     */
    public function test_upload_scan_file_returns_500()
    {
        $client = app(PtSandboxClient::class);
        Http::fake([
            '*' => Http::response('', Response::HTTP_INTERNAL_SERVER_ERROR)
        ]);

        $this->expectException(CommunicationException::class);

        $filename = __DIR__ . '/Fixtures/upload_scan_file_success_response.json';
        $client->uploadScanFile($filename, file_get_contents($filename));
    }
}

