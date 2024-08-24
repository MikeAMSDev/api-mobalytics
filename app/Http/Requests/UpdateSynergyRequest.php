<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateSynergyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'type' => [
                'required',
                'string',
                'in:' . implode(',', \App\Models\Synergy::VALID_TYPE_SYNERGY),
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
            'name.required' => 'The name field is required.',
            'name.string' => 'The name field must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',
            
            'type.required' => 'The type field is required.',
            'type.string' => 'The type field must be a string.',
            'type.in' => 'The type must be one of the following: ' . implode(', ', \App\Models\Synergy::VALID_TYPE_SYNERGY),

            'description.required' => 'The description field is required.',
            'description.string' => 'The description field must be a string.',
            
            'icon_synergy.nullable' => 'The icon synergy field is optional.',
            'icon_synergy.string' => 'The icon synergy field must be a string.',
            'icon_synergy.max' => 'The icon synergy may not be greater than 255 characters.',
            
            'synergy_activation.required' => 'The synergy activation field is required.',
            'synergy_activation.array' => 'The synergy activation must be a valid array.',
            
            'set_version.required' => 'The set version field is required.',
            'set_version.integer' => 'The set version field must be an integer.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
