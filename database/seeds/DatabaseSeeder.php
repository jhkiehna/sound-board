<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'name' => env('INITIAL_USERNAME', 'tester'),
            'password' => Hash::make(env('INITIAL_PASSWORD', 'password')),
            'email' => null,
        ]);
    }
}
