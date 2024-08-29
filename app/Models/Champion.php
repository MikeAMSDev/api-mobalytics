<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Champion extends Model
{
    use HasFactory;

    protected $fillable = ['id','name', 'description', 'cost', 'tier', 'champion_img', 'set_version', 'stats'];

    public function synergy()
    {
        return $this->hasMany(Synergy::class);
    }

    public function composition()
    {
        return $this->hasMany(Composition::class);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class);
    }

    public function synergies()
    {
        return $this->belongsToMany(Synergy::class, 'champion_synergy', 'champion_id', 'synergy_id');
    }
    protected $table = 'champions';

    public function formation()
    {
        return $this->belongsToMany(Composition::class, 'formation', 'champion_id', 'compo_id')
                    ->withPivot('slot_table')
                    ->withTimestamps();
    }

    public static function getChampion($typeTier = null, $cost = null, $classSynergy = null, $originSynergy = null){
        $query = self::query();

        if ($typeTier) {
            $query->where('name', $typeTier);
        }

        if ($cost) {
            $query->where('cost', $cost);
        }

        if ($classSynergy) {
            $query->whereHas('synergies', function ($q) use ($classSynergy) {
                $q->where('name', $classSynergy)
                  ->where('type', 'Classes');
            });
        }
    
        if ($originSynergy) {
            $query->whereHas('synergies', function ($q) use ($originSynergy) {
                $q->where('name', $originSynergy)
                  ->where('type', 'Origins');
            });
        }

        $champions = $query->with(['synergies'])->get();
        
        if ($champions->isEmpty()) {
            return response()->json([
                'error' => 'No champions found matching the given criteria.'
            ], 404);
        }

        return $query->with(['synergies'])->get();

    }

    public static function findOrFailChampions($name)
    {
        $champion = self::with(['synergies.champions.synergies'])->where('name', $name)->first();
    
        if (!$champion) {
            return response()->json([
                'error' => 'Champion not found'
            ], 404);
        }
    
        return $champion;
    }

}
