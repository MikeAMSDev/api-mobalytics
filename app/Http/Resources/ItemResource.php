<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'item_bonus' => $this->item_bonus,
            'tier' => $this->tier,
            'object_img' => url('images/items/' . $this->object_img),
            'type_object' => $this->type_object,
            'recipes' => $this->whenLoaded('recipes', function () {
                return $this->recipes->map(function ($recipe) {
                    return $recipe->components->map(function ($component) {
                        return [
                            'id' => $component->id,
                            'name' => $component->name,
                            'item_bonus' => $component->item_bonus,
                            'tier' => $component->tier,
                            'object_img' => url('images/items/' . $component->object_img),
                            'type_object' => $component->type_object,
                        ];
                    })->toArray();
                })->flatten(1)->toArray();
            }),
        ];
    }
}