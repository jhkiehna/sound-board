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
          'name' => 'testy',
          'password' => 'password',
          'password_confirmation' => 'password',
        ]);

        $user = User::where('name', 'testy')->first();

        $response->assertStatus(201);
        $response->assertJsonFragment(['name' => 'testy']);
        $this->assertTrue($user->api_token != null);
    }

    public function testAUserCantRegisterWithBadData()
    {
      factory(User::class)->create([
        'name' => 'testy',
        'email' => 'testy@test.com',
        'password' => 'testPassword'
      ]);
      $badPasswordResponse = $this->json('POST', '/auth/register', [
        'name' => 'new user',
        'email' => 'newUser@test.com',
        'password' => 'password',
        'password_confirmation' => 'password_doesnt_match',
      ]);
      $nameExistsResponse = $this->json('POST', '/auth/register', [
        'name' => 'testy',
        'password' => 'password',
        'password_confirmation' => 'password',
      ]);
      $badEmailResponse = $this->json('POST', '/auth/register', [
        'name' => 'new user 3',
        'email' => 'newUser',
        'password' => 'password',
        'password_confirmation' => 'password',
      ]);
      $emailExistsResponse = $this->json('POST', '/auth/register', [
        'name' => 'new user 4',
        'email' => 'testy@test.com',
        'password' => 'password',
        'password_confirmation' => 'password',
      ]);


      $badPasswordResponse->assertStatus(422);
      $nameExistsResponse->assertStatus(422);
      $badEmailResponse->assertStatus(422);
      $emailExistsResponse->assertStatus(422);
    }
}
