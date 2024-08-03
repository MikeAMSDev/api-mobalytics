<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Augment extends Model
{
    use HasFactory;

    protected $fillable = ['id','name', 'description', 'augment_img', 'tier', 'set_version'];

    public function compos()
    {
        return $this->hasMany(Composition::class);
    }
}
