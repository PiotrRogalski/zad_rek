<?php

use App\Enum\Permissions;
use Faker\Generator as Faker;

$factory->define(App\Model\Permission::class, function (Faker $faker) {
    $name = Permissions::trans(Permissions::EMPLOYEE);
    $now = now();
    return [
        'name' => $name,
        'slug' => \Illuminate\Support\Str::slug($name),
        'created_at' => $now,
        'updated_at' => $now,
    ];
});
