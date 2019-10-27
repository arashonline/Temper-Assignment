<?php

/*
|--------------------------------------------------------------------------
| Temper Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all routes which are only accessible with
| Temper Admin Users
|
*/


Route::get('/', 'ChartController@index');
Route::get('/{page}/{offset}', ['uses'=>'ChartController@paging']);


