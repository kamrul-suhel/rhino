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

/*
|--------------------------------------------------------------------------
| API Route for Users
|--------------------------------------------------------------------------
|
*/

Route::prefix('users')->group(function () {
    Route::post('', 'Auth\RegisterController@store');
    Route::put('{id}', 'Auth\RegisterController@update');
    Route::get('', 'Auth\UserListController@list');
    Route::get('{id}/show', 'Auth\UserShowController@show');
    Route::get('dropdown', 'Auth\UserDropdownController@list');
    Route::delete('{id}', 'Auth\UserDeleteController@destroy');
    Route::post('{id}/updatepassword', 'Auth\UserShowController@changePassword');

    // Event User
    Route::get('events/{eventId}/dealerships/{dealershipId}', 'Event\EventUserListController@list');
});

Route::prefix('settings')->group(function () {
    Route::post('add', 'Setting\SettingController@generateDefaultSetting');
    Route::get('/', 'Setting\SettingController@index');
});


/*
|--------------------------------------------------------------------------
| API Route for Settings
|--------------------------------------------------------------------------
|
*/

Route::prefix('settings')->group(function () {
    Route::post('add', 'Setting\SettingController@generateDefaultSetting');
    Route::get('/', 'Setting\SettingController@index');
});


/*
|--------------------------------------------------------------------------
| API Route for Dealership
|--------------------------------------------------------------------------
|
*/

Route::prefix('dealerships')->group(function () {
    Route::get('', 'Dealership\DealershipController@index');
    Route::get('dropdown', 'Dealership\DealershipDropDownController@index');
    Route::post('', 'Dealership\DealershipController@store');
    Route::get('{id}/show', 'Dealership\DealershipController@show');
    Route::put('{id}/update', 'Dealership\DealershipController@update');
    Route::delete('{id}/delete', 'Dealership\DealershipController@destroy');

    // Brand & Dealership relation route
    Route::post('{id}/brands', 'Dealership\BrandDealershipController@store');
    Route::get('{id}/brands', 'Dealership\BrandDealershipController@index');

    // Dealership users route
    Route::get('{id}/users', 'Dealership\DealershipUserController@list');
});


/*
|--------------------------------------------------------------------------
| API Route for Brand Dealership
|--------------------------------------------------------------------------
|
*/

Route::prefix('brandDealerships')->group(function () {
    Route::put('{id}', 'Dealership\BrandDealershipController@update');
    Route::delete('{id}', 'Dealership\BrandDealershipController@destroy');
});


/*
|--------------------------------------------------------------------------
| API Route for Companies
|--------------------------------------------------------------------------
|
*/

Route::prefix('companies')->group(function () {
    Route::get('', 'Company\CompanyController@index');
    Route::get('dropdown', 'Company\CompanyDropdownController@index');
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

Route::prefix('brands')->group(function () {
    Route::get('', 'Brand\BrandController@index');
    Route::get('dropdown', 'Brand\BrandDropDownController@getBrandsForDropDown');
    Route::post('', 'Brand\BrandController@store');
    Route::get('{id}/show', 'Brand\BrandController@show');
    Route::put('{id}/update', 'Brand\BrandController@update');
    Route::delete('{id}/delete', 'Brand\BrandController@destroy');
    Route::get('{id}/regions', 'Brand\BrandRegionController@getRegions');
});

/*
|--------------------------------------------------------------------------
| API Route for Vehicles
|--------------------------------------------------------------------------
|
*/

Route::prefix('vehicles')->group(function () {
    Route::get('', 'Vehicle\VehicleController@index');
    Route::post('', 'Vehicle\VehicleController@store');
    Route::get('{id}/show', 'Vehicle\VehicleController@show');
    Route::put('{id}/update', 'Vehicle\VehicleController@update');
    Route::get('{id}/brands', 'Vehicle\VehicleController@getBrands');
    Route::delete('{id}', 'Vehicle\VehicleController@destroy');
});


/*
|--------------------------------------------------------------------------
| API Route for Dealership Groups
|--------------------------------------------------------------------------
|
*/

Route::prefix('groups')->group(function () {
    Route::get('', 'Dealership\GroupController@index');
    Route::get('dropdown', 'Dealership\Group\GroupDropdownController@index');
    Route::post('', 'Dealership\GroupController@store');
    Route::get('{id}', 'Dealership\GroupController@show');
    Route::put('{id}', 'Dealership\GroupController@update');
    Route::delete('{id}', 'Dealership\GroupController@destroy');
});


/*
|--------------------------------------------------------------------------
| API Route for Languages
|--------------------------------------------------------------------------
|
*/

Route::prefix('languages')->group(function () {
    Route::get('/', 'Language\LanguageController@index');
});


/*
|--------------------------------------------------------------------------
| API Route for Countries
|--------------------------------------------------------------------------
|
*/

Route::prefix('countries')->group(function () {
    Route::get('', 'Country\CountryController@index');
    Route::post('', 'Country\CountryController@store');
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

Route::prefix('regions')->group(function () {
    Route::post('', 'Region\RegionController@store');
    Route::put('{id}', 'Region\RegionController@update');
    Route::delete('{id}', 'Region\RegionController@destroy');
});


/*
|--------------------------------------------------------------------------
| API Route for Events
|--------------------------------------------------------------------------
|
*/

Route::prefix('events')->group(function () {
    Route::post('', 'Event\EventController@store');
    Route::get('', 'Event\EventListController@index');
    Route::get('dropdown', 'Event\EventDropdownController@index');
    Route::get('{id}', 'Event\EventShowController@show');
    Route::put('{id}', 'Event\EventController@update');
    Route::post('{id}/brands', 'Event\EventBrandController@addBrand');
    Route::delete('{id}/brands/{brandId}', 'Event\EventBrandController@destroyBrand');

    // Get brands for specific event
    Route::get('{id}/brands', 'Event\EventBrandListController@getBrandsByEventId');

    // Get Vehicle for specific event
    Route::get('{id}/vehicles', 'Event\EventVehicleController@getVehicleByEventId');

    Route::get('{id}/brands/dropdown', 'Brand\BrandDropDownController@getBrandForEvent');
    Route::delete('{id}', 'Event\EventController@destroy');

    // Relation between event user route
    Route::post('{id}/users', 'Event\EventUserStoreController@store');
    Route::delete('{eventId}/users/{userId}', 'Event\EventUserDestroyController@destroy');


    /*
    |--------------------------------------------------------------------------
    | API Route for Events types
    |--------------------------------------------------------------------------
    |
    */
    Route::prefix('types')->group(function () {
        Route::get('list', 'Event\Type\TypeController@index');
        Route::get('dropdown', 'Event\Type\TypeDropdownController@index');
        Route::post('', 'Event\Type\TypeController@store');
        Route::get('{id}', 'Event\Type\TypeController@show');
        Route::put('{id}', 'Event\Type\TypeController@update');
        Route::delete('{id}', 'Event\Type\TypeController@destroy');
    });
});

/*
|--------------------------------------------------------------------------
| API Route for EventVehicle
|--------------------------------------------------------------------------
|
*/
Route::prefix('eventvehicle')->group(function () {
    Route::put('{eventVehicleId}', 'Event\EventVehicleUpdateController@update');
    Route::delete('{eventVehicleId}', 'Event\EventVehicleDestroyController@destroy');
});

/*
|--------------------------------------------------------------------------
| API Route for Guest
|--------------------------------------------------------------------------
|
*/
Route::prefix('guests')->group(function () {
    Route::get('', 'Guest\GuestListController@list');
    Route::get('{id}', 'Guest\GuestShowController@show');
    Route::post('', 'Guest\GuestStoreController@store');
    Route::put('{id}', 'Guest\GuestStoreController@update');
    Route::delete('{id}', 'Guest\GuestDestroyController@destroy');
});

/*
|--------------------------------------------------------------------------
| API Route for Appointments
|--------------------------------------------------------------------------
|
*/
Route::prefix('appointments')->group(function () {
    Route::get('{eventId}', 'Appointment\AppointmentListController@list');
});


/*
|--------------------------------------------------------------------------
| API Route for Upload file
|--------------------------------------------------------------------------
|
*/

Route::prefix('uploadfiles')->group(function () {
    Route::post('', 'File\FileUploadController@uploadFiles');
});
