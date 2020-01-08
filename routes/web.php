<?php


use Illuminate\Http\Request;

Auth::routes();

/**
 * AUth route
 */

Route::get('auth/me', 'Auth\LoginController@getLoginUser');

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
    return view('index');
})->name('guestLogin');

Route::post('guests/login', 'Guest\GuestLoginController@login');
Route::post('guests/logout', 'Guest\GuestLoginController@logOut');

/*
|--------------------------------------------------------------------------
| Routes for Dealerships
|--------------------------------------------------------------------------
|
*/
Route::prefix('admin')->group(function(){

    Route::get('', function(){
       return view('index');
    })->name('admin');

    Route::get('dashboard', function(){
        return view('index');
     })->middleware('auth');

    Route::prefix('dealerships')->group(function () {
        Route::get('/', function () {
            return view('index');
        })->middleware('auth');

        Route::get('create', function () {
            return view('index');
        })->middleware('auth');

        Route::get('{id}/edit', function () {
            return view('index');
        });

        /**
         * Group routes
         */
        Route::prefix('groups')->group(function(){
            Route::get('', function () {
                return view('index');
            });

            Route::get('list', function () {
                return view('index');
            });
        });

        /**
         * Dealership event routes
         */
        Route::get('{dealershipId}/events/{id}/edit', function () {
            return view('index');
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
            return view('index');
        });

        Route::get('/create', function () {
            return view('index');
        });

        Route::get('/list', function () {
            return view('index');
        });

        Route::get('{id}/edit', function () {
            return view('index');
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
            return view('index');
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
            return view('index');
        });

        Route::get('{id}/edit', function () {
            return view('index');
        });

        Route::get('create', function () {
            return view('index');
        });

        Route::get('{id}/vehicle/{vehicleId}', function () {
            return view('index');
        });

        Route::get('{id}/vehicle/create', function () {
            return view('index');
        });

        Route::get('list', function () {
            return view('index');
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
            return view('index');
        });

        Route::get('{id}/edit', function () {
            return view('index');
        });

        Route::get('create', function () {
            return view('index');
        });

        Route::get('list', function () {
            return view('index');
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
            return view('index');
        });

        Route::get('list', function () {
            return view('index');
        });

        Route::get('create', function () {
            return view('index');
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
            return view('index');
        });


        Route::get('list', function () {
            return view('index');
        });

        Route::get('create', function () {
            return view('index');
        });

        Route::get('{id}/edit', function ($id) {
            $user = User::find($id);
            $title = $user->surname;
            return view('index')->compact('title');
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
            return view('index');
        });

        Route::get('list', function () {
            return view('index');
        });

        Route::get('create', function () {
            return view('index');
        });

        Route::get('{id}/edit', function () {
            return view('index');
        });


        Route::get('types', function () {
            return view('index');
        });

        Route::get('types/list', function () {
            return view('index');
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
            return view('index');
        });

        Route::get('list', function () {
            return view('index');
        });

        Route::get('create', function () {
            return view('index');
        });

        Route::get('{id}/edit', function () {
            return view('index');
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
            return view('index');
        });
    });


    /*
    |--------------------------------------------------------------------------
    | Routes for Frontend
    |--------------------------------------------------------------------------
    |
    */

    Route::get('/booking', function () {
        return view('index');
    });
});


/**
 * Frontend route
 */

Route::middleware(['guestAuth'])->prefix('booking')->group(function () {
    Route::get('', function(Request $request){
        if($request->ajax()){
            return response()->json([
                'success' => true,
                'uniqueId' => session()->get('uniqueId')
            ]);
        }

        return view('index');
    });

    Route::get('list', function(){
        return view('index');
    });
});
