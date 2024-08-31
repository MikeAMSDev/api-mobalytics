<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'item_id'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_recipe');
    }
    public function itemRecipes()
    {
        return $this->hasMany(ItemRecipe::class, 'recipe_id');
    }

    public function components()
    {
        return $this->belongsToMany(Item::class, 'item_recipe', 'recipe_id', 'item_id');
    }
    
}