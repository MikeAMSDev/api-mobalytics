<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FormationDetailedResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'champion' => [
                'id' => $this->champion->id ?? null,
                'name' => $this->champion->name ?? null,
                'champion_img' => $this->champion ? url('image/champions/' . $this->champion->champion_img) : null,
                'champion_icon' => $this->champion ? url('image/champions/' . $this->champion->champion_icon) : null,
                'cost' => $this->champion->cost ?? null,
                'ability' => $this->champion ? json_decode($this->champion->ability) : null,
                'stats' => $this->champion ? json_decode($this->champion->stats) : null,
                'synergies' => $this->champion->synergies->map(function ($synergy) {
                    return [
                        'name' => $synergy->name,
                        'img' => url('images/synergies/'.$synergy->icon_synergy),
                        'description' => $synergy->description ?? null,
                    ];
                }),
                'items' => $this->items->map(function ($item) {
                    return [
                        'id' => $item->id ?? null,
                        'name' => $item->name ?? null,
                        'item_bonus' => $item->item_bonus ?? null,
                        'image' => $item->object_img ? url('images/items/' . $item->object_img) : null,
                    ];
                }),
            ],
            'star' => $this->star ?? null,
            'slot_table' => $this->slot_table ?? null,
        ];
    }
}