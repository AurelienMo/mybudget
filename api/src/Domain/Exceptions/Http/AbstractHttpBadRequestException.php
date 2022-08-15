<?php

namespace MyBudget\Domain\Exceptions\Http;

use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractHttpBadRequestException extends \Exception
{
    private int $statusCode = Response::HTTP_BAD_REQUEST;

    private array $errors;

    public function __construct(array $errors)
    {
        $this->errors = $errors;
        parent::__construct('', 0, null);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
