<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Composition extends Model
{
    use HasFactory;

    protected $fillable = ['id','name', 'synergy', 'description','tier','difficulty','prio_carrusel','playing_style', 'champ_compo', 'augments_id','formation_id']; 

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function augments()
    {
        return $this->hasMany(Augment::class);
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

    public static function createWithFormations(array $compositionData, array $formationsData, int $userId)
    {
        return DB::transaction(function () use ($compositionData, $formationsData, $userId) {

            $composition = self::create($compositionData);

            foreach ($formationsData as $formationData) {
                $itemIds = $formationData['item_ids'] ?? [];

                foreach ($itemIds as $itemId) {
                    Formation::create([
                        'champion_id' => $formationData['champion_id'],
                        'slot_table' => $formationData['slot_table'],
                        'compo_id' => $composition->id,
                        'star' => $formationData['star'],
                        'item_id' => $itemId
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

