<?php

use Faker\Generator as Faker;

$factory->define(Pawer\Models\Size::class, function (Faker $faker) {
    return [
        'name' => $faker->name
    ];
});
