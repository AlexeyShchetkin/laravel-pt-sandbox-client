<?php

declare(strict_types=1);

namespace AlexeyShchetkin\PtSandboxClient\DataTransferObjects;

final class Error
{
    private string $message;
    private string $type;

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return Error
     */
    public function setMessage(string $message): Error
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Error
     */
    public function setType(string $type): Error
    {
        $this->type = $type;
        return $this;
    }
}
