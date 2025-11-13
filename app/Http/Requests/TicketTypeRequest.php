<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole(['admin', 'operator']) ?? false;
    }

    public function rules(): array
    {
        $ticketTypeId = $this->route('ticket_type')?->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'validity_days' => ['required', 'integer', 'min:1'],
            'access_limit' => ['nullable', 'integer', 'min:1'],
            'is_active' => ['sometimes', 'boolean'],
            'slug' => ['nullable', 'alpha_dash', 'unique:ticket_types,slug,' . $ticketTypeId],
        ];
    }
}
