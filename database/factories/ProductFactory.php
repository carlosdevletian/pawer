<?php

use Faker\Generator as Faker;

$factory->define(Pawer\Models\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'category_id' => function() {
            return factory(Pawer\Models\Category::class)->create()->id;
        }
    ];
});
