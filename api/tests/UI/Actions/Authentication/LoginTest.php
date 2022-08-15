<?php

namespace MyBudget\Tests\UI\Actions\Authentication;

use MyBudget\Tests\AbstractWebTestCase;

class LoginTest extends AbstractWebTestCase
{
    public function testFailureLogin()
    {
        $response = $this->postRequest(
            "/api/login_check",
            [
                'username' => 'test',
                'password' => 'test',
            ]
        );

        $this->assertEquals(401, $response->getStatusCode());
    }

    public function testSuccessAuth()
    {
        $response = $this->postRequest(
            "/api/login_check",
            [
                'username' => 'john@doe.com',
                'password' => '12345678',
            ]
        );

        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey("token", $data);
        $this->assertArrayHasKey("refresh_token", $data);
    }
}
