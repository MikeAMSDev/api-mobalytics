<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChampionResource extends JsonResource
{
    /**
     * Transformar el recurso en un array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'cost' => $this->cost,
            'champion_img' => url('images/champions/' . $this->champion_img),
            'ability' => json_decode($this->ability),
            'champion_icon' => url('images/champions/' . $this->champion_icon),
            'set_version' => $this->set_version,
            'stats' => json_decode($this->stats),
            'synergies' => SynergyResource::collection($this->whenLoaded('synergies')),
        ];
    }
}
