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
Route::get('/expired', 'MedicineController@showExpired');
Route::get('/add', 'MedicineController@addForm');
Route::post('/add', 'MedicineController@addMedicine');
Route::get('/search', 'MedicineController@searchMedicine');
Route::get('/list', 'MedicineController@medicineList');
Route::get('/namelist', 'MedicineController@nameList');
Route::get('/formlist', 'MedicineController@formList');
Route::get('/component', 'MedicineController@getComponent');
Route::get('/delete/{id}', 'MedicineController@delete');
Route::get('/update/{id}', 'MedicineController@updateForm');
Route::post('/update/{id}', 'MedicineController@updateMedicine');
