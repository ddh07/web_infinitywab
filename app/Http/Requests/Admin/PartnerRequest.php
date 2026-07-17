<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PartnerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'website' => 'nullable|url',
            'logo' => 'nullable|string|max:255',
            'category' => 'required|in:technology,financial',
            // Compat UI: "order" dans les formulaires, "sort_order" en base.
            'order' => 'nullable|integer',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ];
    }
}
