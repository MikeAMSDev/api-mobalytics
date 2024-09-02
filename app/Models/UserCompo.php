<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCompo extends Model
{
    use HasFactory;
    protected $table = 'user_compo';

    protected $fillable = ['id','user_id', 'composition_id']; 

    public function composition()
    {
        return $this->belongsTo(Composition::class, 'composition_id');
    }
}
