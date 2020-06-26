<?php

namespace App\Providers;

use App\Models\FaqType;
use App\Models\SchoolClass;
use App\Models\SupplierType;
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

        View::composer('madaresona.supplier.addSupplier', function ($view) {
            $supplierTypes = SupplierType::all();
            $view->with('supplierTypes', $supplierTypes);
        });

        View::composer('madaresona.registration.create', function ($view) {
            $allSchools = School::all();
            $allClasses = SchoolClass::all();
            $view->with(['allSchools' => $allSchools, 'allClasses' => $allClasses]);
        });

        View::composer('madaresona.faq.create', function ($view) {
            $types = FaqType::all();
            $view->with('types', $types);
        });
    }
}
