<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PrioCarruselResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'item_id' => $this->item_id,
            'item_name' => $this->item ? $this->item->name : null,
            'item_img' => url('images/items/'.$this->item->object_img),
        ];
    }
}