<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IncidentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole(['admin', 'operator']) ?? false;
    }

    public function rules(): array
    {
        return [
            'attraction_id' => ['required', 'exists:attractions,id'],
            'reported_by_employee_id' => ['nullable', 'exists:employees,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'severity' => ['required', 'in:low,medium,high,critical'],
            'status' => ['required', 'in:open,investigating,resolved,closed'],
            'reported_at' => ['required', 'date'],
            'resolved_at' => ['nullable', 'date'],
            'resolution_notes' => ['nullable', 'string'],
        ];
    }
}
