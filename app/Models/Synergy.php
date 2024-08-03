<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Synergy extends Model
{
    use HasFactory;

    protected $fillable  = ['id', 'name', 'description', 'icon_synergy', 'synergy_img', 'synergy_activation','set_version'];

    public function champions()
    {
        return $this->hasMany(Champion::class);
    }
}
