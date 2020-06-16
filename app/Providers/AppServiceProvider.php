<?php

namespace App\Providers;

use App\School;
use Illuminate\Support\Facades\View;
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
        View::composer('madaresona.schools.index', function ($view) {
            $schools = School::get('status')->unique('status');
            $view->with('schools', $schools);
        });
    }
}
