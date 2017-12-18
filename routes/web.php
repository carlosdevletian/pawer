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

Route::get('/articles/{article}', 'ArticleController@show')->name('articles.show');

Route::get('/catalog', 'CategoryController@index')->name('catalog');
Route::get('/category/{category}/all-products', 'ProductController@index')->name('products.index');

Route::view('/lookbook', 'lookbook')->name('lookbook');
// Route::view('/catalog', 'catalog')->name('catalog');
