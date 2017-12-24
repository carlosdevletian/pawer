<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('delete-images', function () {
    Storage::disk('public')->deleteDirectory('categories');
    Storage::disk('public')->deleteDirectory('products');
})->describe('Delete all user uploaded images');
