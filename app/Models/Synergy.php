<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Synergy extends Model
{
    use HasFactory;

    protected $fillable  = ['id', 'name', 'description', 'icon_synergy', 'synergy_activation','set_version'];

    public const VALID_TYPE_SYNERGY =['Origins', 'Classes'];

    public function champions()
    {
        return $this->belongsToMany(Champion::class, 'champion_synergy', 'synergy_id', 'champion_id');
    }

    public function compositions()
    {
        return $this->belongsToMany(Composition::class);
    }

    public static function getSynergyWithType($typeSynergy = null)
    {

        $query = self::query();

        if ($typeSynergy && !in_array($typeSynergy, self::VALID_TYPE_SYNERGY)) {
            return response()->json(['error' => 'Invalid type value.'], 400);
        }

        if ($typeSynergy) {
            $query->where('type', $typeSynergy);
        }

        return $query->with('champions')->get()->map(function ($synergies) {
            return [
                'id' => $synergies->id,
                'name' => $synergies->name,
                'type' => $synergies->type,
                'icon_synergy' => $synergies->icon_synergy,
                'description' => $synergies->description,
                'synergy_activation' => $synergies->synergy_activation,
                'set_version' => $synergies->set_version,
                'good_for' => $synergies->champions->map(function ($champion) {
                    return [
                        'id' => $champion->id,
                        'name' => $champion->name,
                        'description' => $champion->description,
                        'cost' => $champion->cost,
                        'champion_img' => url('images/champions/' . $champion->champion_img),
                        'ability' => $champion->ability,
                        'champion_icon' => url('images/champions/' . $champion->champion_icon),
                        'set_version' => $champion->set_version,
                        'stats' => $champion->stats,
                    ];
                }),
            ];
        });
    }
}
