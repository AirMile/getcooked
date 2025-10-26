<?php

namespace App\Http\Requests;

use App\Models\Recipe;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class UpdateRecipeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('recipe'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => ['nullable', File::image()->max(5 * 1024), Rule::dimensions()->maxWidth(2000)->maxHeight(2000)],
            'cook_time' => 'required|integer|min:1',
            'difficulty' => 'required|in:easy,medium,hard',
            'servings' => 'required|integer|min:1',
            'cuisine_type' => 'nullable|string|max:100',
            'category' => 'nullable|string|max:100',
            'dietary_tags' => 'nullable|array',
            'dietary_tags.*' => 'string|in:vegetarian,vegan,pescatarian,keto,paleo,gluten-free,dairy-free,nut-free,egg-free,soy-free,shellfish-free,fish-free',
            'ingredients' => 'required|array|min:1',
            'ingredients.*.name' => 'required|string|max:255',
            'ingredients.*.amount' => 'required|numeric|min:0',
            'ingredients.*.unit' => 'required|string|max:50',
        ];
    }
}
