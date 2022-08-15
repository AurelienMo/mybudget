<?php

namespace MyBudget\Tests;

use Doctrine\ORM\EntityManagerInterface;
use MyBudget\Domain\Entity\User\Account;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

abstract class AbstractWebTestCase extends WebTestCase
{
    protected EntityManagerInterface $entityManager;

    protected $client;

    protected function setUp(): void
    {
//        self::bootKernel();
        $this->client = static::createClient();
        $container = static::getContainer();
        $this->entityManager = $container->get(EntityManagerInterface::class);
        $user = Account::createUser("John", "Doe", "john@doe.com");
        $user->definePassword("12345678");
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    protected function getRequest(string $uri): Response
    {
        $this->client->request(
            'GET',
            $uri,
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json'
            ]
        );

        return $this->client->getResponse();
    }

    protected function postRequest(string $uri, array $data): Response
    {
        $this->client->request(
            'POST',
            $uri,
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json'
            ],
            json_encode($data)
        );

        return $this->client->getResponse();
    }
}
