<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemRecipe extends Model
{
    use HasFactory;

    protected $table = 'item_recipe';

    protected $fillable = ['id','recipe_id', 'item_id']; 

    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id');
    }
    
}
