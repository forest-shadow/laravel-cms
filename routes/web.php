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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/post/{id}/{name}/{author}', 'PostController@show_post');

Route::get('/contact', function() {
    $people = ['Edwin', 'Jose', 'James', 'Peter', 'Maria'];

   return view('contact', compact('people'));
});