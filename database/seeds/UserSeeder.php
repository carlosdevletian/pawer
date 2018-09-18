<?php

use Pawer\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        factory(User::class)->create(['email' => 'andy@paw3r.com', 'password' => bcrypt('andresdpawer')]);
    }
}
