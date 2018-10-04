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


Route::get('/', 'MainController');
Route::get('/add', 'MainController@addForm');
Route::post('/add', 'MainController@addMedicine');
Route::get('/update', 'MainController@updateForm');
Route::patch('/update', 'MainController@updateMedicine');
Route::delete('/update', 'MainController@delete');

Route::get('/namelist', 'MainController@nameList');
Route::get('/formlist', 'MainController@formList');
Route::get('/component', 'MainController@getComponent');