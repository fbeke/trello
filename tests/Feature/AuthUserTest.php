<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthUserTest extends TestCase
{

    use DatabaseMigrations;

    private $user;


    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->seed();

        $this->user = User::find(2);
    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSuccessfulAuth()
    {
        $data = [
            'email' => $this->user->email,
            'password' => 'test',
        ];

        $response = $this->postJson(route('login'), $data);

        $this->assertTrue(strlen($response['access_token']) > 0);
    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_auth_failed()
    {
        $data = [
            'email' => 'some@email.com',
            'password' => 'test',
        ];

        $response = $this->postJson(route('login'), $data);

        $response->assertUnauthorized();
    }
}
