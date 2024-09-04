<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChampionDetailedResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'synergies' => SynergyDetailedResource::collection($this->synergies),
            'items' => ItemDetailedResource::collection($this->items),
            'star' => $this->star,
        ];
    }
}