<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        DB::listen(function ($collection) {
            Log::info($collection->sql, ['Binging: ' => $collection->bindings, 'Execution Time: ' => $collection->time]);
            Log::info('Execution Time: ', [$collection->time.' MS']);
            Log::info('Bindings: ', [$collection->bindings]);
            Log::info('-------------------------------------------------------------------------------------------');
        });
    }
}
