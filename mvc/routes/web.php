<?php

use App\Routes\Route;
use App\Controllers\HomeController;
use App\Controllers\MembreController;
use App\Controllers\AuthController;
use App\Controllers\TimbreController;

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

Route::get('/membre/create', "MembreController@create");
Route::post('/membre/create', "MembreController@store");
Route::get('/membre/show', "MembreController@show");
Route::get('/membre/edit', 'MembreController@edit');
Route::post('/membre/edit', 'MembreController@update');
Route::post('/membre/delete', 'MembreController@delete');

Route::get('/login', 'AuthController@create');
Route::post('/login', 'AuthController@store');
Route::get('/logout', 'AuthController@delete');

Route::get('/timbre/create', 'TimbreController@create');
Route::post('/timbre/create', 'TimbreController@store');

Route::get('/image/create', 'ImageController@create');
Route::post('/image/create', 'ImageController@store');

Route::get('/timbre/show', "TimbreController@show");
Route::get('/timbre/edit', 'TimbreController@edit');
Route::post('/timbre/edit', 'TimbreController@update');

// -/timbres -index
// -/timbre/edit -edit
// -/timbre/edit -update
// -/timbre/delete -delete

// -/image/edit -edit
// -/image/edit -update
// -/image/delete -delete

Route::dispatch();

?>