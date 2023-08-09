<?php

declare(strict_types=1);

namespace AlexeyShchetkin\PtSandboxClient\DataTransferObjects;

use AlexeyShchetkin\PtSandboxClient\DataTransferObjects\CreateScanTask\Data;

final class CreateScanTaskResponse
{
    private Data $data;

    /** @var array<Error> */
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
     * @return CreateScanTaskResponse
     */
    public function setData(Data $data): CreateScanTaskResponse
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
     * @return CreateScanTaskResponse
     */
    public function setErrors(array $errors): CreateScanTaskResponse
    {
        $this->errors = $errors;
        return $this;
    }
}
