<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowChampionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'cost' => $this->cost,
            'champion_img' => url('images/champions/' . $this->champion_img),
            'ability' => json_decode($this->ability),
            'champion_icon' => url('images/champions/' . $this->champion_icon),
            'stats' => json_decode($this->stats),
            'synergies' => AllSynergyResource::collection($this->whenLoaded('synergies')),
        ];
    }
}
