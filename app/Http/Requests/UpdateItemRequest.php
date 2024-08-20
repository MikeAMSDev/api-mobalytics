<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateItemRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'item_bonus' => 'required|string',
            'tier' => 'nullable|string|max:255',
            'object_img' => 'required|string|max:255',
            'type_object' => 'required|in:' . implode(',', \App\Models\Item::VALID_TYPE_OBJECTS),
            'recipes' => 'nullable|array',
            'recipes.*.id' => 'required|exists:recipes,id',
            'recipes.*.name' => 'nullable|string|max:255',
            'recipes.*.description' => 'nullable|string',
            'recipes.*.item_ids' => 'required|array|min:1',
            'recipes.*.item_ids.*' => 'required|exists:items,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre del ítem es obligatorio.',
            'item_bonus.required' => 'El bono del ítem es obligatorio.',
            'type_object.in' => 'El tipo de ítem seleccionado no es válido.',
            'recipes.*.id.exists' => 'El ID de la receta no es válido.',
            'recipes.*.name.string' => 'El nombre de la receta debe ser un texto.',
            'recipes.*.item_ids.required' => 'Los IDs de los ítems son obligatorios.',
            'recipes.*.item_ids.*.exists' => 'Uno o más IDs de ítems no son válidos.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}