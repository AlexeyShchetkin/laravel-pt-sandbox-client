<?php

declare(strict_types=1);

namespace AlexeyShchetkin\PtSandboxClient\DataTransferObjects\CheckHealth;

final class Data
{
    private ?string $status = null;

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     * @return Data
     */
    public function setStatus(?string $status): Data
    {
        $this->status = $status;
        return $this;
    }
}
