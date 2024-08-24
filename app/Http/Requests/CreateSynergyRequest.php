<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateSynergyRequest extends FormRequest
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
            'type' => [
                'required',
                'string',
                'in:' . implode(',', \App\Models\Synergy::VALID_TYPE_SYNERGY), // Validación de valores permitidos
            ],
            'description' => 'required|string',
            'icon_synergy' => 'nullable|string|max:255',
            'synergy_activation' => 'required|array',
            'set_version' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The synergy name is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'type.required' => 'The synergy type is required.',
            'type.string' => 'The type must be a string.',
            'type.in' => 'The type must be one of the following: ' . implode(', ', \App\Models\Synergy::VALID_TYPE_SYNERGY),
            'description.required' => 'The description is required.',
            'description.string' => 'The description must be a string.',
            'icon_synergy.string' => 'The synergy icon must be a string.',
            'icon_synergy.max' => 'The synergy icon may not be greater than 255 characters.',
            'synergy_activation.required' => 'The synergy activation is required.',
            'synergy_activation.json' => 'The synergy activation must be a valid JSON.',
            'set_version.required' => 'The set version is required.',
            'set_version.integer' => 'The set version must be an integer.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
