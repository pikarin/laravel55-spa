<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_logged_out_properly()
    {
        $user = factory(User::class)->create(['email' => 'user@test.com']);
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('GET', 'api/user', [], $headers)->assertStatus(200);
        $this->json('POST', 'api/logout', [], $headers)->assertStatus(200);

        $this->assertEquals(null, $user->fresh()->api_token);
    }

    /** @test */
    public function user_cannot_access_protected_endpoint_if_already_logged_out()
    {
        $user = factory(User::class)->create(['email' => 'user@test.com']);
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $user->api_token = null;
        $user->save();

        $this->json('get', '/api/user', [], $headers)->assertStatus(401);
    }
}
