<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateCompositionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'playing_style' => 'required|string|max:255|in:Fast 9,Level 7 Slow Roll,Level 6 Slow Roll,Level 5 Slow Roll,Hyper Roll,Default,Fast 8, Slow Roll',
            'tier' => 'required|in:S,A,B,M,N',
            'prio_carrusel' => 'required|json',
            'difficulty' => 'required|in:Easy,Medium,Hard',
            'formations' => 'required|array|min:1|max:10',
            'formations.*.champion_id' => 'required|integer|distinct',
            'formations.*.slot_table' => 'required|json',
            'formations.*.star' => 'required|boolean',
            'formations.*.item_id' => 'nullable|integer',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The composition name is required.',
            'name.string' => 'The composition name must be a string.',
            'name.max' => 'The composition name must not exceed 255 characters.',
        
            'description.required' => 'The description is required.',
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description must not exceed 255 characters.',
        
            'playing_style.required' => 'The playing style is required.',
            'playing_style.string' => 'The playing style must be a string.',
            'playing_style.max' => 'The playing style must not exceed 255 characters.',
            'playing_style.in' => 'The selected playing style is not valid.',
        
            'tier.required' => 'The tier is required.',
            'tier.in' => 'The selected tier is not valid.',

            'prio_carrusel.required' => 'The prio_carrusel is required.' ,
        
            'difficulty.required' => 'The difficulty is required.',
            'difficulty.in' => 'The selected difficulty is not valid.',
        
            'formations.required' => 'At least one formation must be provided.',
            'formations.array' => 'Formations must be an array.',
            'formations.min' => 'At least one formation must be provided.',
            'formations.max' => 'You cannot provide more than 10 formations.',
        
            'formations.*.champion_id.required' => 'The champion ID is required.',
            'formations.*.champion_id.integer' => 'The champion ID must be an integer.',
            'formations.*.champion_id.distinct' => 'The champion ID must be unique in each formation.',
        
            'formations.*.slot_table.required' => 'The champion’s slot is required.',
            'formations.*.slot_table.json' => 'The champion’s slot must be a valid JSON.',
        
            'formations.*.star.required' => 'The star field is required.',
            'formations.*.star.boolean' => 'The star field must be a boolean value.',
        
            'formations.*.item_id.integer' => 'The item ID must be an integer.',
    ];
}

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
