<?php

namespace MyBudget\Domain\User\UseCases\RegisterUser\Ports\Input;

use MyBudget\Domain\Shared\Ports\Output\ResponseDataPresenterInterface;
use MyBudget\Domain\User\UseCases\RegisterUser\DTO\RegisterUserRequest;

interface UseCaseInterface
{
    public function execute(RegisterUserRequest $request, ResponseDataPresenterInterface $presenter): void;
}
