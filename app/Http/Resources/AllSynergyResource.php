<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AllSynergyResource extends JsonResource
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
            'type' => $this->type,
            'icon_synergy' => asset('images/synergies/' . $this->icon_synergy),
            'description' => $this->description,
            'synergy_activation' => json_decode($this->synergy_activation),
            'set_version' => $this->set_version,
            'good_for' => SimpleChampionResource::collection($this->whenLoaded('champions')),
        ];
    }
}
