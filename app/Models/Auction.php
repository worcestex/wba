<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'start_date_time',
        'end_date_time',
    ];

    public function lots()
    {
        return $this->hasMany(Lot::class);
    }

    public function winningBids()
    {
        return $this->hasMany(WinningBid::class);
    }

}
