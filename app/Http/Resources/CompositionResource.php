<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompositionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'playing_style' => $this->playing_style,
            'tier' => $this->tier,
            'difficulty' => $this->difficulty,
            'prio_carrusel' => $this->prio_carrusel,
            'formations' => FormationResource::collection($this->formations),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function with($request)
    {
        return [
            'status' => 'success',
            'message' => 'Composition created',
        ];
    }
}