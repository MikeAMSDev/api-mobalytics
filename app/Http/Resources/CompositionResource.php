<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompositionResource extends JsonResource
{
    public function toArray($request)
    {
        // Inicializar un array para consolidar las formaciones
        $consolidatedFormations = [];

        // Iterar sobre las formaciones y consolidarlas
        foreach ($this->formations as $formation) {
            $key = $formation->champion_id . '-' . $formation->slot_table;

            if (!isset($consolidatedFormations[$key])) {
                // Si no existe en el array consolidado, añadirlo
                $consolidatedFormations[$key] = [
                    'champion_id' => $formation->champion_id,
                    'name' => $formation->champion->name,
                    'champion_img' => url('images/champions'. $formation->champion->champion_img),
                    'champion_icon' => url('images/champions'.$formation->champion->champion_icon),
                    'slot_table' => $formation->slot_table,
                    'star' => $formation->star,
                    'item_ids' => []
                ];
            }

            // Añadir el item_id a la lista, si no es null
            if ($formation->item_id !== null) {
                $consolidatedFormations[$key]['item_ids'][] = $formation->item_id;
                $consolidatedFormations[$key]['item_ids'][] = $formation->item->name;
                $consolidatedFormations[$key]['item_ids'][] = url('images/items'. $formation->item->object_img);
            }
        }

        // Convertir el array asociativo en un array indexado
        $consolidatedFormations = array_values($consolidatedFormations);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'playing_style' => $this->playing_style,
            'tier' => $this->tier,
            'difficulty' => $this->difficulty,
            'formations' => $consolidatedFormations,
            'prio_carrusel' => PrioCarruselResource::collection($this->prioCarrusel),
            'augments' => AugmentCompResource::collection($this->augments),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}