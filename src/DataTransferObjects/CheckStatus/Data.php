<?php

declare(strict_types=1);

namespace AlexeyShchetkin\PtSandboxClient\DataTransferObjects\CheckStatus;

final class Data
{
    private string $scanId = '';

    private ?Result $result = null;

    /**
     * @return string
     */
    public function getScanId(): string
    {
        return $this->scanId;
    }

    /**
     * @param string $scanId
     * @return Data
     */
    public function setScanId(string $scanId): Data
    {
        $this->scanId = $scanId;
        return $this;
    }

    /**
     * @return Result|null
     */
    public function getResult(): ?Result
    {
        return $this->result;
    }

    /**
     * @param Result|null $result
     * @return Data
     */
    public function setResult(?Result $result): Data
    {
        $this->result = $result;
        return $this;
    }
}
