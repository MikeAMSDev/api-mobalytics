<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AugmentDetailedResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'img' => url('images/augments/'.$this->augment_img),
            'description' => $this->description,
            'tier' => $this->tier,

        ];
    }
}