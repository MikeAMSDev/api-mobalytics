<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Synergy extends Model
{
    use HasFactory;

    protected $fillable  = ['id', 'name','type', 'description', 'icon_synergy', 'synergy_activation','set_version'];

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

        return $query->with(['champions.synergies'])->get();
    }

    public static function findOrFailWithChampions($id)
    {
        $synergy = self::with('champions')->find($id);

        if (!$synergy) {
            abort(404, 'Synergy not found');
        }

        return $synergy;
    }
    
    public static function createSynergy(array $data)
    {
        return self::create($data);
    }

    public function updateSynergy(array $data)
    {
        return $this->update($data);
    }

    public function deleteSynergy()
    {
        DB::table('champion_synergy')->where('synergy_id', $this->id)->delete();

        $this->delete();
    }
}
