<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class FilterItemRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'string|nullable',
            'recipe_object' => 'string|nullable',
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'The item name must be a string.',
            'recipe_object.string' => 'The item recipe must be a string.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
