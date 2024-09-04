<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FormationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        return [
            'champion_id' => $this->champion_id,
            'champion_name' => $this->champion->name,
            'slot_table' => $this->slot_table,
            'star' => $this->star,
            'item_id' => $this->item_id,
        ];
    }
}