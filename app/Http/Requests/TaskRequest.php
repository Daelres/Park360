<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole(['admin', 'operator']) ?? false;
    }

    public function rules(): array
    {
        return [
            'attraction_id' => ['required', 'exists:attractions,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'frequency' => ['required', 'in:daily,weekly,monthly,ad-hoc'],
            'status' => ['required', 'in:pending,in_progress,completed,cancelled'],
            'scheduled_for' => ['nullable', 'date'],
            'completed_at' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
            'employees' => ['sometimes', 'array'],
            'employees.*' => ['integer', 'exists:employees,id'],
        ];
    }
}
