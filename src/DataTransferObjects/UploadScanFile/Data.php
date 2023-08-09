<?php

declare(strict_types=1);

namespace AlexeyShchetkin\PtSandboxClient\DataTransferObjects\UploadScanFile;

final class Data
{
    private ?string $fileUri = null;
    private ?int $ttl = null;

    /**
     * @return string|null
     */
    public function getFileUri(): ?string
    {
        return $this->fileUri;
    }

    /**
     * @param string|null $fileUri
     * @return Data
     */
    public function setFileUri(?string $fileUri): Data
    {
        $this->fileUri = $fileUri;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getTtl(): ?int
    {
        return $this->ttl;
    }

    /**
     * @param int|null $ttl
     * @return Data
     */
    public function setTtl(?int $ttl): Data
    {
        $this->ttl = $ttl;
        return $this;
    }
}
