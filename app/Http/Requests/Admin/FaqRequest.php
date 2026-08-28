<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Déjà filtré par le middleware `admin` sur le groupe de routes.
        return true;
    }

    public function rules(): array
    {
        return [
            'question' => 'required|string|max:255',
            'answer' => 'required|string|max:2000',
            'is_active' => 'boolean',
            'order' => 'integer',
        ];
    }
}
