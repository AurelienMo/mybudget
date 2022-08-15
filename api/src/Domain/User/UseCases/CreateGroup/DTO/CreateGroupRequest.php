<?php

namespace MyBudget\Domain\User\UseCases\CreateGroup\DTO;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateGroupRequest
{
    #[NotBlank()]
    private ?string $name;

    #[NotBlank()]
    private ?string $code;

    #[NotBlank()]
    #[Length(min: 8, minMessage: "Password must be at least 8 characters long")]
    private ?string $password;

    public function __construct(array $payload)
    {
        $this->name = $payload['name'] ?? null;
        $this->code = $payload['code'] ?? null;
        $this->password = $payload['password'] ?? null;
    }

    public function getName(): string|null
    {
        return $this->name;
    }

    public function getCode(): string|null
    {
        return $this->code;
    }

    public function getPassword(): string|null
    {
        return $this->password;
    }
}
