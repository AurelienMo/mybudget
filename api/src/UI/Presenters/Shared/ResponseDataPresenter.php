<?php

namespace MyBudget\UI\Presenters\Shared;

use MyBudget\Domain\Shared\Ports\Output\ResponseDataPresenterInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ResponseDataPresenter implements ResponseDataPresenterInterface
{
    private int $statusCode;

    private array $headers;

    private array|object|null $data;

    private bool $needSerialization;

    private array $groupSerialization;

    public function __construct(private SerializerInterface $serializer) {}

    public function present(
        int $statusCode,
        array $headers,
        object|array|null $data,
        bool $needSerialization = false,
        array $groupSerialization = []
    ): void {
        $this->statusCode = $statusCode;
        $this->headers = $headers;
        $this->data = $data;
        $this->needSerialization = $needSerialization;
        $this->groupSerialization = $groupSerialization;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getData(): string|null
    {
        if (is_null($this->data)) {
            return null;
        }

        if ($this->needSerialization) {
            return $this->serializer->serialize($this->data, 'json', ['groups' => $this->groupSerialization]);
        } else {
            return json_encode($this->data);
        }
    }
}
