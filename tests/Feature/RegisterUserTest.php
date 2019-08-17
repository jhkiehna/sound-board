<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase;

    public function testAUserCanCreateAnAccount()
    {
        $response = $this->json('POST', '/auth/register', [
          'email' => 'newUser@test.com',
          'password' => 'password',
          'password_confirmation' => 'password',
        ]);

        $user = User::where('email', 'newUser@test.com')->first();

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'email' => 'newUser@test.com'
        ]);
        $this->assertTrue($user->api_token != null);
    }

    public function testAUserCantRegisterWithBadData()
    {
      factory(User::class)->create([
        'email' => 'userExists@test.com',
        'password' => 'testPassword'
      ]);
      $badPasswordResponse = $this->json('POST', '/auth/register', [
        'email' => 'newUser@test.com',
        'password' => 'password',
        'password_confirmation' => 'password_doesnt_match',
      ]);
      $badEmailResponse = $this->json('POST', '/auth/register', [
        'email' => 'newUser',
        'password' => 'password',
        'password_confirmation' => 'password',
      ]);
      $emailExistsResponse = $this->json('POST', '/auth/register', [
        'email' => 'userExists@test.com',
        'password' => 'password',
        'password_confirmation' => 'password',
      ]);


      $badPasswordResponse->assertStatus(422);
      $badEmailResponse->assertStatus(422);
      $emailExistsResponse->assertStatus(422);
    }
}
