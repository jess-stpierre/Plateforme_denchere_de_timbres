<?php

use App\Routes\Route;
use App\Controllers\HomeController;
use App\Controllers\MembreController;
use App\Controllers\AuthController;

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

Route::get('/membre/create', "MembreController@create");
Route::post('/membre/create', "MembreController@store");
Route::get('/membre/show', "MembreController@show");

Route::get('/login', 'AuthController@create');
Route::post('/login', 'AuthController@store');
Route::get('/logout', 'AuthController@delete');

Route::dispatch();

?>