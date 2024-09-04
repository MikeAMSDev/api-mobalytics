<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;

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
                throw new Exception("You cannot have more than 2 champions with the ID {$championId}.");
            }
        }
    
        $slots = [];
        foreach ($formationsData as $formation) {
            $slot = $formation['slot_table'];
            if ($slot < 1 || $slot > 28) {
                throw new Exception('The slot_table coordinate must be between 1 and 28.');
            }
            if (in_array($slot, $slots)) {
                throw new Exception('Each champion must be at a different coordinate.');
            }
            $slots[] = $slot;
        }

        $validTiers = [1, 2, 3];
        foreach ($augmentsData as $tier => $augmentIds) {
            if (!in_array($tier, $validTiers)) {
                throw new Exception("Invalid tier value {$tier}. Allowed values are 1, 2, and 3.");
            }
    
            if (count($augmentIds) > 3) {
                throw new Exception("You cannot have more than 3 augments for tier {$tier}.");
            }
    
            foreach ($augmentIds as $augmentId) {
                $augment = Augment::find($augmentId);
                if (!$augment) {
                    throw new Exception("Augment with ID {$augmentId} does not exist.");
                }
                if ($augment->tier != $tier) {
                    throw new Exception("Augment with ID {$augmentId} does not match the specified tier {$tier}.");
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
                    throw new Exception("The champion with ID {$championId} in the instance {$instanceKey} cannot have more than 3 items in total.");
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

    public static function updateComposition($id, array $compositionData, array $formationsData, array $prioCarruselData, array $augmentsData)
    {
        return DB::transaction(function () use ($id, $compositionData, $formationsData, $prioCarruselData, $augmentsData) {
            // Encuentra o falla si no se encuentra la composición
            $composition = self::findOrFail($id);
            $composition->update($compositionData);

            // Eliminar formaciones antiguas
            Formation::where('compo_id', $composition->id)->delete();
            // Eliminar prio_carrusel antiguo
            PrioCarrusel::where('composition_id', $composition->id)->delete();
            // Eliminar augments antiguos
            AugmentComp::where('composition_id', $composition->id)->delete();

            // Validar coordenadas únicas en slot_table
            $slots = [];
            foreach ($formationsData as $formation) {
                $slot = $formation['slot_table'];
                if (in_array($slot, $slots)) {
                    throw new Exception("The slot_table coordinate {$slot} is duplicated.");
                }
                $slots[] = $slot;
            }

            // Validar campeones duplicados
            $championCounts = array_count_values(array_column($formationsData, 'champion_id'));
            foreach ($championCounts as $championId => $count) {
                if ($count > 2) {
                    throw new Exception("You cannot have more than 2 champions with the ID {$championId}.");
                }
            }

            // Insertar nuevas formaciones
            $championItemCounts = [];
            foreach ($formationsData as $index => $formationData) {
                $itemIds = $formationData['item_ids'] ?? [];
                $championId = $formationData['champion_id'];
                $slotTable = $formationData['slot_table'];
                $star = $formationData['star'];

                $instanceKey = $index;
                if (!isset($championItemCounts[$instanceKey])) {
                    $championItemCounts[$instanceKey] = 0;
                }

                $currentItemCount = count($itemIds);
                $totalItemCount = $championItemCounts[$instanceKey] + $currentItemCount;

                if ($totalItemCount > 3) {
                    throw new Exception("The champion with ID {$championId} cannot have more than 3 items in total.");
                }

                $championItemCounts[$instanceKey] = $totalItemCount;

                foreach ($itemIds as $itemId) {
                    Formation::create([
                        'champion_id' => $championId,
                        'slot_table' => $slotTable,
                        'compo_id' => $composition->id,
                        'star' => $star,
                        'item_id' => $itemId
                    ]);
                }

                if (empty($itemIds)) {
                    Formation::create([
                        'champion_id' => $championId,
                        'slot_table' => $slotTable,
                        'compo_id' => $composition->id,
                        'star' => $star,
                        'item_id' => null
                    ]);
                }
            }

            // Validar y Insertar prio_carrusel
            $uniquePrioCarruselItems = array_unique(array_column($prioCarruselData, 'item_id'));
            if (count($uniquePrioCarruselItems) != count($prioCarruselData)) {
                throw new Exception("Duplicate items are not allowed in prio_carrusel.");
            }

            foreach ($prioCarruselData as $prioCarruselItem) {
                $item = Item::findOrFail($prioCarruselItem['item_id']); // Asumiendo que tienes un modelo Item
                if ($item->type_object !== 'Basic') {
                    throw new Exception("Only Basic items are allowed in prio_carrusel. Item ID {$item->id} is not a Basic item.");
                }

                PrioCarrusel::create([
                    'composition_id' => $composition->id,
                    'item_id' => $prioCarruselItem['item_id'],
                ]);
            }

            // Validar y Insertar augments
            $tierLimits = [
                1 => 3,
                2 => 3,
                3 => 3
            ];

            $validAugmentsData = [
                1 => [],
                2 => [],
                3 => []
            ];

            foreach ($augmentsData as $tier => $augmentIds) {
                if (!isset($tierLimits[$tier])) {
                    throw new Exception("Invalid tier specified.");
                }

                if (count($augmentIds) > $tierLimits[$tier]) {
                    throw new Exception("Cannot have more than {$tierLimits[$tier]} augments for tier {$tier}.");
                }

                foreach ($augmentIds as $augmentId) {
                    $augment = Augment::findOrFail($augmentId);
                    if ($augment->tier != $tier) {
                        throw new Exception("Augment with ID {$augmentId} does not match the specified tier {$tier}.");
                    }
                    $validAugmentsData[$tier][] = $augmentId;
                }
            }

            foreach ($validAugmentsData as $tier => $augmentIds) {
                foreach ($augmentIds as $augmentId) {
                    AugmentComp::create([
                        'composition_id' => $composition->id,
                        'augment_id' => $augmentId,
                    ]);
                }
            }

            return $composition;
        });
    }

    public function deleteComposition()
    {
        DB::beginTransaction();

        try {
            $this->formations()->delete();
            $this->prioCarrusel()->delete();
            $this->augments()->delete();
            $this->userCompo()->delete();

            $this->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Failed to delete composition: ' . $e->getMessage());
        }
    }

    public static function getComposition($typeSynergy = null)
    {
        $query = self::query();
        
        if ($typeSynergy) {
            $query->where('type', $typeSynergy);
        }
    
        // Asegúrate de que las relaciones están bien definidas en los modelos relacionados
        return $query->with([
            'formations.champion.synergies',
            'formations.items', // Cargar los items directamente desde la relación
            'augments',
        ])->get();
    }
}

