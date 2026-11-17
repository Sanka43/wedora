<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user()->id)],
            'phone' => ['nullable', 'string', 'max:30'],
            'partner_name' => ['nullable', 'string', 'max:255'],
            'preferred_locale' => ['nullable', 'string', 'in:en,si,ta'],
            'avatar_url' => ['nullable', 'url', 'max:2048'],
        ];
    }
}
