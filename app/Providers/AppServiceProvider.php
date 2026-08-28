<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Throwable;

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
        Password::defaults(function () {
            $rule = Password::min(10)->mixedCase()->numbers()->symbols();

            return $this->app->isProduction() ? $rule->uncompromised() : $rule;
        });

        View::composer('layouts.app', function ($view) {
            // Utilisé pour les balises Open Graph / Twitter Card et le schéma
            // Schema.org LocalBusiness partagés par toutes les pages publiques.
            $view->with('schemaCompany', Cache::remember('footer.composer.data', 300, function () {
                return [
                    'company' => Company::active()->first(),
                    'services' => Service::active()->ordered()->take(4)->get(),
                ];
            })['company']);
        });

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

        $this->applyDatabaseSettings();
    }

    /**
     * Fait passer en priorité les réglages saisis dans l'admin (onglet Paramètres,
     * table `settings`) sur les valeurs de .env, sans toucher au reste du code qui
     * continue de lire ces valeurs via config(). Silencieux si la table n'existe pas
     * encore (installation fraîche, avant la première migration) ou si la base est
     * injoignable : dans ce cas on garde simplement les valeurs de .env.
     */
    private function applyDatabaseSettings(): void
    {
        try {
            if (! Schema::hasTable('settings')) {
                return;
            }
        } catch (Throwable) {
            return;
        }

        $gtmContainerId = Setting::get('gtm_container_id');
        if (filled($gtmContainerId)) {
            config(['services.gtm.container_id' => $gtmContainerId]);
        }

        $ga4PropertyId = Setting::get('ga4_property_id');
        if (filled($ga4PropertyId)) {
            config(['services.ga4.property_id' => $ga4PropertyId]);
        }

        $ga4CredentialsJson = Setting::get('ga4_credentials_json');
        if (filled($ga4CredentialsJson)) {
            config(['services.ga4.credentials_json' => $ga4CredentialsJson]);
        }

        $turnstileSiteKey = Setting::get('turnstile_site_key');
        if (filled($turnstileSiteKey)) {
            config(['services.turnstile.site_key' => $turnstileSiteKey]);
        }

        $turnstileSecretKey = Setting::get('turnstile_secret_key');
        if (filled($turnstileSecretKey)) {
            config(['services.turnstile.secret_key' => $turnstileSecretKey]);
        }

        $mailOverrides = [
            'mail_host' => 'mail.mailers.smtp.host',
            'mail_port' => 'mail.mailers.smtp.port',
            'mail_username' => 'mail.mailers.smtp.username',
            'mail_password' => 'mail.mailers.smtp.password',
            'mail_encryption' => 'mail.mailers.smtp.encryption',
            'mail_from_address' => 'mail.from.address',
            'mail_from_name' => 'mail.from.name',
        ];

        foreach ($mailOverrides as $settingKey => $configKey) {
            $value = Setting::get($settingKey);
            if (filled($value)) {
                config([$configKey => $value]);
            }
        }
    }
}
