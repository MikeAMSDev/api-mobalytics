<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PrioCarruselResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'item_id' => $this->item_id,
        ];
    }
}