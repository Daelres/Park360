<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckInRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole(['admin', 'operator']) ?? false;
    }

    public function rules(): array
    {
        return [
            'code' => ['required', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'device' => ['nullable', 'string', 'max:255'],
        ];
    }
}
