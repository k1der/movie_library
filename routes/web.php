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

// Those route should be in api.php
Route::get('movie', 'MovieController@list')->name('movie.list');
Route::get('movie/{movie}', 'MovieController@show')->name('movie.show'); // this route should be a post to movie
Route::get('person', 'PersonController@list')->name('person.list');
Route::get('person/{person}', 'PersonController@show')->name('person.show');
