<?php

namespace App\Http\Requests\Auth;

use App\Domains\Identity\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
            'phone' => ['nullable', 'string', 'max:30'],
            'role' => ['nullable', Rule::enum(UserRole::class)],
            'partner_name' => ['nullable', 'string', 'max:255'],
            // Vendor specific fields if role == vendor
            'business_name' => ['required_if:role,vendor', 'nullable', 'string', 'max:255'],
            'category_id' => ['required_if:role,vendor', 'nullable', 'exists:vendor_categories,id'],
            'district' => ['nullable', 'string', 'max:50'],
            // Optional invite token if registering from invitation link
            'invite_token' => ['nullable', 'string'],
        ];
    }
}
