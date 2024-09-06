<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AugmentCompResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'augment_id' => $this->augment_id,
            'name' => $this->augment->name,
            'augment_img' => url('images/augments/'. $this->augment->augment_img ),
            'composition_id' => $this->composition_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}