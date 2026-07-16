<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\Service;
use Illuminate\Support\Facades\Cache;
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
            // Le footer est rendu sur quasi toutes les pages publiques ; son contenu
            // (société, services mis en avant) ne change qu'en admin, d'où un TTL
            // court plutôt qu'une requête DB à chaque requête HTTP.
            $data = Cache::remember('footer.composer.data', 300, function () {
                return [
                    'company' => Company::active()->first(),
                    'services' => Service::active()->ordered()->take(4)->get(),
                ];
            });

            $view->with($data);
        });
    }
}
