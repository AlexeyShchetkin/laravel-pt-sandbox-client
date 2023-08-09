<?php

declare(strict_types=1);

namespace AlexeyShchetkin\PtSandboxClient\Exceptions;

use Illuminate\Http\Client\RequestException;

class MethodNotAllowedException extends RequestException
{
}
