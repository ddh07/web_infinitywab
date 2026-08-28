<?php

namespace App\Http\Controllers;

use App\Models\LegalDocument;
use App\Models\Setting;

class LegalController extends Controller
{
    public function accessibility()
    {
        return view('legal.accessibility', [
            'document' => LegalDocument::with('media')->where('slug', 'accessibilite')->first(),
            'content' => Setting::get('a11y_statement_content'),
        ]);
    }

    public function privacy()
    {
        return view('legal.privacy', [
            'document' => LegalDocument::with('media')->where('slug', 'confidentialite')->first(),
        ]);
    }

    public function terms()
    {
        return view('legal.terms', [
            'document' => LegalDocument::with('media')->where('slug', 'conditions-utilisation')->first(),
        ]);
    }
}
