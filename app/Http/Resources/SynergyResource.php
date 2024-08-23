<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SynergyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
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
            'synergy_activation' => $this->synergy_activation,
            'set_version' => $this->set_version,
            'good_for' => ChampionResource::collection($this->champions),
        ];
    }
}