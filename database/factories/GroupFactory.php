<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Model\Group::class, function (Faker $faker) {
    $name = $faker->name;
    $now = now();
    return [
        'name' => $name,
        'slug' => Str::slug($name),
        'created_at' => $now,
        'updated_at' => $now,
    ];
});
