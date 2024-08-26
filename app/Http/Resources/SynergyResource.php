<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SynergyResource extends JsonResource
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
            'type' => $this->type,
            'icon_synergy' => asset('images/synergies/' . $this->icon_synergy),
            'description' => $this->description,
            'synergy_activation' => json_encode($this->synergy_activation),
            'set_version' => $this->set_version,
            'good_for' => ChampionResource::collection($this->whenLoaded('champions')),
        ];
    }
}