<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


/*
|--------------------------------------------------------------------------
| API Route for Settings
|--------------------------------------------------------------------------
|
*/

Route::prefix('settings')->group(function(){
    Route::post('add', 'Setting\SettingController@generateDefaultSetting');
    Route::get('/', 'Setting\SettingController@index');
});



/*
|--------------------------------------------------------------------------
| API Route for Languages
|--------------------------------------------------------------------------
|
*/

Route::prefix('languages')->group(function(){
    Route::get('/', 'Language\LanguageController@index');
});


/*
|--------------------------------------------------------------------------
| API Route for Countries
|--------------------------------------------------------------------------
|
*/

Route::prefix('countries')->group(function(){
    Route::get('/', 'Country\CountryController@index');
    Route::post('{id}/update', 'Country\CountryController@update');
});
