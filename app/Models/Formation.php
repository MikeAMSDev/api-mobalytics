<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory;

    protected $fillable = ['id','slot_table','champion_id' ,'compo_id', 'item_id' ,'star'];

    public function composition()
    {
        return $this->belongsTo(Composition::class, 'compo_id');
    }
}
