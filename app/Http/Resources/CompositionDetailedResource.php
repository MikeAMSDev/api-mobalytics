<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class CompositionDetailedResource extends JsonResource
{
    public function toArray($request)
    {
        // Contar sinergias por tipo
        $synergyCounts = $this->formations->flatMap(function ($formation) {
            return $formation->champion->synergies;
        })->groupBy('type')->map->count();

        // Filtrar campeones duplicados pero con diferentes slot_table
        $formations = $this->formations->unique(function ($formation) {
            return $formation->champion->id . '-' . $formation->slot_table;
        });

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'playing_style' => $this->playing_style,
            'tier' => $this->tier,
            'difficulty' => $this->difficulty,
            'formations' => FormationDetailedResource::collection($formations),
            'prio_carrusel' => PrioCarruselResource::collection($this->prioCarrusel),
            'augments' => AugmentDetailedResource::collection($this->augments),
            'synergy_counts' => $synergyCounts,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function with($request)
    {
        return [
            'status' => 'success',
            'message' => 'Composition retrieved successfully',
        ];
    }
}