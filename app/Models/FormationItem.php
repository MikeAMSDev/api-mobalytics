<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormationItem extends Model
{
    use HasFactory;

    protected $table = 'formation_item';

    protected $fillable = ['id' , 'formation_id', 'item_id' ,'compo_id'];

    public function composition()
    {
        return $this->belongsTo(Composition::class, 'compo_id');
    }
}
