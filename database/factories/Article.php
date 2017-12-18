<?php

use Faker\Generator as Faker;

$factory->define(Pawer\Models\Article::class, function (Faker $faker) {
    return [
        'name' => 'RUCA SNAPBACK',
        'description' => 'A description for the ruca snapback article',
        'color' => 'red',
        'code' => 'RUCAEXAMPLECODE-RED',
        'sizes' => [
            'XS','SM','MD','LG','XL'
        ],
        'images' => [
            'example-image-1.png', 'example-image-2.png'
        ]
    ];
});
