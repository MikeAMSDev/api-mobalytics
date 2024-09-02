<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AugmentComp extends Model
{
    use HasFactory;

    protected $table = 'augment_comp';

    protected $fillable = [
        'composition_id',
        'augment_id',
    ];

    public function augment()
    {
        return $this->belongsTo(Augment::class, 'augment_id');
    }
}
