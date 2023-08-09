<?php

declare(strict_types=1);

namespace AlexeyShchetkin\PtSandboxClient\DataTransferObjects;

use AlexeyShchetkin\PtSandboxClient\DataTransferObjects\CheckHealth\Data;

final class CheckHealthResponse
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
     * @return CheckHealthResponse
     */
    public function setData(Data $data): CheckHealthResponse
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
     * @return CheckHealthResponse
     */
    public function setErrors(array $errors): CheckHealthResponse
    {
        $this->errors = $errors;
        return $this;
    }

}
