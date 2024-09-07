<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompositionDetailedResource extends JsonResource
{
    protected $includeUserInfo;

    public function __construct($resource, $includeUserInfo = false)
    {
        parent::__construct($resource);
        $this->includeUserInfo = $includeUserInfo;
    }

    public function toArray($request)
    {
        $formationsByChampionAndSlot = $this->formations->groupBy(function ($formation) {
            return $formation->champion_id . '-' . $formation->slot_table;
        })->map(function ($group) {
            $champion = $group->first()->champion;
            $items = $group->flatMap(function ($formation) {
                return $formation->items;
            });
    
            return [
                'champion' => [
                    'id' => $champion->id ?? null,
                    'name' => $champion->name ?? null,
                    'champion_img' => $champion ? url('image/champions/' . $champion->champion_img) : null,
                    'champion_icon' => $champion ? url('image/champions/' . $champion->champion_icon) : null,
                    'cost' => $champion->cost ?? null,
                    'ability' => $champion ? json_decode($champion->ability) : null,
                    'stats' => $champion ? json_decode($champion->stats) : null,
                    'synergies' => $champion->synergies->map(function ($synergy) {
                        return [
                            'name' => $synergy->name,
                            'img' => url('images/synergies/'.$synergy->icon_synergy),
                            'description' => $synergy->description ?? null,
                        ];
                    }),
                    'items' => $items->map(function ($item) {
                        return [
                            'id' => $item->id ?? null,
                            'name' => $item->name ?? null,
                            'item_bonus' => $item->item_bonus ?? null,
                            'image' => $item->object_img ? url('images/items/' . $item->object_img) : null,
                        ];
                    }),
                ],
                'star' => $group->first()->star ?? null,
                'slot_table' => $group->first()->slot_table ?? null,
            ];
        });
    
        $formationsArray = $formationsByChampionAndSlot->values();
    
        $augmentsWithDetails = $this->augments->map(function ($augmentComp) {
            return new AugmentDetailedResource($augmentComp->augment);
        });
    
        $augmentsGroupedByTier = $augmentsWithDetails->groupBy('tier');
    
        $synergyCounts = $this->formations->flatMap(function ($formation) {
            return $formation->champion->synergies;
        })->groupBy('name')->map(function ($synergies, $name) {
            $firstSynergy = $synergies->first();
            return [
                'count' => $synergies->count(),
                'img' => $firstSynergy ? url('images/synergies/' . $firstSynergy->icon_synergy) : null,
            ];
        });

        $response = [
            'id' => $this->id,
            'name' => $this->name,
            'likes' => $this->likes,
            'description' => $this->description,
            'playing_style' => $this->playing_style,
            'tier' => $this->tier,
            'difficulty' => $this->difficulty,
            'formations' => $formationsArray,
            'prio_carrusel' => PrioCarruselResource::collection($this->prioCarrusel),
            'augments' => [
                'tier_1' => $augmentsGroupedByTier->get('1', []),
                'tier_2' => $augmentsGroupedByTier->get('2', []),
                'tier_3' => $augmentsGroupedByTier->get('3', []),
            ],
            'synergy_counts' => $synergyCounts,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        if ($this->includeUserInfo) {
            $user = $this->users->first();
            $response['user'] = [
                'name' => $user->name ?? null,
            ];
            $response['last_updated'] = $this->updated_at->toDateTimeString();
        }
    
        return $response;
    }
}