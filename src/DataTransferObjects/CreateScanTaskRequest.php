<?php

declare(strict_types=1);

namespace AlexeyShchetkin\PtSandboxClient\DataTransferObjects;

use DragonCode\Contracts\Support\Arrayable;

final class CreateScanTaskRequest implements Arrayable
{
    private string $fileUri;
    private ?string $fileName = 'Noname';
    private ?bool $asyncResult = false;
    private ?bool $shortResult = true;
    private array $options = [];

    public function __construct(string $fileUri)
    {
        $this->fileUri = $fileUri;
    }

    public function toArray(): array
    {
        return [
            'file_uri' => $this->fileUri,
            'file_name' => $this->fileName,
            'async_result' => $this->asyncResult,
            'short_result' => $this->shortResult,
            'options' => $this->options,
        ];
    }

    /**
     * @return string
     */
    public function getFileUri(): string
    {
        return $this->fileUri;
    }

    /**
     * @param string $fileUri
     * @return CreateScanTaskRequest
     */
    public function setFileUri(string $fileUri): CreateScanTaskRequest
    {
        $this->fileUri = $fileUri;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    /**
     * @param string|null $fileName
     * @return CreateScanTaskRequest
     */
    public function setFileName(?string $fileName): CreateScanTaskRequest
    {
        $this->fileName = $fileName;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getAsyncResult(): ?bool
    {
        return $this->asyncResult;
    }

    /**
     * @param bool|null $asyncResult
     * @return CreateScanTaskRequest
     */
    public function setAsyncResult(?bool $asyncResult): CreateScanTaskRequest
    {
        $this->asyncResult = $asyncResult;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getShortResult(): ?bool
    {
        return $this->shortResult;
    }

    /**
     * @param bool|null $shortResult
     * @return CreateScanTaskRequest
     */
    public function setShortResult(?bool $shortResult): CreateScanTaskRequest
    {
        $this->shortResult = $shortResult;
        return $this;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     * @return CreateScanTaskRequest
     */
    public function setOptions(array $options): CreateScanTaskRequest
    {
        $this->options = $options;
        return $this;
    }
}
