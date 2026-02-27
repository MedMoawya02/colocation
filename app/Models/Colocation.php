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
        return $this->belongsToMany(User::class, 'membership','colocation_id',
        'user_id')
            ->withPivot('role','left_at')
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

    public function balances(){
        $members=$this->users;
        $totalAmount=$this->expenses()->sum('amount');
        $sharedAmount=$totalAmount/$members->count();
        $balances=[];
        foreach ($members as $member) {
            $paid=$this->expenses->where('user_id',$member->id)->sum('amount');
            $balances[$member->name]=$paid-$sharedAmount;
        }
        return $balances;
    }
}
