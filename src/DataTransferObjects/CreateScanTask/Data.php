<?php

declare(strict_types=1);

namespace AlexeyShchetkin\PtSandboxClient\DataTransferObjects\CreateScanTask;

final class Data
{
    private ?string $scanId;

    /**
     * @return string|null
     */
    public function getScanId(): ?string
    {
        return $this->scanId;
    }

    /**
     * @param string|null $scanId
     * @return Data
     */
    public function setScanId(?string $scanId): Data
    {
        $this->scanId = $scanId;
        return $this;
    }
}
