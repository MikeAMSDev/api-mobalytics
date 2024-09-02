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
            'composition_id' => $this->composition_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'augment' => new AugmentResource($this->whenLoaded('augment')),
        ];
    }
}