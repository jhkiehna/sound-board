<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SignOutUserTest extends TestCase
{
    use RefreshDatabase;

    public function testAUserCanSignOut()
    {
        $user = factory(User::class)->create();

        $response = $this->withHeaders([
            'Authorization' => "Bearer $user->api_token"
        ])->json('POST', '/auth/sign-out');

        $user->refresh();

        $response->assertStatus(200);
        $this->assertEquals($user->api_token, null);
    }

    public function testAUserCantSignOutWithIncorrectApiToken()
    {
        $response = $this->withHeaders([
            'Authorization' => "Bearer wrongToken"
        ])->json('POST', '/auth/sign-out');

        $response->assertStatus(401);
    }
}
