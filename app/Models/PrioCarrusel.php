<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrioCarrusel extends Model
{
    use HasFactory;

    protected $table = 'prio_carrusel';

    protected $fillable = [
        'composition_id',
        'item_id',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
