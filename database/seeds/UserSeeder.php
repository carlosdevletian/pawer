<?php

use Pawer\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        factory(User::class)->create(['email' => 'carlos@example.com']);
    }
}
