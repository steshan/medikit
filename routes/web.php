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

Route::get('/medicine/create', 'MedicineController@createMedicineView');
Route::post('/medicine/create', 'MedicineController@createMedicine');

Route::get('/medicine', 'MedicineController@updateMedicineView');
Route::patch('/medicine', 'MedicineController@updateMedicine');
Route::delete('/medicine', 'MedicineController@deleteMedicine');

Route::get('/data/names', 'DataController@getNames');
Route::get('/data/forms', 'DataController@getForms');
Route::get('/data/component', 'DataController@getComponent');