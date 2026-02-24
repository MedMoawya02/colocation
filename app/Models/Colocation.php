<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colocation extends Model
{
     protected $fillable = [
        'name',
        'isActive'
    ];

    public function users(){
        return $this->belongsToMany(User::class,'membership');
    }

    public function invitation(){
        return $this->hasMany(Invitation::class);
    }
}
