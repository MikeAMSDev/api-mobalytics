<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\Item;

class BasicItemRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The item name is required.',
            'name.string' => 'The item name must be a string.',
        ];
    }

    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $name = $this->input('name');
            $basicItem = Item::where('type_object', 'Basic')
                ->where('name', $name)
                ->first();

            if (!$basicItem) {
                $validator->errors()->add('name', 'The specified basic item was not found.');
            }
        });
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}