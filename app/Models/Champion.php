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

    protected $table = 'champions';

    public function formation()
    {
        return $this->belongsToMany(Composition::class, 'formation', 'champion_id', 'compo_id')
                    ->withPivot('slot_table')
                    ->withTimestamps();
    }

}
