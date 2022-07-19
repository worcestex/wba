<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WinningBid extends Model
{
    use HasFactory;

    public function bid()
    {
        return $this->belongsTo(Bid::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lot()
    {
        return $this->belongsTo(Lot::class);
    }

    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }
}
