<?php

use Faker\Generator as Faker;

$factory->define(Pawer\Models\EmailSubscription::class, function (Faker $faker) {
    return [
        'email' => $faker->email
    ];
});
