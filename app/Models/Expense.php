<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'colocation_id',
        'title',
        'user_id',
        'amount',
        'category_id',
    ];
      public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class); 
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
