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
        return $this->belongsToMany(Item::class, 'champion_item', 'champion_id', 'item_id');
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

    public static function getChampionsWithFilters($filters = [])
    {
        $query = self::query();

        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        if (!empty($filters['synergy'])) {
            $query->whereHas('synergies', function ($q) use ($filters) {
                $q->where('name', $filters['synergy']);
            });
        }

        if (!empty($filters['cost'])) {
            $query->where('cost', $filters['cost']);
        }

        if (!empty($filters['alphabetical_order']) && $filters['alphabetical_order'] === 'asc') {
            $query->orderBy('name', 'asc');
        } elseif (!empty($filters['alphabetical_order']) && $filters['alphabetical_order'] === 'desc') {
            $query->orderBy('name', 'desc');
        }

        return $query->with(['synergies', 'items'])->get();
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
        $champion = self::with([
            'synergies.champions.synergies',
            'synergies.champions.items',
            'items.recipes.components'
        ])->where('name', $name)->first();
        
        if (!$champion) {
            return response()->json([
                'error' => 'Champion not found'
            ], 404);
        }
        
        return $champion;
    }

}
