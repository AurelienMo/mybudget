<?php

namespace MyBudget\Domain\User\UseCases\CreateGroup\Ports\Input;

use MyBudget\Domain\Shared\Ports\Output\StatusCodePresenterInterface;
use MyBudget\Domain\User\UseCases\CreateGroup\DTO\CreateGroupRequest;

interface UseCaseInterface
{
    public function execute(CreateGroupRequest $request, StatusCodePresenterInterface $presenter): void;
}
