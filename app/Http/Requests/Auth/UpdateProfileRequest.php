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
        $user = $this->user();

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:30'],
            'avatar_url' => ['nullable', 'url', 'max:2048'],
            'preferred_locale' => ['nullable', 'string', 'in:en,si,ta'],
        ];

        // Couple-specific validation
        if ($user->isCouple()) {
            $rules['partner_name'] = ['nullable', 'string', 'max:255'];
            $rules['notification_preferences'] = ['nullable', 'array'];
        }

        // Vendor-specific validation
        if ($user->isVendor()) {
            $rules['business_name'] = ['required', 'string', 'max:255'];
            $rules['category_id'] = ['required', 'integer', 'exists:vendor_categories,id'];
            $rules['description'] = ['required', 'string', 'max:5000'];
            $rules['district'] = ['required', 'string', 'max:50'];
            $rules['address'] = ['required', 'string', 'max:255'];
            $rules['vendor_phone'] = ['nullable', 'string', 'max:30'];
            $rules['vendor_email'] = ['nullable', 'email', 'max:255'];
            $rules['website'] = ['nullable', 'url', 'max:255'];
            $rules['instagram_handle'] = ['nullable', 'string', 'max:100'];
            $rules['facebook_url'] = ['nullable', 'url', 'max:255'];
            $rules['starting_price'] = ['nullable', 'numeric', 'min:0'];
        }

        // Planner-specific validation
        if ($user->isPlanner()) {
            $rules['company_name'] = ['required', 'string', 'max:255'];
            $rules['designation'] = ['nullable', 'string', 'max:150'];
            $rules['bio'] = ['nullable', 'string', 'max:5000'];
            $rules['experience_years'] = ['nullable', 'integer', 'min:0', 'max:60'];
            $rules['specializations'] = ['nullable', 'array'];
            $rules['specializations.*'] = ['string', 'max:100'];
            $rules['operating_districts'] = ['nullable', 'array'];
            $rules['operating_districts.*'] = ['string', 'max:50'];
            $rules['website'] = ['nullable', 'url', 'max:255'];
            $rules['instagram_handle'] = ['nullable', 'string', 'max:100'];
            $rules['facebook_url'] = ['nullable', 'url', 'max:255'];
            $rules['address'] = ['nullable', 'string', 'max:255'];
        }

        return $rules;
    }
}
