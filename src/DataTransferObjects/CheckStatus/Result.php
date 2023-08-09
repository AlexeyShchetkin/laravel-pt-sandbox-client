<?php

declare(strict_types=1);

namespace AlexeyShchetkin\PtSandboxClient\DataTransferObjects\CheckStatus;

use AlexeyShchetkin\PtSandboxClient\DataTransferObjects\Error;

final class Result
{
    private ?float $duration = null;
    /** @var array<Error> */
    private array $errors = [];
    private string $scanState = '';
    private string $threat = '';
    private string $verdict = '';

    /**
     * @return float|null
     */
    public function getDuration(): ?float
    {
        return $this->duration;
    }

    /**
     * @param float|null $duration
     * @return Result
     */
    public function setDuration(?float $duration): Result
    {
        $this->duration = $duration;
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
     * @return Result
     */
    public function setErrors(array $errors): Result
    {
        $this->errors = $errors;
        return $this;
    }

    /**
     * @return string
     */
    public function getScanState(): string
    {
        return $this->scanState;
    }

    /**
     * @param string $scanState
     * @return Result
     */
    public function setScanState(string $scanState): Result
    {
        $this->scanState = $scanState;
        return $this;
    }

    /**
     * @return string
     */
    public function getThreat(): string
    {
        return $this->threat;
    }

    /**
     * @param string $threat
     * @return Result
     */
    public function setThreat(string $threat): Result
    {
        $this->threat = $threat;
        return $this;
    }

    /**
     * @return string
     */
    public function getVerdict(): string
    {
        return $this->verdict;
    }

    /**
     * @param string $verdict
     * @return Result
     */
    public function setVerdict(string $verdict): Result
    {
        $this->verdict = $verdict;
        return $this;
    }
}
