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
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/', 'HomeController@index')->name('home');
Route::view('/about', 'about')->name('about');

Route::get('/product/{article}/all-models', 'ArticleController@index')->name('articles.index');
Route::get('/models/{article}', 'ArticleController@show')->name('articles.show');

Route::get('/catalog', 'CategoryController@index')->name('catalog');

Route::get('/category/{category}/all-products', 'ProductController@index')->name('products.index');

Route::post('email-subscriptions', 'EmailSubscriptionController@store')->name('email-subscriptions.store');

Route::group(['middleware' => 'auth', 'namespace' => 'Admin'], function() {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::get('/categories-list', 'CategoryController@index')->name('admin.categories.index');
    Route::get('/categories/create', 'CategoryController@create')->name('categories.create');
    Route::post('/categories', 'CategoryController@store')->name('categories.store');
    Route::get('/categories/{category}/edit', 'CategoryController@edit')->name('categories.edit');
    Route::patch('/category/{category}', 'CategoryController@update')->name('categories.update');
    Route::delete('/category/{category}', 'CategoryController@destroy')->name('categories.destroy');

    Route::get('/products-list', 'ProductController@index')->name('admin.products.index');
    Route::get('/products/create', 'ProductController@create')->name('products.create');
    Route::post('/products', 'ProductController@store')->name('products.store');
    Route::get('/products/{product}/edit', 'ProductController@edit')->name('products.edit');
    Route::patch('/products/{product}', 'ProductController@update')->name('products.update');
    Route::delete('/products/{product}', 'ProductController@destroy')->name('products.destroy');

    Route::get('/models-list', 'ArticleController@index')->name('admin.articles.index');
    Route::get('/products/{product}/models/create', 'ArticleController@create')->name('articles.create');
    Route::post('/articles', 'ArticleController@store')->name('articles.store');
    Route::get('/models/{article}/edit', 'ArticleController@edit')->name('articles.edit');
    Route::patch('/articles/{article}', 'ArticleController@update')->name('articles.update');
    Route::delete('/articles/{article}', 'ArticleController@destroy')->name('articles.destroy');

    Route::post('/featured-articles', 'FeaturedArticleController@store')->name('featured-articles.store');
    Route::delete('/featured-articles', 'FeaturedArticleController@destroy')->name('featured-articles.destroy');

    Route::patch('/home-images', 'HomeImagesController@update')->name('home-images.update');

    Route::get('/email-subscriptions', 'EmailSubscriptionController@index')->name('email-subscriptions.index');
    Route::delete('/email-subscriptions/{subscription}', 'EmailSubscriptionController@destroy')->name('email-subscriptions.destroy');

    Route::post('/users', 'UserController@store')->name('admin.users.create');
});