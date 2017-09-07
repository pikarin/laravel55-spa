<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_successfully_register_using_register_api()
    {
        $payload = [
            'name' => 'Aditia',
            'email' => 'aditia@app.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ];

        $this->json('POST', 'api/register', $payload)
             ->assertStatus(201)
             ->assertJsonStructure([
                'data' => [
                    'id', 'name', 'email', 'api_token',
                ],
             ]);
    }

    /** @test */
    public function registration_fails_if_name_email_or_password_are_empty()
    {
        $this->json('POST', 'api/register')
             ->assertStatus(422)
             ->assertJson([
                'errors' => [
                    'name' => ['The name field is required.'],
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.'],
                ]
             ]);
    }
}
