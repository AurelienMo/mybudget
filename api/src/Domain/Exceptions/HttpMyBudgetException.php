<?php

namespace MyBudget\Domain\Exceptions;

class HttpMyBudgetException extends \Exception
{
    private array $errors;

    private int $statusCode;

    public function __construct(array $errors, int $statusCode)
    {
        $this->errors = $errors;
        $this->statusCode = $statusCode;
        parent::__construct('', 0, null);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
