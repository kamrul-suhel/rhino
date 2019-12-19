<?php


Auth::routes();

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/frontend', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Routes for Dealerships
|--------------------------------------------------------------------------
|
*/

Route::prefix('dealerships')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('create', function () {
        return view('welcome');
    });

    Route::get('{id}/edit', function () {
        return view('welcome');
    });

    /**
     * Group routes
     */
    Route::get('groups', function () {
        return view('welcome');
    });

    /**
     * Dealership event routes
     */
    Route::get('{dealershipId}/events/{id}/edit', function () {
        return view('welcome');
    });
});

Route::get('/home', 'HomeController@index')->name('home');

/*
|--------------------------------------------------------------------------
| Routes for countries
|--------------------------------------------------------------------------
|
*/

Route::prefix('countries')->group(function () {
    Route::get('', function () {
        return view('welcome');
    });

    Route::get('{id}/edit', function () {
        return view('welcome');
    });
});


/*
|--------------------------------------------------------------------------
| Routes for Languages
|--------------------------------------------------------------------------
|
*/
Route::prefix('languages')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
});

/*
|--------------------------------------------------------------------------
| Routes for Brands
|--------------------------------------------------------------------------
|
*/
Route::prefix('brands')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('{id}/edit', function () {
        return view('welcome');
    });

    Route::get('create', function () {
        return view('welcome');
    });

    Route::get('{id}/vehicle/{vehicleId}', function () {
        return view('welcome');
    });

    Route::get('{id}/vehicle/create', function () {
        return view('welcome');
    });
});


/*
|--------------------------------------------------------------------------
| Routes for Vehicles
|--------------------------------------------------------------------------
|
*/
Route::prefix('vehicles')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('{id}/edit', function () {
        return view('welcome');
    });

    Route::get('create', function () {
        return view('welcome');
    });
});


/*
|--------------------------------------------------------------------------
| Routes for Companies
|--------------------------------------------------------------------------
|
*/
Route::prefix('companies')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('create', function () {
        return view('welcome');
    });
});


/*
|--------------------------------------------------------------------------
| Routes for Users
|--------------------------------------------------------------------------
|
*/

Route::prefix('users')->group(function () {
    Route::get('', function () {
        return view('welcome');
    });


    Route::get('list', function () {
        return view('welcome');
    });

    Route::get('create', function () {
        return view('welcome');
    });

    Route::get('{id}/edit', function () {
        return view('welcome');
    });
});


/*
|--------------------------------------------------------------------------
| Routes for Events
|--------------------------------------------------------------------------
|
*/
Route::prefix('events')->group(function () {
    Route::get('', function () {
        return view('welcome');
    });

    Route::get('list', function () {
        return view('welcome');
    });

    Route::get('create', function () {
        return view('welcome');
    });

    Route::get('{id}/edit', function () {
        return view('welcome');
    });


    Route::get('types', function () {
        return view('welcome');
    });
});


/*
|--------------------------------------------------------------------------
| Routes for Guests
|--------------------------------------------------------------------------
|
*/
Route::prefix('guests')->group(function () {
    Route::get('', function () {
        return view('welcome');
    });

    Route::get('list', function () {
        return view('welcome');
    });

    Route::get('create', function () {
        return view('welcome');
    });

    Route::get('{id}/edit', function () {
        return view('welcome');
    });

});




/*
|--------------------------------------------------------------------------
| Routes for Testing
| Disable when it is on production
|--------------------------------------------------------------------------
|
*/

Route::get('sendMail', 'Test\TestMailController@sendMail');


Route::prefix('test')->group(function(){
   Route::get('datetime', function(){
       return view('welcome');
   });
});
