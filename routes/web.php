<?php


use App\User;
use Illuminate\Http\Request;

Auth::routes();

/**
 * Auth route
 */

Route::get('auth/me', 'Auth\LoginController@getLoginUser');
Route::get('refresh_csrf_token', 'Auth\RefreshCSRFToken@refreshCSRFToken');
Route::get('generate_security_token', 'Auth\GenerateSecurityTokenController@generateToken');

/**
 * User route
 */

Route::get('forgot_password', function () {
    return view('index');
});

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

Route::get('', function () {
    return view('index');
})->name('admin');

Route::post('guests/login', 'Guest\GuestLoginController@login');
Route::post('guests/logout', 'Guest\GuestLoginController@logOut');

/*
|--------------------------------------------------------------------------
| Unprotected route
|--------------------------------------------------------------------------
|
*/
Route::get('/admin', function () {
    return view('index');
})->middleware('guest')->name('admin');

/*
|--------------------------------------------------------------------------
| Routes for Dealerships
|--------------------------------------------------------------------------
|
*/
Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {

    Route::get('dashboard', function () {
        return view('index');
    })->name('dashboard');

    Route::prefix('dealerships')->group(function () {
        Route::get('/', function () {
            return view('index');
        })->name('Dealerships')->middleware('AdminMiddleware');

        Route::get('/list', function () {
            return view('index');
        })->name('ListDealerships')->middleware('AdminMiddleware');

        Route::get('create', function () {
            return view('index');
        })->name('CreateDealerships')->middleware('AdminMiddleware');

        Route::get('{id}/users', function () {
            return view('index');
        })->middleware('DealershipMiddleware')->name('DealershipUsers');

        Route::get('{id}/edit', function () {
            return view('index');
        })->middleware('DealershipMiddleware')->name('EditDealerships');

        Route::get('{id}/users/create', function () {
            return view('index');
        })->name('CreateDealershipsUser');

        /**
         * Group routes
         */
        Route::prefix('groups')->group(function () {
            Route::get('', function () {
                return view('index');
            })->name('Groups');

            Route::get('list', function () {
                return view('index');
            })->name('GroupsList');
        });

        /**
         * Dealership event routes
         */
        Route::get('{dealershipId}/events/{id}/edit', function () {
            return view('index');
        })->name('EditDealershipEvent')->middleware('DealershipMiddleware');

        /**
         * Dealership admin route
         */
        Route::prefix('book-guest')->group(function () {
            Route::get('/', function () {
                return view('index');
            })->name('BooGuest');
        });

        Route::prefix('{dealershipId}/guests')->group(function () {
            Route::get('{id}/show', function () {
                return view('index');
            })->name('ShowDealershipGuest');
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
        })->name('Countries');

        Route::get('/create', function () {
            return view('index');
        })->name('CountriesCreate');

        Route::get('/list', function () {
            return view('index');
        })->name('CountriesList');

        Route::get('{id}/edit', function () {
            return view('index');
        })->name('CountriesEdit');
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
        })->name('Languages');

        Route::get('list', function () {
            return view('index');
        })->name('LanguagesList');
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
        })->name('Brands');

        Route::get('{id}/edit', function () {
            return view('index');
        })->name('BrandsEdit');

        Route::get('create', function () {
            return view('index');
        })->name('BrandCreate');

        Route::get('{id}/vehicle/{vehicleId}', function () {
            return view('index');
        })->name('BrandVehicleEdit');

        Route::get('{id}/vehicle/create', function () {
            return view('index');
        })->name('BrandVehicleCreate');

        Route::get('list', function () {
            return view('index');
        })->name('BrandList');
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
        })->name('Vehicles');

        Route::get('{id}/edit', function () {
            return view('index');
        })->name('VehiclesEdit');

        Route::get('create', function () {
            return view('index');
        })->name('VehicleCreate');

        Route::get('list', function () {
            return view('index');
        })->name('VehicleList');
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
        })->name('Companies');

        Route::get('list', function () {
            return view('index');
        })->name('CompaniesList');

        Route::get('create', function () {
            return view('index');
        })->name('CompaniesList');
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
        })->name('Users')->middleware('AdminMiddleware');


        Route::get('list', function () {
            return view('index');
        })->name('UsersList')->middleware('AdminMiddleware');

        Route::get('create', function () {
            return view('index');
        })->name('UsersCreate')->middleware('AdminMiddleware');

        Route::get('{id}/edit', function ($id) {
            $user = User::find($id);
            $title = "$user->firstname $user->surname";
            return view('index')->with('title', "User - $title");
        })->name('UsersEdit')->middleware('DealershipMiddleware');
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
        })->name('Events');

        Route::get('list', function () {
            return view('index');
        })->name('EventsList');

        Route::get('create', function () {
            return view('index');
        })->name('EventCreate');

        Route::get('{id}/edit', function () {
            return view('index');
        })->name('EventsEdit');


        Route::get('types', function () {
            return view('index');
        })->name('EventTypes');

        Route::get('types/list', function () {
            return view('index');
        })->name('EventTypesList');

        /**
         * Event Sales route
         */
        Route::get('{eventId}/sales', function () {
            return view('index');
        })->name('EventSales')->middleware('SalesExecutiveMiddleware');

        /**
         * Route for rhino admin to see calender for specific event
         */

        Route::get('{eventId}/dealerships/{dealershipId}/calendar', function () {
            return view('index');
        })->name('EventDealershipsCalendar');

        /*
        |--------------------------------------------------------------------------
        | Routes for event analytics
        |--------------------------------------------------------------------------
        |
        */

        Route::get('{id}/analytics', function () {
            return view('index');
        })->name('EventsAnalytics')
            ->middleware('SalesExecutiveMiddleware');
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
        })->name('Guests');

        Route::get('list', function () {
            return view('index');
        })->name('GuestList');

        Route::get('create', function () {
            return view('index');
        })->name('GuestCreate');

        Route::get('{id}/edit', function () {
            return view('index');
        })->name('GuestEdit');
    });

    /*
    |--------------------------------------------------------------------------
    | Routes for Dealership Admin
    |--------------------------------------------------------------------------
    |
    */

    Route::get('bookguest', function () {
        return view('index');
    })->name('BookAGuest');

    Route::get('calendar', function () {
        return view('index');
    })->name('Calendar');

    /*
    |--------------------------------------------------------------------------
    | Routes for Testing
    | Disable when it is on production
    |--------------------------------------------------------------------------
    |
    */

    Route::get('sendMail', 'Test\TestMailController@sendMail');


    Route::prefix('test')->group(function () {
        Route::get('datetime', function () {
            return view('index');
        });
    });


    /*
    |--------------------------------------------------------------------------
    | Routes for Settings
    |--------------------------------------------------------------------------
    |
    */

    Route::prefix('settings')->group(function () {
        Route::get('translations', function () {
            return view('index');
        })->name('SettingsTranslations');
    });
});


/**
 * Frontend route
 */

Route::middleware(['guestAuth'])->prefix('booking')->group(function () {
    Route::get('', function (Request $request) {
        if ($request->ajax()) {
            $sessionId = session()->get('uniqueId');

            if ($sessionId) {
                $guest = \App\Guest::where('unique', $sessionId)->first();
                $language = \App\Language::find($guest->language_id);
                return response()->json([
                    'success' => true,
                    'uniqueId' => session()->get('uniqueId'),
                    'language' => $language
                ]);
            } else {
                return response()->json([
                    'success' => false
                ]);
            }


        }

        return view('index');
    });

    /*
    |--------------------------------------------------------------------------
    | Routes for Frontend
    |--------------------------------------------------------------------------
    |
    */

    Route::get('confirmed', function () {
        return view('index');
    });

    Route::get('list', function () {
        return view('index');
    });
});
