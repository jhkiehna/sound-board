<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
  use RefreshDatabase;

    public function testANewlyCreatedUserHasEmailPasswordAndApiToken()
    {
        $user = factory(User::class)->create([
          'name' => 'testy',
          'password' => Hash::make('testPassword')
        ]);

        $this->assertEquals($user->name, 'testy');
        $this->assertTrue(Hash::check('testPassword', $user->password));
        $this->assertTrue($user->api_token != null);
    }
}
