<?php

namespace MyBudget\Domain\User\UseCases\RegisterUser;

use MyBudget\Domain\Entity\User\Account;
use MyBudget\Domain\Exceptions\Http\InvalidPayloadException;
use MyBudget\Domain\Exceptions\Http\UserAlreadyExistException;
use MyBudget\Domain\Shared\Authentication\SecurityAuthInterface;
use MyBudget\Domain\Shared\Database\Ports\Output\CommonDatabaseActionInterface;
use MyBudget\Domain\Shared\Database\Ports\Output\User\AccountDALInterface;
use MyBudget\Domain\Shared\Ports\Output\DataValidationInterface;
use MyBudget\Domain\Shared\Ports\Output\ResponseDataPresenterInterface;
use MyBudget\Domain\User\UseCases\RegisterUser\DTO\RegisterUserRequest;
use MyBudget\Domain\User\UseCases\RegisterUser\Ports\Input\UseCaseInterface;

class UseCase implements UseCaseInterface
{
    public function __construct(
        private DataValidationInterface $dataValidation,
        private AccountDALInterface $accountDAL,
        private SecurityAuthInterface $securityAuth,
        private CommonDatabaseActionInterface $databaseAction
    ) {
    }

    public function execute(RegisterUserRequest $request, ResponseDataPresenterInterface $presenter): void
    {
        $this->validatePayload($request);
        $user = $this->accountDAL->findByEmail($request->getEmail());
        if ($user instanceof Account) {
            throw new UserAlreadyExistException("Cet utilisateur est déjà existant.");
        }
        $user = Account::createUser($request->getFirstname(), $request->getLastname(), $request->getEmail());
        $passwordHash = $this->securityAuth->hashPassword($user, $request->getPassword());
        $user->definePassword($passwordHash);

        $this->databaseAction->save($user, true);

        $tokenUsers = $this->securityAuth->logUser($user);
        $presenter->present(201, [], $tokenUsers);
    }

    private function validatePayload(RegisterUserRequest $request): void
    {
        $errors = $this->dataValidation->validate($request);
        if (is_array($errors)) {
            throw new InvalidPayloadException($errors);
        }
    }
}
