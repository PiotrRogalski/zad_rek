<?php

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(User::class, function (Faker $faker) {
    $firstName = $faker->firstName;
    $lastName = $faker->lastName;
    $name = $firstName . ' ' . $lastName;

    $now = now();
    return [
        'name' => $firstName,
        'surname' => $lastName,
        'slug' => Str::slug($name) . random_int(1, 99),
        'email' => $faker->unique()->safeEmail,
        'password' => 'password', // password
        'remember_token' => Str::random(10),
        'group_id' => function () {
            return \App\Model\Group::query()->inRandomOrder()->first(['id'])->id;
        },
        'position_id' => function () {
            return \App\Model\Position::query()->inRandomOrder()->first(['id'])->id;
        },
        'permission_id' => \App\Enum\Permissions::EMPLOYEE,
        'created_at' => $now,
        'updated_at' => $now,
    ];
});
