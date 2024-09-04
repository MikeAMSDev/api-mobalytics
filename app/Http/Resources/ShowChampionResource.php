<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowChampionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // Decodifica los campos JSON
        $ability = json_decode($this->ability, true);
        $stats = json_decode($this->stats, true);

        // Agrega la URL completa a la imagen en ability
        if (isset($ability['img'])) {
            $ability['img'] = url('images/champions/' . $ability['img']);
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'cost' => $this->cost,
            'champion_img' => url('images/champions/' . $this->champion_img),
            'ability' => $ability,
            'champion_icon' => url('images/champions/' . $this->champion_icon),
            'stats' => $stats,
            'synergies' => AllSynergyResource::collection($this->whenLoaded('synergies')),
            'recommended_items' => ItemResource::collection($this->whenLoaded('items')),
        ];
    }
}