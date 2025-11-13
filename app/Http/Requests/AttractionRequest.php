<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttractionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole(['admin', 'operator']) ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:active,maintenance,closed'],
            'capacity' => ['required', 'integer', 'min:0'],
            'location' => ['nullable', 'string', 'max:255'],
            'opening_time' => ['nullable', 'date_format:H:i'],
            'closing_time' => ['nullable', 'date_format:H:i'],
            'next_maintenance_at' => ['nullable', 'date'],
            'maintenance_notes' => ['nullable', 'string'],
            'employees' => ['sometimes', 'array'],
            'employees.*' => ['integer', 'exists:employees,id'],
        ];
    }
}
