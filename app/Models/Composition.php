<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

}

