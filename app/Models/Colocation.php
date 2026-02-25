<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colocation extends Model
{
    protected $fillable = [
        'name',
        'isActive'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'membership')
            ->withPivot('role')
            ->withTimestamps();
    }
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
    public function invitation()
    {
        return $this->hasMany(Invitation::class);
    }

    public function isOwner(User $user){
        return $this->users()->where('user_id',$user->id)
                    ->wherePivot('role','owner')->exists();
    }
}
