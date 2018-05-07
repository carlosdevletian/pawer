<?php

use Pawer\Models\User;
use Pawer\Models\Article;
use Pawer\Models\Product;
use Pawer\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        tap(factory(Category::class)->create(['name' => 'tops']), function($tops) {
            tap(factory(Product::class)->create(['name' => 't-shirts','category_id' => $tops->id]), function($shirts) {
                factory(Article::class)->create(['name' => 'Coy','product_id' => $shirts->id]);
                factory(Article::class)->create(['name' => 'Kobi','product_id' => $shirts->id]);
            });
            factory(Product::class)->create(['name' => 'sweatshirts','category_id' => $tops->id]);
            factory(Product::class)->create(['name' => 'button-ups','category_id' => $tops->id]);
            factory(Product::class)->create(['name' => 'tanks','category_id' => $tops->id]);
            factory(Product::class)->create(['name' => 'jackets','category_id' => $tops->id]);
        });

        tap(factory(Category::class)->create(['name' => 'head-wear']), function($headwear) {
            tap(factory(Product::class)->create(['name' => 'snapbacks','category_id' => $headwear->id]), function($snapbacks) {
                $this->createSnapbacks($snapbacks->id);
            });
            factory(Product::class)->create(['name' => '5 panels','category_id' => $headwear->id]);
            factory(Product::class)->create(['name' => 'beanies','category_id' => $headwear->id]);
        });

        tap(factory(Category::class)->create(['name' => 'under-wear']), function($underwear) {
            factory(Product::class)->create(['name' => 'boxers','category_id' => $underwear->id]);
            factory(Product::class)->create(['name' => 'socks','category_id' => $underwear->id]);
        });
    }

    public function createSnapbacks($id)
    {
        factory(Article::class, 5)->create(['product_id' => $id]);

        Article::create([
            'product_id' => $id,
            'name' => 'RUCA SNAPBACK',
            'description' => 'A description for the ruca snapback article',
            'color' => 'red',
            'color_name' => 'Crimson Red',
            'code' => 'RUCAEXAMPLECODE-RED',
            'main_image_path' => '/images/gorra1.png',
            'secondary_images' => [
                '/images/gorra2.png',
                '/images/gorra3.png',
                '/images/gorra4.png',
                '/images/gorra5.png',
            ]
        ]);

        Article::create([
            'product_id' => $id,
            'name' => 'RUCA SNAPBACK',
            'description' => 'A description for the ruca snapback article',
            'color' => 'green',
            'color_name' => 'Military',
            'code' => 'RUCAEXAMPLECODE-GREEN',
            'main_image_path' => '/images/gorra3.png',
            'secondary_images' => [
                '/images/gorra4.png',
                '/images/gorra5.png',
            ]
        ]);

        Article::create([
            'product_id' => $id,
            'name' => 'RUCA SNAPBACK',
            'description' => 'A description for the ruca snapback article',
            'color' => 'blue',
            'color_name' => 'Navy Blue',
            'code' => 'RUCAEXAMPLECODE-BLUE',
            'main_image_path' => '/images/gorra4.png',
            'secondary_images' => [
                '/images/gorra5.png',
                '/images/gorra2.png',
            ]
        ]);
    }
}
