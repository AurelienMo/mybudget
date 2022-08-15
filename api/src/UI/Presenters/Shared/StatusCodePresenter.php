<?php

namespace MyBudget\UI\Presenters\Shared;

use MyBudget\Domain\Shared\Ports\Output\StatusCodePresenterInterface;

class StatusCodePresenter implements StatusCodePresenterInterface
{
    private int $statusCode;

    public function present(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
