<?php

namespace MyBudget\Tests\UI\Actions\Authentication;

use MyBudget\Tests\AbstractWebTestCase;

class RefreshTokenTest extends AbstractWebTestCase
{
    public function testFailedRefresh()
    {
        $response = $this->postRequest(
            "/api/token/refresh",
            ["refresh_token" => "test"]
        );
        $this->assertEquals(401, $response->getStatusCode());
    }

    public function testSuccessRefresh()
    {
        $responseLogin = $this->postRequest(
            "/api/login_check",
            [
                'username' => 'john@doe.com',
                'password' => '12345678',
            ]
        );
        $data = json_decode($responseLogin->getContent(), true);
        $response = $this->postRequest(
            "/api/token/refresh",
            ["refresh_token" => $data["refresh_token"]]
        );
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey("token", $data);
        $this->assertArrayHasKey("refresh_token", $data);
    }
}
