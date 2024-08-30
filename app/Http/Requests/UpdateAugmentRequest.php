<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateAugmentRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'augment_img' => 'nullable|string|max:255',
            'tier' => 'required|int|between:1,3',
            'set_version' => 'required|integer|between:1,12',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The synergy name is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'description.required' => 'The description is required.',
            'description.string' => 'The description must be a string.',
            'augment_img.string' => 'The augment image must be a string.',
            'augment_img.max' => 'The augment image may not be greater than 255 characters.',
            'tier.required' => 'The tier is required.',
            'tier.integer' => 'The tier must be a integer.',
            'tier.between' => 'The tier can only be from 1 to 3.',
            'set_version.required' => 'The set version is required.',
            'set_version.integer' => 'The set version must be an integer.',
            'set_version.between' => 'The set version can only be from 1 to 12.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
