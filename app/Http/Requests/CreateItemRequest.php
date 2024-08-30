<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateItemRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'item_bonus' => 'required|string|max:255',
            'tier' => 'required|string|in:S,A,B,N',
            'object_img' => 'nullable|string|max:255',
            'type_object' => 'required|string|in:Basic,Combined,Faerie,Radiant,Non-Craftable,Consumable,Support,Artifact',
            'has_recipe' => 'sometimes|boolean',
            'recipe_objects' => 'required_if:has_recipe,true|array|max:2',
            'recipe_objects.*' => 'required_if:has_recipe,true|integer|exists:items,id',
        ];
    }
    
    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'item_bonus.required' => 'The item_bonus field is required.',
            'tier.required' => 'The tier field is required.',
            'tier.string' => 'The tier field must be a string.',
            'tier.in' => 'The tier field can be only S, A, B and N.',
            'object_img.string' => 'The object_img field must be a string.',
            'type_object.required' => 'The type_object field is required.',
            'recipe_objects.required_if' => 'You must provide at least one object if the item has a recipe.',
            'recipe_objects.*.exists' => 'The selected object is invalid.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}