<?php

namespace App\Http\Requests\Marketplace;

use Illuminate\Foundation\Http\FormRequest;

class StoreRfqRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'package_id' => ['nullable', 'integer', 'exists:vendor_packages,id'],
            'event_date' => ['required', 'date'],
            'ceremony_style' => ['nullable', 'string', 'max:255'],
            'venue_location' => ['nullable', 'string', 'max:255'],
            'guest_count' => ['nullable', 'integer', 'min:1', 'max:10000'],
            'services' => ['nullable', 'array'],
            'services.*' => ['string', 'max:100'],
            'couple_message' => ['required', 'string', 'min:5', 'max:3000'],
            'guest_name' => ['nullable', 'string', 'max:255'],
            'guest_email' => ['nullable', 'email', 'max:255'],
            'guest_phone' => ['nullable', 'string', 'max:30'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'package_id' => 'selected wedding package',
            'event_date' => 'nuptial date',
            'ceremony_style' => 'ceremony style',
            'venue_location' => 'district and venue',
            'guest_count' => 'estimated guest count',
            'couple_message' => 'auspicious Nekath or special notes',
        ];
    }
}
