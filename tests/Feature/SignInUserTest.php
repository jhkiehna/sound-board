<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SignInUserTest extends TestCase
{
    use RefreshDatabase;

    public function testAUserCanSignIn()
    {
        $user = factory(User::class)->create();
        $user->password = Hash::make('password');
        $user->save();

        $response = $this->json('POST', '/auth/sign-in', [
          'name' => $user->name,
          'password' => 'password'
        ]);
        $user->refresh();

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'name' => $user->name,
            'api_token' => $user->api_token
        ]);
    }

    public function testAUserCantSignInWithWrongPassword()
    {
        $user = factory(User::class)->create();

        $response = $this->json('POST', '/auth/sign-in', [
          'name' => $user->name,
          'password' => 'wrong_password'
        ]);

        $response->assertStatus(401);
        $response->assertJsonFragment(['message' => 'Invalid email or password']);
    }
}
