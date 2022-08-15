<?php

namespace MyBudget\UI\Actions\User;

use MyBudget\Domain\Shared\Ports\Output\ResponseDataPresenterInterface;
use MyBudget\Domain\User\UseCases\RegisterUser\DTO\RegisterUserRequest;
use MyBudget\Domain\User\UseCases\RegisterUser\Ports\Input\UseCaseInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/new-user", name: "register_user", methods: ["POST"])]
class RegisterUser
{
    public function __invoke(Request $request, UseCaseInterface $useCase, ResponseDataPresenterInterface $presenter): Response
    {
        $useCase->execute(new RegisterUserRequest(json_decode($request->getContent(), true)), $presenter);

        return new Response($presenter->getData(), $presenter->getStatusCode());
    }
}
