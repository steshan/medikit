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

Route::get('/add', 'MedicineController@addForm');
Route::post('/add', 'MedicineController@addMedicine');
Route::get('/update', 'MedicineController@updateForm');
Route::patch('/update', 'MedicineController@updateMedicine');
Route::delete('/update', 'MedicineController@delete');

Route::get('/namelist', 'DataController@nameList');
Route::get('/formlist', 'DataController@formList');
Route::get('/component', 'DataController@getComponent');