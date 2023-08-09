<?php

declare(strict_types=1);

namespace AlexeyShchetkin\PtSandboxClient\Services;

use AlexeyShchetkin\PtSandboxClient\DataTransferObjects\CheckHealthResponse;
use AlexeyShchetkin\PtSandboxClient\DataTransferObjects\CheckStatus\Request as CheckStatusRequest;
use AlexeyShchetkin\PtSandboxClient\DataTransferObjects\CheckStatus\Response as CheckStatusResponse;
use AlexeyShchetkin\PtSandboxClient\DataTransferObjects\CreateScanTaskRequest;
use AlexeyShchetkin\PtSandboxClient\DataTransferObjects\CreateScanTaskResponse;
use AlexeyShchetkin\PtSandboxClient\DataTransferObjects\UploadScanFileResponse;
use AlexeyShchetkin\PtSandboxClient\Exceptions\CheckHealthException;
use AlexeyShchetkin\PtSandboxClient\Exceptions\ClientException;
use AlexeyShchetkin\PtSandboxClient\Exceptions\CommunicationException;
use AlexeyShchetkin\PtSandboxClient\Exceptions\FileNotFoundException;
use AlexeyShchetkin\PtSandboxClient\Exceptions\MethodNotAllowedException;
use AlexeyShchetkin\PtSandboxClient\Exceptions\UnauthorizedException;
use AlexeyShchetkin\PtSandboxClient\ValueObjects\PtSandboxClientConfiguration;
use Exception;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

final class PtSandboxClient
{
    private PtSandboxClientConfiguration $configuration;
    private SerializerInterface $serializer;
    private LoggerInterface $logger;
    private string $checkHealthPath;
    private string $uploadScanFilePath;
    private string $createScanTaskPath;
    private string $checkTaskPath;

    public function __construct(PtSandboxClientConfiguration $configuration)
    {
        $this->logger = Log::getLogger();
        $this->serializer = app(SerializerInterface::class);
        $this->configuration = $configuration;
        $this->checkHealthPath = '/maintenance/checkHealth';
        $this->uploadScanFilePath = '/storage/uploadScanFile';
        $this->createScanTaskPath = '/analysis/createScanTask';
        $this->checkTaskPath = '/analysis/checkTask';
    }


    /**
     * @return CheckHealthResponse
     * @throws ClientException|CommunicationException|CheckHealthException
     */
    public function checkHealth(): CheckHealthResponse
    {
        try {
            $response = $this->buildHttpClient()->post(
                $this->checkHealthPath
            )->throw();
            /** @var CheckHealthResponse $response */
            $response = $this->serializer->deserialize($response, CheckHealthResponse::class, 'json');
            if (empty($response->getData()->getStatus())) {
                throw new CheckHealthException($response->getErrors()[0]->getMessage());
            }
            return $response;
        } catch (CheckHealthException $e) {
            throw $e;
        } catch (HttpClientException $e) {
            $this->logger->warning($e->getMessage());
            throw new CommunicationException($e->getMessage(), $e->getCode(), $e);
        } catch (Exception $e) {
            $this->logger->warning($e->getMessage());
            throw new ClientException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param string $filename
     * @param string $content
     * @return UploadScanFileResponse
     * @throws ClientException
     * @throws CommunicationException
     * @throws MethodNotAllowedException
     * @throws UnauthorizedException
     */
    public function uploadScanFile(string $filename, string $content): UploadScanFileResponse
    {
        try {
            $response = $this
                ->buildHttpClient()
                ->withHeaders(['Content-Type' => 'application/octet-stream'])
                ->attach('file', $content, $filename)
                ->post(
                    $this->uploadScanFilePath
                )->throw();
            /** @var UploadScanFileResponse $response */
            $response = $this->serializer->deserialize($response, UploadScanFileResponse::class, 'json');
            return $response;
        } catch (RequestException $e) {
            if (Response::HTTP_METHOD_NOT_ALLOWED === $e->response->status()) {
                throw new MethodNotAllowedException($e->response);
            }
            if ($e->response->unauthorized()) {
                throw new UnauthorizedException($e->response);
            }
            $this->logger->warning($e->getMessage());
            throw new CommunicationException($e->getMessage(), $e->getCode(), $e);
        } catch (Exception $e) {
            $this->logger->warning($e->getMessage());
            throw new ClientException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param string $fileUri
     * @return CreateScanTaskResponse
     * @throws ClientException
     * @throws CommunicationException
     * @throws FileNotFoundException
     * @throws MethodNotAllowedException
     * @throws UnauthorizedException
     */
    public function createScanTask(string $fileUri): CreateScanTaskResponse
    {
        try {
            $request = new CreateScanTaskRequest($fileUri);
            $response = $this
                ->buildHttpClient()
                ->post(
                    $this->createScanTaskPath,
                    $request->toArray()
                )->throw();
            /** @var CreateScanTaskResponse $response */
            $response = $this->serializer->deserialize($response, CreateScanTaskResponse::class, 'json');
            return $response;
        } catch (RequestException $e) {
            if (Response::HTTP_METHOD_NOT_ALLOWED === $e->response->status()) {
                throw new MethodNotAllowedException($e->response);
            }
            if ($e->response->notFound()) {
                throw new FileNotFoundException($e->response);
            }
            if ($e->response->unauthorized()) {
                throw new UnauthorizedException($e->response);
            }
            $this->logger->warning($e->getMessage());
            throw new CommunicationException($e->getMessage(), $e->getCode(), $e);
        } catch (Exception $e) {
            $this->logger->warning($e->getMessage());
            throw new ClientException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function checkTask(string $scanId): CheckStatusResponse
    {
        try {
            $request = new CheckStatusRequest($scanId);
            $response = $this
                ->buildHttpClient()
                ->post(
                    $this->checkTaskPath,
                    $request->toArray()
                )->throw();
            /** @var CheckStatusResponse $response */
            $response = $this->serializer->deserialize($response, CheckStatusResponse::class, 'json');
            return $response;
        } catch (RequestException $e) {
            if (Response::HTTP_METHOD_NOT_ALLOWED === $e->response->status()) {
                throw new MethodNotAllowedException($e->response);
            }
            if ($e->response->notFound()) {
                throw new FileNotFoundException($e->response);
            }
            if ($e->response->unauthorized()) {
                throw new UnauthorizedException($e->response);
            }
            $this->logger->warning($e->getMessage());
            throw new CommunicationException($e->getMessage(), $e->getCode(), $e);
        } catch (Exception $e) {
            $this->logger->warning($e->getMessage());
            throw new ClientException($e->getMessage(), $e->getCode(), $e);
        }
    }

    private function buildHttpClient(): PendingRequest
    {
        return Http::asJson()
            ->baseUrl($this->configuration->getBaseUrl())
            ->withHeaders([
                'X-API-Key' => $this->configuration->getToken()
            ])
            ->withOptions([
                'connect_timeout' => $this->configuration->getConnectTimeout(),
                'timeout' => $this->configuration->getTimeout(),
            ]);
    }

}
