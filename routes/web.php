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

Route::get('/', 'PagesController@root')->name('root');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/users/{user}', 'UsersController@show')->name('users.show');
Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'edit']]);

Route::resource('/company', 'CompanyController', ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);
