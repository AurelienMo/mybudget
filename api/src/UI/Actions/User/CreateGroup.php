<?php

namespace MyBudget\UI\Actions\User;

use MyBudget\Domain\Shared\Ports\Output\StatusCodePresenterInterface;
use MyBudget\Domain\User\UseCases\CreateGroup\DTO\CreateGroupRequest;
use MyBudget\Domain\User\UseCases\CreateGroup\Ports\Input\UseCaseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/user-group", methods: "POST")]
class CreateGroup
{
    public function __invoke(Request $request, UseCaseInterface $useCase, StatusCodePresenterInterface $presenter): JsonResponse
    {
        $useCase->execute(new CreateGroupRequest(json_decode($request->getContent(), true)), $presenter);

        return new JsonResponse(null, $presenter->getStatusCode());
    }
}
