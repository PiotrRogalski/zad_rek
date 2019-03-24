<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Model\Task::class, function (Faker $faker) {
    $title = $faker->paragraph . '?';
    $now = now();
    return [
        'title' => $title,
        'slug' => Str::slug($title) . random_int(1, 99),
        'body' => $faker->text(1200),
        'owner_id' => function () {
            return factory(\App\User::class)->create()->id;
        },
        'created_at' => $now,
        'updated_at' => $now,
    ];
});
