<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class FormationSynergyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;  // Cambia esto según tus necesidades de autorización
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'formationsData' => ['required', 'array', 'max:10', function ($attribute, $value, $fail) {
                $championCounts = array_count_values(array_column($value, 'champion_id'));

                foreach ($championCounts as $championId => $count) {
                    if ($count > 2) {
                        $fail('You can only have up to 2 of the same champion.');
                    }
                }
            }],
            'formationsData.*.champion_id' => 'required|integer|exists:champions,id',
            'formationsData.*.items' => 'nullable|array|max:3',
            'formationsData.*.items.*' => 'integer|exists:items,id',
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'formationsData.required' => 'The formationsData field is required.',
            'formationsData.array' => 'The formationsData field must be an array.',
            'formationsData.max' => 'You can add a maximum of 10 champions.',
            'formationsData.*.champion_id.required' => 'Each champion must have a valid champion_id.',
            'formationsData.*.champion_id.integer' => 'The champion_id must be an integer.',
            'formationsData.*.champion_id.exists' => 'The selected champion does not exist.',
            'formationsData.*.items.array' => 'Items must be an array.',
            'formationsData.*.items.max' => 'A champion can have a maximum of 3 items.',
            'formationsData.*.items.*.integer' => 'Each item must be an integer.',
            'formationsData.*.items.*.exists' => 'The selected item does not exist.',
        ];
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}