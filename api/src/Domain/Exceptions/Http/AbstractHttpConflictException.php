<?php

namespace MyBudget\Domain\Exceptions\Http;

use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractHttpConflictException extends \Exception
{
    private int $statusCode = Response::HTTP_CONFLICT;

    private array $data;

    public function __construct(string $message = "")
    {
        $this->data['message'] = $message;
        parent::__construct("", 0, null);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
