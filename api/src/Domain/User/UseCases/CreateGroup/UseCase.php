<?php

namespace MyBudget\Domain\User\UseCases\CreateGroup;

use MyBudget\Domain\Entity\User\UserGroup;
use MyBudget\Domain\Exceptions\HttpMyBudgetException;
use MyBudget\Domain\Shared\Authentication\SecurityAuthInterface;
use MyBudget\Domain\Shared\Database\Ports\Output\CommonDatabaseActionInterface;
use MyBudget\Domain\Shared\Database\Ports\Output\User\UserGroupDALInterface;
use MyBudget\Domain\Shared\Ports\Output\StatusCodePresenterInterface;
use MyBudget\Domain\User\UseCases\CreateGroup\DTO\CreateGroupRequest;
use MyBudget\Domain\User\UseCases\CreateGroup\Ports\Input\UseCaseInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UseCase implements UseCaseInterface
{
    public function __construct(
        private UserGroupDALInterface $userGroupDAL,
        private SecurityAuthInterface $secureAuth,
        private CommonDatabaseActionInterface $databaseAction,
        private ValidatorInterface $validator
    ) {}

    public function execute(CreateGroupRequest $request, StatusCodePresenterInterface $presenter): void
    {
        $currentUser = $this->secureAuth->getCurrentUser();
        if ($currentUser->getUserGroup()) {
            throw new HttpMyBudgetException(['message' => 'Vous êtes déjà associé à un groupe.'], 400);
        }
        $this->validatePayload($request);

        $userGroup = $this->userGroupDAL->findByCode($request->getCode());
        if ($userGroup) {
            throw new HttpMyBudgetException(['message' => "Ce groupe est déjà existant, merci d'utiliser un autre code."], 409);
        }
        $userGroup = UserGroup::createFromAPI($request, $this->secureAuth->encodePassword($request->getPassword()), $currentUser);
        $this->databaseAction->save($userGroup, true);
        $presenter->present(Response::HTTP_CREATED);
    }

    private function validatePayload(CreateGroupRequest $request): void
    {
        $constraintViolations = $this->validator->validate($request);
        if ($constraintViolations->count() > 0) {
            $errors = [];
            foreach ($constraintViolations as $violation) {
                $errors[$violation->getPropertyPath()] = $violation->getMessage();
            }
            throw new HttpMyBudgetException($errors, 400);
        }
    }
}
