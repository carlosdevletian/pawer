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

        Article::create([
            'name' => 'RUCA SNAPBACK',
            'description' => 'A description for the ruca snapback article',
            'color' => 'green',
            'code' => 'RUCAEXAMPLECODE-GREEN',
            'sizes' => [
                'XS','SM','MD'
            ],
            'images' => [
                '/images/gorra4.png',
                '/images/gorra5.png',
            ]
        ]);

        Article::create([
            'name' => 'RUCA SNAPBACK',
            'description' => 'A description for the ruca snapback article',
            'color' => 'blue',
            'code' => 'RUCAEXAMPLECODE-BLUE',
            'sizes' => [
                'ONE-SIZE'
            ],
            'images' => [
                '/images/gorra5.png',
                '/images/gorra2.png',
            ]
        ]);
    }
}
