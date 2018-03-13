<?php

use Pawer\Models\Size;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    public function run()
    {
        factory(Size::class)->create(['name' => 'extra-small']);
        factory(Size::class)->create(['name' => 'small']);
        factory(Size::class)->create(['name' => 'medium']);
        factory(Size::class)->create(['name' => 'large']);
        factory(Size::class)->create(['name' => 'extra-large']);
        factory(Size::class)->create(['name' => 'one-size']);
    }
}
