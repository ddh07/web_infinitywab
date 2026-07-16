<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\Service;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('partials.footer', function ($view) {
            $company = Company::active()->first();
            $services = Service::active()->ordered()->take(4)->get();

            $view->with(compact('company', 'services'));
        });
    }
}
