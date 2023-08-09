<?php

declare(strict_types=1);

namespace AlexeyShchetkin\PtSandboxClient\DataTransferObjects;

use AlexeyShchetkin\PtSandboxClient\DataTransferObjects\UploadScanFile\Data;

final class UploadScanFileResponse
{

    private Data $data;
    /**
     * @var array<Error>
     */
    private array $errors;

    /**
     * @return Data
     */
    public function getData(): Data
    {
        return $this->data;
    }

    /**
     * @param Data $data
     * @return UploadScanFileResponse
     */
    public function setData(Data $data): UploadScanFileResponse
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     * @return UploadScanFileResponse
     */
    public function setErrors(array $errors): UploadScanFileResponse
    {
        $this->errors = $errors;
        return $this;
    }
}
