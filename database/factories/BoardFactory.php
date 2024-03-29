<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use App\Board;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Board::class, function (Faker $faker) {
    return [
        'name' => $faker->words(2, true),
        'user_id' => factory(User::class)->create()
    ];
});
