<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Message;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class ContactController extends Controller
{
    public function index()
    {
        $company = Company::active()->first();
        $faqs = Faq::active()->ordered()->get();

        return view('contact', compact('company', 'faqs'));
    }

    public function store(Request $request)
    {
        // Anti-spam : champ piège rempli par les bots, ou formulaire soumis trop vite
        // pour avoir été rempli par un humain (< 3s). On répond comme un succès normal
        // pour ne pas indiquer aux bots que leur soumission a été détectée.
        $isBot = filled($request->input('website'))
            || $request->integer('form_rendered_at') > 0
            && now()->timestamp - $request->integer('form_rendered_at') < 3;

        if ($isBot) {
            return redirect()->route('contact.thanks');
        }

        $this->verifyTurnstile($request);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email:filter|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        $validated['ip_address'] = $request->ip();
        $validated['user_agent'] = (string) $request->userAgent();

        Message::create($validated);

        return redirect()->route('contact.thanks');
    }

    /**
     * Vérifie le défi Cloudflare Turnstile auprès de leur API (voir
     * config('services.turnstile') et resources/views/contact.blade.php). Ignoré si
     * aucune clé secrète n'est configurée : le formulaire reste alors protégé
     * seulement par le honeypot/délai déjà en place ci-dessus.
     */
    private function verifyTurnstile(Request $request): void
    {
        $secret = config('services.turnstile.secret_key');
        if (!$secret) {
            return;
        }

        $token = (string) $request->input('cf-turnstile-response');
        $failureMessage = 'La vérification anti-robot a échoué. Merci de réessayer.';

        if ($token === '') {
            throw ValidationException::withMessages(['turnstile' => $failureMessage]);
        }

        try {
            $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'secret' => $secret,
                'response' => $token,
                'remoteip' => $request->ip(),
            ]);
        } catch (\Throwable) {
            // Cloudflare injoignable : on refuse plutôt que de désactiver silencieusement
            // la protection anti-spam.
            throw ValidationException::withMessages(['turnstile' => $failureMessage]);
        }

        if (!$response->successful() || $response->json('success') !== true) {
            throw ValidationException::withMessages(['turnstile' => $failureMessage]);
        }
    }

    public function thanks()
    {
        $company = Company::active()->first();

        return view('contact-thanks', compact('company'));
    }
}
