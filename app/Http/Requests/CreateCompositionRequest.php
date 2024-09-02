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
            'difficulty' => 'required|in:Easy,Medium,Hard',
            'formations' => 'required|array|min:1|max:10',
            'formations.*.champion_id' => 'required|integer',
            'formations.*.slot_table' => 'required|integer',
            'formations.*.star' => 'required|boolean',
            'formations.*.item_id' => 'nullable|integer',

            'prio_carrusel' => 'nullable|array|min:0|max:6',
            'prio_carrusel.*.item_id' => 'required|integer',

            'augments' => 'nullable|array',
            'augments.tier_1' => 'nullable|array|min:0|max:3',
            'augments.tier_1.*' => 'integer',
            'augments.tier_2' => 'nullable|array|min:0|max:3',
            'augments.tier_2.*' => 'integer',
            'augments.tier_3' => 'nullable|array|min:0|max:3',
            'augments.tier_3.*' => 'integer',
        ];
    }
    
    public function messages()
    {
        return [

            'prio_carrusel.array' => 'Prio Carrusel debe ser un array.',
            'prio_carrusel.min' => 'Prio Carrusel debe tener al menos 0 objetos.',
            'prio_carrusel.max' => 'Prio Carrusel no puede tener más de 6 objetos.',
            'prio_carrusel.*.item_id.required' => 'Cada objeto en Prio Carrusel debe tener un ID válido.',
            'prio_carrusel.*.item_id.integer' => 'El ID del objeto en Prio Carrusel debe ser un entero.',

            'augments.tier_1.array' => 'Tier 1 Augments debe ser un array.',
            'augments.tier_1.min' => 'Tier 1 Augments debe tener al menos 0 elementos.',
            'augments.tier_1.max' => 'Tier 1 Augments no puede tener más de 3 elementos.',
            'augments.tier_1.*.integer' => 'Cada ID de Tier 1 Augments debe ser un entero.',
    
            'augments.tier_2.array' => 'Tier 2 Augments debe ser un array.',
            'augments.tier_2.min' => 'Tier 2 Augments debe tener al menos 0 elementos.',
            'augments.tier_2.max' => 'Tier 2 Augments no puede tener más de 3 elementos.',
            'augments.tier_2.*.integer' => 'Cada ID de Tier 2 Augments debe ser un entero.',
    
            'augments.tier_3.array' => 'Tier 3 Augments debe ser un array.',
            'augments.tier_3.min' => 'Tier 3 Augments debe tener al menos 0 elementos.',
            'augments.tier_3.max' => 'Tier 3 Augments no puede tener más de 3 elementos.',
            'augments.tier_3.*.integer' => 'Cada ID de Tier 3 Augments debe ser un entero.',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}