<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaintenanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole(['admin', 'operator']) ?? false;
    }

    public function rules(): array
    {
        return [
            'attraction_id' => ['required', 'exists:attractions,id'],
            'requested_by_employee_id' => ['nullable', 'exists:employees,id'],
            'performed_by_employee_id' => ['nullable', 'exists:employees,id'],
            'status' => ['required', 'in:scheduled,in_progress,completed,cancelled'],
            'scheduled_for' => ['nullable', 'date'],
            'started_at' => ['nullable', 'date'],
            'completed_at' => ['nullable', 'date'],
            'cost' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'findings' => ['nullable', 'string'],
        ];
    }
}
