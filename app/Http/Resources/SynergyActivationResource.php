<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SynergyActivationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'name' => $this->resource['name'],
            'type' => $this->resource['type'],
            'description' => $this->resource['description'],
            'icon_synergy' => $this->resource['icon_synergy'],
            'highlighted' => array_map(function ($highlight) {
                return [
                    'required' => $highlight['required'],
                    'percentage' => $highlight['percentage'],
                    'active' => $highlight['active'],
                    'color' => $highlight['color'],
                    'count' => $highlight['count']
                ];
            }, $this->resource['highlighted']),
            'emblem_items' => $this->resource['emblem_items'],
            'color' => $this->resource['color']
        ];
    }
}