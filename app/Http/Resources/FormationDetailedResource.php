<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FormationDetailedResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'champion' => [
                'id' => $this->champion->id,
                'name' => $this->champion->name,
                // Otros campos del campeón
            ],
            'items' => $this->items->flatMap(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    // Otros campos del item
                ];
            }),
            'slot_table' => $this->slot_table,
        ];
    }
}