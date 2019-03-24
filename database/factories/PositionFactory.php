<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Model\Position::class, function (Faker $faker) {
    $name = $faker->jobTitle;
    $now = now();
    return [
        'name' => $name,
        'slug' => Str::slug($name) . random_int(1, 99),
        'icon_name' => 'account_box', //worker
        'created_at' => $now,
        'updated_at' => $now,
    ];
});
