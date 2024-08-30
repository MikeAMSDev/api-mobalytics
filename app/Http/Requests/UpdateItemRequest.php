<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'item_bonus' => 'required|string',
            'tier' => 'required|string|in:S,A,B,N',
            'object_img' => 'nullable|string|max:255',
            'type_object' => 'required|in:' . implode(',', \App\Models\Item::VALID_TYPE_OBJECTS),
            'recipes' => 'nullable|array|max:1',
            'recipes.*.id' => 'nullable|exists:recipes,id',
            'recipes.*.name' => 'required_with:recipes.*.id|string|max:255',
            'recipes.*.description' => 'nullable|string',
            'recipes.*.item_ids' => 'required_with:recipes.*.id|array|min:1|max:2',
            'recipes.*.item_ids.*' => 'required|exists:items,id',
        ];
    }
    
    public function messages()
    {
        return [
            'name.required' => 'Item name is required.',
            'item_bonus.required' => 'The item bonus is mandatory.',
            'tier.required' => 'The tier field is required.',
            'tier.string' => 'The tier field must be a string.',
            'tier.in' => 'The tier field can be only S, A, B and N.',
            'type_object.in' => 'The selected item type is not valid.',
            'object_img.string' => 'The object_img field must be a string.',
            'recipes.max' => 'You can only associate one recipe to the item.',
            'recipes.*.id.exists' => 'The recipe ID is invalid.',
            'recipes.*.name.required_with' => 'The recipe name is required when providing a recipe ID.',
            'recipes.*.name.string' => 'The recipe name must be a text.',
            'recipes.*.item_ids.required_with' => 'Item IDs are required when providing a Recipe ID.',
            'recipes.*.item_ids.min' => 'The recipe must have at least one associated item.',
            'recipes.*.item_ids.max' => 'The recipe cannot have more than two objects associated with it.',
            'recipes.*.item_ids.*.exists' => 'One or more item IDs are invalid.',
        ];
    }

    protected function prepareForValidation()
    {
        $itemId = $this->route('id');
        $this->merge([
            'item_id' => $itemId,
        ]);
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}