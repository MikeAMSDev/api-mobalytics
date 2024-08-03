<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name', 'description', 'tier', 'object_img', 'recipes_id', 'type_object'];

    public function champions()
    {
        return $this->belongsToMany(Champion::class);
    }

    public function recipe()
    {
        return $this->hasOne(Recipe::class);
    }
}
