<?php

namespace MyBudget\Tests\UI\Actions\User;

use MyBudget\Tests\AbstractWebTestCase;

class RegisterUserTest extends AbstractWebTestCase
{
    private const URI_TO_CALL = "/api/new-user";
    public function testFailedWithNoDataProvide()
    {
        $response = $this->postRequest(
            self::URI_TO_CALL,
            [
                "email" => "",
                "password" => "",
                "firstname" => "",
                "lastname" => ""
            ]
        );

        $data = json_decode($response->getContent(), true);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("L'adresse email est requise.", $data['email']);
        $this->assertEquals("Le mot de passe doit contenir 8 caractères minimum.", $data['password']);
        $this->assertEquals("Le prénom est requis.", $data['firstname']);
        $this->assertEquals("Le nom est requis.", $data['lastname']);
    }

    public function testFailedWithAlreadyExistUser()
    {
        $response = $this->postRequest(
            self::URI_TO_CALL,
            [
                "email" => "john@doe.com",
                "password" => "12345678",
                "firstname" => "John",
                "lastname" => "Doe"
            ]
        );
        $data = json_decode($response->getContent(), true);
        $this->assertEquals(409, $response->getStatusCode());
        $this->assertEquals("Cet utilisateur est déjà existant.", $data["message"]);
    }

    public function testSuccessfulRegistration()
    {
        $response = $this->postRequest(
            self::URI_TO_CALL,
            [
                "email" => "jane@doe.com",
                "password" => "12345678",
                "firstname" => "Jane",
                "lastname" => "Doe"
            ]
        );
        $data = json_decode($response->getContent(), true);
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertArrayHasKey('token', $data);
        $this->assertArrayHasKey('refresh_token', $data);
    }
}
