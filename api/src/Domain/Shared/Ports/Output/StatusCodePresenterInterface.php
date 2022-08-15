<?php

namespace MyBudget\Domain\Shared\Ports\Output;

interface StatusCodePresenterInterface
{
    public function present(int $statusCode): void;

    public function getStatusCode(): int;
}
