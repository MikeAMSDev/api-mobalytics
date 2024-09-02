<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class FilterChampionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'string|nullable',
            'synergy' => 'string|nullable',
            'cost' => 'integer|nullable',
            'alphabetical_order' => 'in:asc,desc|nullable',
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'The item name must be a string.',
            'synergy.string' => 'The item synergy must be a string.',
            'cost.string' => 'The item cost must be a string.',
            'alphabetical_order.in' => 'The alphabetical_order must be "asc" or "desc".',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
