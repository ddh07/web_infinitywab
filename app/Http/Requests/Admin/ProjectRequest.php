<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => ['required', 'string', 'max:255', Rule::unique('projects')->ignore($this->route('id'))],
            'description' => 'required|string|max:500',
            'content' => 'nullable|string',
            'client' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'status' => 'nullable|in:en_attente,en_cours,termine',
            'project_date' => 'nullable|date',
            'technologies' => 'nullable|array',
            'image' => 'nullable|string|max:255',
            'completion_date' => 'nullable|date',
            'project_url' => 'nullable|url',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'order' => 'integer',
        ];
    }
}
