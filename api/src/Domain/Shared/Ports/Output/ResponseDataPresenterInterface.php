<?php

namespace MyBudget\Domain\Shared\Ports\Output;

interface ResponseDataPresenterInterface
{
    public function present(
        int $statusCode,
        array $headers,
        array|object|null $data,
        bool $needSerialization = false,
        array $groupSerialization = []
    ): void;

    public function getStatusCode(): int;

    public function getHeaders(): array;

    public function getData(): string|null;
}
