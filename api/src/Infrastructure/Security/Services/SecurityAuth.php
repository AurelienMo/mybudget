<?php

namespace MyBudget\Infrastructure\Security\Services;

use Gesdinet\JWTRefreshTokenBundle\Generator\RefreshTokenGeneratorInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use MyBudget\Domain\Entity\User\Account;
use MyBudget\Domain\Shared\Authentication\SecurityAuthInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Security;

class SecurityAuth implements SecurityAuthInterface
{
    public function __construct(
        private Security $security,
        private UserPasswordHasherInterface $passwordHasher,
        private JWTTokenManagerInterface $tokenManager,
        private RefreshTokenGeneratorInterface $refreshTokenManager
    ) {}

    public function getCurrentUser(): Account
    {
        return $this->security->getUser();
    }

    public function encodePassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function hashPassword(Account $account, string $password): string
    {
        return $this->passwordHasher->hashPassword($account, $password);
    }

    public function logUser(Account $user): array
    {
        $token = $this->tokenManager->create($user);
        $refreshToken = $this->refreshTokenManager->createForUserWithTtl($user, 2592000);

        return [
            'token' => $token,
            'refresh_token' => $refreshToken->getRefreshToken()
        ];
    }
}
