<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Composition extends Model
{
    use HasFactory;

    protected $fillable = ['id','name', 'synergy', 'description','tier','difficulty','playing_style', 'champ_compo', 'augments_id','formation_id']; 

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function champions()
    {
        return $this->hasMany(Champion::class);
    }

    protected $table = 'compositions';

    public function formation()
    {
        return $this->belongsToMany(Champion::class, 'formation', 'compo_id', 'champion_id')
                    ->withPivot('slot_table')
                    ->withTimestamps();
    }

    public function synergies()
    {
        return $this->belongsToMany(Synergy::class);
    }

    public function tier()
    {
        return $this->belongsTo(Tier::class);
    }

    public function formations()
    {
        return $this->hasMany(Formation::class, 'compo_id');
    }

    public function userCompo()
    {
        return $this->hasOne(UserCompo::class, 'composition_id');
    }

    public function prioCarrusel()
    {
        return $this->hasMany(PrioCarrusel::class, 'composition_id');
    }
    
    public function augments()
    {
        return $this->hasMany(AugmentComp::class, 'composition_id');
    }

    public function augmentsByTier($tier)
    {
        return $this->augments()->where('tier', $tier)->pluck('id');
    }

    public static function createWithFormations(array $compositionData, array $formationsData, array $prioCarruselData, array $augmentsData, int $userId)
    {
        $championCounts = array_count_values(array_column($formationsData, 'champion_id'));
        foreach ($championCounts as $championId => $count) {
            if ($count > 2) {
                throw new \Exception("You cannot have more than 2 champions with the ID {$championId}.");
            }
        }
    
        $slots = [];
        foreach ($formationsData as $formation) {
            $slot = $formation['slot_table'];
            if ($slot < 1 || $slot > 28) {
                throw new \Exception('The slot_table coordinate must be between 1 and 28.');
            }
            if (in_array($slot, $slots)) {
                throw new \Exception('Each champion must be at a different coordinate.');
            }
            $slots[] = $slot;
        }

        $validTiers = [1, 2, 3];
        foreach ($augmentsData as $tier => $augmentIds) {
            if (!in_array($tier, $validTiers)) {
                throw new \Exception("Invalid tier value {$tier}. Allowed values are 1, 2, and 3.");
            }
    
            if (count($augmentIds) > 3) {
                throw new \Exception("You cannot have more than 3 augments for tier {$tier}.");
            }
    
            foreach ($augmentIds as $augmentId) {
                $augment = Augment::find($augmentId);
                if (!$augment) {
                    throw new \Exception("Augment with ID {$augmentId} does not exist.");
                }
                if ($augment->tier != $tier) {
                    throw new \Exception("Augment with ID {$augmentId} does not match the specified tier {$tier}.");
                }
            }
        }
    
        return DB::transaction(function () use ($compositionData, $formationsData, $prioCarruselData, $augmentsData, $userId) {
            $composition = self::create($compositionData);

            $championItemCounts = [];
            foreach ($formationsData as $index => $formationData) {
                $championId = $formationData['champion_id'];
                $itemIds = $formationData['item_ids'] ?? [];
                $instanceKey = $index;
    
                if (!isset($championItemCounts[$instanceKey])) {
                    $championItemCounts[$instanceKey] = 0;
                }
    
                $currentItemCount = count($itemIds);
                $totalItemCount = $championItemCounts[$instanceKey] + $currentItemCount;
    
                if ($totalItemCount > 3) {
                    throw new \Exception("The champion with ID {$championId} in the instance {$instanceKey} cannot have more than 3 items in total.");
                }
    
                $championItemCounts[$instanceKey] = $totalItemCount;
    
                foreach ($itemIds as $itemId) {
                    Formation::create([
                        'champion_id' => $championId,
                        'slot_table' => $formationData['slot_table'],
                        'compo_id' => $composition->id,
                        'star' => $formationData['star'],
                        'item_id' => $itemId
                    ]);
                }
    
                if (empty($itemIds)) {
                    Formation::create([
                        'champion_id' => $championId,
                        'slot_table' => $formationData['slot_table'],
                        'compo_id' => $composition->id,
                        'star' => $formationData['star'],
                        'item_id' => null
                    ]);
                }
            }

            foreach ($prioCarruselData as $prioCarruselItem) {
                PrioCarrusel::create([
                    'composition_id' => $composition->id,
                    'item_id' => $prioCarruselItem['item_id'],
                ]);
            }

            foreach ($augmentsData as $tier => $augmentIds) {
                foreach ($augmentIds as $augmentId) {
                    AugmentComp::create([
                        'composition_id' => $composition->id,
                        'augment_id' => $augmentId,
                    ]);
                }
            }

            UserCompo::create([
                'user_id' => $userId,
                'composition_id' => $composition->id,
            ]);
    
            return $composition;
        });
    }
}

