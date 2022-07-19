<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWatchlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'lot_id',
        'user_id',
    ];
}
