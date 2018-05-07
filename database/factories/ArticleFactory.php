<?php

use Faker\Generator as Faker;

$factory->define(Pawer\Models\Article::class, function (Faker $faker) {
    return [
        'product_id' => function() {
            return factory(Pawer\Models\Product::class)->create()->id;
        },
        'featured' => 0,
        'name' => $faker->name,
        'description' => $faker->sentence,
        'color' => $faker->colorName,
        'color_name' => $faker->colorName,
        'code' => 'EXAMPLECODE',
        'main_image_path' => 'some/path.png',
        'secondary_images' => [
            '/images/gorra1.png', '/images/gorra2.png'
        ]
    ];
});
