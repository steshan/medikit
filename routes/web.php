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
Route::get('/test', 'MedicineController@test');
Route::get('/list', 'MedicineController@medicineList');
Route::get('/test2', 'MedicineController@test2');
Route::get('/namelist', 'MedicineControllerTest@nameList');
Route::get('/formlist', 'MedicineControllerTest@formList');

//Route::get('/addform', function() {return view('add');});