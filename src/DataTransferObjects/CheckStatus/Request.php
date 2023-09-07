<?php

declare(strict_types=1);

namespace AlexeyShchetkin\PtSandboxClient\DataTransferObjects\CheckStatus;

use Illuminate\Contracts\Support\Arrayable;

final class Request implements Arrayable
{
    private string $scanId;

    /**
     * @param string $scanId
     */
    public function __construct(string $scanId)
    {
        $this->scanId = $scanId;
    }

    public function toArray(): array
    {
        return [
            'scan_id' => $this->scanId
        ];
    }
}
