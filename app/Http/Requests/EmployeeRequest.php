<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole(['admin', 'operator']) ?? false;
    }

    public function rules(): array
    {
        $employeeId = $this->route('employee')?->id;

        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:employees,email,' . $employeeId],
            'phone' => ['nullable', 'string', 'max:50'],
            'position' => ['required', 'string', 'max:255'],
            'document_number' => ['required', 'string', 'max:50'],
            'hire_date' => ['required', 'date'],
            'status' => ['required', 'in:active,inactive,suspended'],
            'emergency_contact_name' => ['nullable', 'string', 'max:255'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
            'attractions' => ['sometimes', 'array'],
            'attractions.*' => ['integer', 'exists:attractions,id'],
        ];
    }
}
