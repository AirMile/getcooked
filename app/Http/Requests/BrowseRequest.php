<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrowseRequest extends FormRequest
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
            'search' => ['nullable', 'string', 'max:255'],
            'difficulty' => ['nullable', 'array'],
            'difficulty.*' => ['string', 'in:easy,medium,hard'],
            'cook_time' => ['nullable', 'array'],
            'cook_time.*' => ['string', 'in:quick,medium,long,very_long'],
            'meal_type' => ['nullable', 'array'],
            'meal_type.*' => ['string'],
            'cuisine' => ['nullable', 'array'],
            'cuisine.*' => ['string'],
            'dietary_tags' => ['nullable', 'array'],
            'dietary_tags.*' => ['string'],
        ];
    }
}
