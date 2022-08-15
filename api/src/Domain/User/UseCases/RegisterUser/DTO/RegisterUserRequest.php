<?php

namespace MyBudget\Domain\User\UseCases\RegisterUser\DTO;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegisterUserRequest
{
    #[NotBlank(message: "L'adresse email est requise.")]
    private string|null $email;

    #[NotBlank(message: "Le mot de passe est requis.")]
    #[Length(min: 8, minMessage: "Le mot de passe doit contenir 8 caractères minimum.")]
    private string|null $password;

    #[NotBlank(message: "Le prénom est requis.")]
    private string|null $firstname;

    #[NotBlank(message: "Le nom est requis.")]
    private string|null $lastname;

    public function __construct(array $payload)
    {
        $this->email = $payload['email'] ?? null;
        $this->password = $payload['password'] ?? null;
        $this->firstname = $payload['firstname'] ?? null;
        $this->lastname = $payload['lastname'] ?? null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }
}
