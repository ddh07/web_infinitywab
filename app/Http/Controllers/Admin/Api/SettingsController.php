<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Clés sensibles : jamais renvoyées en clair au navigateur. show() indique
     * seulement si une valeur est enregistrée (`*_set: true/false`) ; un champ
     * laissé vide dans le formulaire ne modifie pas la valeur existante.
     */
    private const SENSITIVE_KEYS = ['mail_password', 'ga4_credentials_json', 'turnstile_secret_key'];

    private const KEYS = [
        'gtm_container_id',
        'ga4_property_id',
        'ga4_credentials_json',
        'turnstile_site_key',
        'turnstile_secret_key',
        'mail_host',
        'mail_port',
        'mail_username',
        'mail_password',
        'mail_encryption',
        'mail_from_address',
        'mail_from_name',
        'seo_default_title',
        'seo_default_description',
        'seo_search_console_verification',
        'seo_bing_verification',
        'seo_noindex',
        'a11y_force_reduced_motion',
        'a11y_statement_content',
        'banner_enabled',
        'banner_text',
        'banner_link_url',
        'banner_link_label',
        'default_theme',
        'maintenance_enabled',
        'maintenance_message',
    ];

    /**
     * Pages publiques "statiques" dont le hero peut recevoir une image de fond
     * personnalisée (les pages de détail — service/projet/produit/actualité — ont
     * déjà leur propre visuel via le champ image de l'enregistrement, donc pas de
     * réglage global pour elles).
     */
    private const HERO_IMAGE_PAGES = [
        'home', 'services', 'projects', 'products', 'news', 'about', 'contact', 'contact-thanks',
    ];

    /**
     * Clés dont la valeur est un chemin de fichier géré par upload*(), pas par
     * update() : listées ici uniquement pour apparaître dans show().
     */
    private const FILE_KEYS = ['site_logo_path', 'site_favicon_path', 'seo_og_image_path'];

    public function show()
    {
        $data = [];

        foreach (self::KEYS as $key) {
            if (in_array($key, self::SENSITIVE_KEYS, true)) {
                $data[$key . '_set'] = Setting::has($key);
            } else {
                $data[$key] = Setting::get($key, '');
            }
        }

        foreach (self::FILE_KEYS as $key) {
            $data[$key] = Setting::get($key, '');
        }

        foreach (self::HERO_IMAGE_PAGES as $page) {
            $data['hero_image_' . str_replace('-', '_', $page)] = Setting::get($this->heroImageKey($page), '');
        }

        return response()->json($data);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'gtm_container_id' => ['nullable', 'string', 'max:32', 'regex:/^GTM-[A-Z0-9]+$/'],
            'ga4_property_id' => ['nullable', 'string', 'max:32', 'regex:/^[0-9]+$/'],
            'ga4_credentials_json' => ['nullable', 'string'],
            'turnstile_site_key' => ['nullable', 'string', 'max:255'],
            'turnstile_secret_key' => ['nullable', 'string', 'max:255'],
            'mail_host' => ['nullable', 'string', 'max:255'],
            'mail_port' => ['nullable', 'integer', 'min:1', 'max:65535'],
            'mail_username' => ['nullable', 'string', 'max:255'],
            'mail_password' => ['nullable', 'string', 'max:255'],
            'mail_encryption' => ['nullable', 'string', 'in:tls,ssl,none'],
            'mail_from_address' => ['nullable', 'email', 'max:255'],
            'mail_from_name' => ['nullable', 'string', 'max:255'],
            'seo_default_title' => ['nullable', 'string', 'max:255'],
            'seo_default_description' => ['nullable', 'string', 'max:500'],
            'seo_search_console_verification' => ['nullable', 'string', 'max:255'],
            'seo_bing_verification' => ['nullable', 'string', 'max:255'],
            'seo_noindex' => ['nullable', 'boolean'],
            'a11y_force_reduced_motion' => ['nullable', 'boolean'],
            'a11y_statement_content' => ['nullable', 'string', 'max:5000'],
            'banner_enabled' => ['nullable', 'boolean'],
            'banner_text' => ['nullable', 'string', 'max:255'],
            'banner_link_url' => ['nullable', 'string', 'max:2048'],
            'banner_link_label' => ['nullable', 'string', 'max:60'],
            'default_theme' => ['nullable', 'string', 'in:system,light,dark'],
            'maintenance_enabled' => ['nullable', 'boolean'],
            'maintenance_message' => ['nullable', 'string', 'max:500'],
        ]);

        if (array_key_exists('ga4_credentials_json', $validated) && filled($validated['ga4_credentials_json'])) {
            json_decode($validated['ga4_credentials_json'], true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json([
                    'message' => "Le JSON du compte de service GA4 n'est pas valide.",
                ], 422);
            }
        }

        foreach ($validated as $key => $value) {
            // Un champ sensible laissé vide ne doit pas écraser la valeur déjà en base.
            if (in_array($key, self::SENSITIVE_KEYS, true) && ($value === null || $value === '')) {
                continue;
            }

            Setting::set($key, $value !== null ? (string) $value : null);
        }

        return response()->json(['message' => 'Paramètres mis à jour avec succès']);
    }

    public function uploadLogo(Request $request)
    {
        return $this->setImageSetting($request, 'site_logo_path');
    }

    public function removeLogo()
    {
        return $this->removeImageSetting('site_logo_path');
    }

    public function uploadFavicon(Request $request)
    {
        return $this->setImageSetting($request, 'site_favicon_path');
    }

    public function removeFavicon()
    {
        return $this->removeImageSetting('site_favicon_path');
    }

    public function uploadOgImage(Request $request)
    {
        return $this->setImageSetting($request, 'seo_og_image_path');
    }

    public function removeOgImage()
    {
        return $this->removeImageSetting('seo_og_image_path');
    }

    public function uploadHeroImage(Request $request, string $page)
    {
        abort_unless(in_array($page, self::HERO_IMAGE_PAGES, true), 404);

        return $this->setImageSetting($request, $this->heroImageKey($page));
    }

    public function removeHeroImage(string $page)
    {
        abort_unless(in_array($page, self::HERO_IMAGE_PAGES, true), 404);

        return $this->removeImageSetting($this->heroImageKey($page));
    }

    private function heroImageKey(string $page): string
    {
        return 'hero_image_' . str_replace('-', '_', $page);
    }

    /**
     * Les images de personnalisation (logo, favicon, OG, fonds héro) sont choisies
     * dans la bibliothèque de médias partagée (Admin\Api\MediaController) plutôt
     * qu'importées directement ici : on ne stocke donc que l'URL déjà hébergée,
     * sans jamais supprimer le fichier physique (potentiellement réutilisé ailleurs).
     */
    private function setImageSetting(Request $request, string $settingKey): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'url' => ['required', 'string', 'max:2048'],
        ]);

        Setting::set($settingKey, $validated['url']);

        return response()->json(['message' => 'Image mise à jour avec succès', 'url' => $validated['url']]);
    }

    private function removeImageSetting(string $settingKey): \Illuminate\Http\JsonResponse
    {
        Setting::set($settingKey, null);

        return response()->json(['message' => 'Image retirée avec succès']);
    }
}
