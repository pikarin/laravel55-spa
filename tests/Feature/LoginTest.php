<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

   /** @test */
   public function login_api_fails_if_email_or_password_are_empty()
   {
        $this->json('POST', 'api/login')
             ->assertStatus(422)
             ->assertJson([
                'errors' => [
                    'email'    => ['The email field is required.'],
                    'password' => ['The password field is required.'],
                ]
             ]);
   }

   /** @test */
   public function user_can_login_successfully_through_login_api()
   {
        $user = factory(User::class)->create([
            'password' => bcrypt('secret'),
        ]);

        $payload = ['email' => $user->email, 'password' => 'secret'];

        $this->json('POST', 'api/login', $payload)
             ->assertStatus(200)
             ->assertJsonStructure([
                'data' => [
                    'id', 'name', 'email', 'api_token',
                ],
             ]);
   }

   /** @test */
   public function login_api_fails_if_email_or_password_are_invalid()
   {
       $user = factory(User::class)->create([
            'email' => 'test@user.com',
            'password' => bcrypt('secret'),
        ]);

        $payload = ['email' => 'another@email.com', 'password' => 'diffpassword'];

        $this->json('POST', 'api/login', $payload)
             ->assertStatus(422)
             ->assertJson([
                'errors' => [
                    'email' => ['These credentials do not match our records.'],
                ]
             ]);
   }
}
