<?php

use Pawer\Models\Product;
use Pawer\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tops = factory(Category::class)->create([
            'name' => 'tops'
        ]);
        factory(Product::class)->create(['name' => 't-shirts','category_id' => $tops->id]);
        factory(Product::class)->create(['name' => 'sweatshirts','category_id' => $tops->id]);
        factory(Product::class)->create(['name' => 'button-ups','category_id' => $tops->id]);
        factory(Product::class)->create(['name' => 'tanks','category_id' => $tops->id]);
        factory(Product::class)->create(['name' => 'jackets','category_id' => $tops->id]);

        $headwear = factory(Category::class)->create([
            'name' => 'headwear'
        ]);
        factory(Product::class)->create(['name' => 'snapbacks','category_id' => $headwear->id]);
        factory(Product::class)->create(['name' => '5 panels','category_id' => $headwear->id]);
        factory(Product::class)->create(['name' => 'beanies','category_id' => $headwear->id]);

        $underwear = factory(Category::class)->create([
            'name' => 'underwear'
        ]);
        factory(Product::class)->create(['name' => 'boxers','category_id' => $underwear->id]);
        factory(Product::class)->create(['name' => 'socks','category_id' => $underwear->id]);
    }
}
