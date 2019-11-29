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
| API Route for Dealership
|--------------------------------------------------------------------------
|
*/

Route::prefix('dealerships')->group(function(){
    Route::get('', 'Dealership\DealershipController@index');
    Route::post('', 'Dealership\DealershipController@store');
    Route::get('{id}/show', 'Dealership\DealershipController@show');
    Route::put('{id}/update', 'Dealership\DealershipController@update');
    Route::delete('{id}/delete', 'Dealership\DealershipController@destroy');
});


/*
|--------------------------------------------------------------------------
| API Route for Companies
|--------------------------------------------------------------------------
|
*/

Route::prefix('companies')->group(function(){
    Route::get('', 'Company\CompanyController@index');
    Route::post('', 'Company\CompanyController@store');
    Route::put('{id}/update', 'Company\CompanyController@update');
    Route::get('{id}/show', 'Company\CompanyController@show');
    Route::delete('{id}/delete', 'Company\CompanyController@destroy');
});


/*
|--------------------------------------------------------------------------
| API Route for Brands
|--------------------------------------------------------------------------
|
*/

Route::prefix('brands')->group(function(){
    Route::get('', 'Brand\BrandController@index');
    Route::post('', 'Brand\BrandController@store');
    Route::get('{id}/show', 'Brand\BrandController@show');
    Route::get('{id}/regions', 'Brand\BrandController@getRegions');
});

/*
|--------------------------------------------------------------------------
| API Route for Dealership Groups
|--------------------------------------------------------------------------
|
*/

Route::prefix('groups')->group(function(){
    Route::get('', 'Dealership\GroupController@index');
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
    Route::get('', 'Country\CountryController@index');
    Route::get('dropdown', 'Country\CountryController@getCountriesDropDown');
    Route::get('{id}/show', 'Country\CountryController@show');
    Route::get('{id}/regions', 'Country\CountryController@getCountryRegions');
    Route::post('{id}/update', 'Country\CountryController@update');
    Route::delete('{id}/delete', 'Country\CountryController@destroy');
});


/*
|--------------------------------------------------------------------------
| API Route for Regions
|--------------------------------------------------------------------------
|
*/

Route::prefix('regions')->group(function(){
    Route::post('', 'Region\RegionController@store');
    Route::put('{id}', 'Region\RegionController@update');
    Route::delete('{id}', 'Region\RegionController@destroy');
});


/*
|--------------------------------------------------------------------------
| API Route for Upload file
|--------------------------------------------------------------------------
|
*/

Route::prefix('uploadfiles')->group(function(){
    Route::post('', 'File\FileUploadController@uploadFiles');
});
