<?php

declare(strict_types=1);

namespace AlexeyShchetkin\PtSandboxClient\DataTransferObjects\CheckStatus;

use AlexeyShchetkin\PtSandboxClient\DataTransferObjects\Error;

final class Response
{

    private Data $data;
    /**
     * @var array<Error>
     */
    private array $errors;

    public function isClean(): bool
    {
        return $this->getData()
        && $this->getData()->getResult()
        && 'CLEAN' === $this->getData()->getResult()->getVerdict();
    }

    public function isUnwanted(): bool
    {
        return $this->getData()
            && $this->getData()->getResult()
            && 'UNWANTED' === $this->getData()->getResult()->getVerdict();
    }

    public function isDangerous(): bool
    {
        return $this->getData()
            && $this->getData()->getResult()
            && 'DANGEROUS' === $this->getData()->getResult()->getVerdict();
    }

    /**
     * @return Data
     */
    public function getData(): Data
    {
        return $this->data;
    }

    /**
     * @param Data $data
     * @return self
     */
    public function setData(Data $data): self
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
     * @return self
     */
    public function setErrors(array $errors): self
    {
        $this->errors = $errors;
        return $this;
    }
}
