<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('', function () {
    return view('welcome');
});
Route::get('json', 'JsonController@index');
Route::get('generate', 'GenerateController@generate1200');
Route::get('generatebulks', 'GenerateController@generatebulks');
Route::get('json/complete', 'JsonController@complete');
Route::get('json/bulk/{number}', 'JsonController@bulk');
Route::get('generatesort', 'GenerateController@generatesort');
Route::get('json/sorted', 'JsonController@sorted');
Route::get('generatesortbulks', 'GenerateController@generatesortbulks');
Route::get('json/sortedbulks/{number}', 'JsonController@sortedbulks');
Route::get('json/bulkevents/{number}', 'JsonController@bulkevents');
Route::get('generateeventtyp', 'GenerateController@generateeventtyp');
Route::get('countevents', 'GenerateController@count');
Route::get('geojson', 'GenerateController@geojson');
Route::get('news', 'GenerateController@news');
Route::get('json/geojson', 'JsonController@geojson');


Route::get('json/{start}/{stop}', 'JsonController@index');