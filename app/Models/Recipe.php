<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'name', 'description', 'base_item_id', 'combined_item_id'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
