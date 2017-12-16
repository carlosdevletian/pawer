<?php

use Pawer\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Article::create([
            'name' => 'RUCA SNAPBACK',
            'description' => 'A description for the ruca snapback article',
            'slug' => 'ruca-snapback-red',
            'color' => 'red',
            'code' => 'RUCAEXAMPLECODE-RED',
            'sizes' => [
                'XS','SM','MD','LG','XL'
            ],
            'images' => [
                '/images/gorra1.png',
                '/images/gorra2.png',
                '/images/gorra3.png',
                '/images/gorra4.png',
                '/images/gorra5.png',
            ]
        ]);
    }
}
