<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'isActive',
        'is_banned',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function colocations(){
        return $this->belongsToMany(Colocation::class,'membership','user_id',
        'colocation_id')->withPivot('role','left_at')->withTimestamps();
    }


    public function activeColocation(){
        return $this->belongsToMany(Colocation::class,'membership','user_id',
        'colocation_id')->withPivot('role','left_at')->where('isActive',1)->with('users')->withTimestamps()->first();
    }

    public function expenses(){
        return $this->belongsToMany(Expense::class,'paiments')->withPivot('amount_due', 'is_paid', 'paid_at')
                ->withTimestamps();
    }
    public function isAdmin(){
        return $this->role==='admin';
    }
}
