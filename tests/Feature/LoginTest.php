<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A simple login test case
     *
     * @return void
     */
    public function test_login_successfully()
    {
        $login = [
            0 => [
                "login" => "BAR_1",
                "password" => "foo-bar-baz"
            ],
            1 => [
                "login" => "FOO_1",
                "password" => "foo-bar-baz"
            ],
            2 => [
                "login" => "BAZ_1",
                "password" => "foo-bar-baz"
            ],
        ];
        $random = rand(0,2);
        $login = $login[$random];
        $response = $this->post('/api/login',$login);
        $response->assertStatus(200);
    }


      /**
     * A simple login test case
     *
     * @return void
     */
    public function test_login_failed()
    {
        $login = [
            0 => [
                "login" => "BR_1",
                "password" => "foo-bar-baz"
            ],
            1 => [
                "login" => "FO_1",
                "password" => "foo-bar-baz"
            ],
            2 => [
                "login" => "BA_1",
                "password" => "foo-bar-baz"
            ],
        ];
        $random = rand(0,2);
        $login = $login[$random];
        $response = $this->post('/api/login',$login);
        $response->assertStatus(400);
    }
}
