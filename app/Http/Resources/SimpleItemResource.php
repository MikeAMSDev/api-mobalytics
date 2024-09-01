<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SimpleItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data = [
            'name' => $this->name,
            'item_bonus' => $this->item_bonus,
            'tier' => $this->tier,
            'object_img' => asset('images/items/' . $this->object_img),
        ];

        if ($this->relationLoaded('recipes')) {
            $data['recipe'] = $this->recipes->map(function ($recipe) {
                return $recipe->items->map(function ($item) {
                    return [
                        'name' => $item->name,
                        'item_bonus' => $item->item_bonus,
                        'tier' => $item->tier,
                        'object_img' => asset('images/items/' . $item->object_img),
                    ];
                });
            })->flatten(1);
        }

        return $data;
    }
}