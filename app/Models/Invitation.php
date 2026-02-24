<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
     protected $fillable = [
        'colocation_id',
        'email',
        'token',
        'status',
    ];

    // Relation vers colocation
    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }
}
