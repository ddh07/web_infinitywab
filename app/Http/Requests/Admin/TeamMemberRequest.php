<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TeamMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'photo' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'order' => 'integer',
        ];
    }
}
