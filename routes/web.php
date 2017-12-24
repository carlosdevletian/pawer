<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::view('/about', 'about')->name('about');

Route::get('/product/{article}/all-models', 'ArticleController@index')->name('articles.index');
Route::get('/articles/{article}', 'ArticleController@show')->name('articles.show');

Route::get('/catalog', 'CategoryController@index')->name('catalog');

Route::get('/category/{category}/all-products', 'ProductController@index')->name('products.index');

Route::view('/lookbook', 'lookbook')->name('lookbook');

Route::group(['middleware' => 'auth'], function() {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/categories/create', 'CategoryController@create')->name('categories.create');
    Route::post('/categories', 'CategoryController@store')->name('categories.store');
    Route::get('/categories/{category}/edit', 'CategoryController@edit')->name('categories.edit');
    Route::patch('/category/{category}', 'CategoryController@update')->name('categories.update');

    Route::get('/products/create', 'ProductController@create')->name('products.create');
    Route::post('/products', 'ProductController@store')->name('products.store');
    Route::get('/products/{product}/edit', 'ProductController@edit')->name('products.edit');
    Route::patch('/products/{product}', 'ProductController@update')->name('products.update');
});