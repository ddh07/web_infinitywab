<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Company;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $company = Company::active()->first();
        return view('contact', compact('company'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email:filter|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        $validated['ip_address'] = $request->ip();
        $validated['user_agent'] = (string) $request->userAgent();

        $message = Message::create($validated);

        return redirect()->route('contact')
            ->with('success', 'Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.');
    }
}
