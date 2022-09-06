<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWishList extends Model
{
    use HasFactory;

    protected $fillable = [
        'lot_id',
        'user_id',
    ];
    public function lot() { 
        return $this->belongsTo(Lot::class); 
       }
}
