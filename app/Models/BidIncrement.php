<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidIncrement extends Model
{
    use HasFactory;

    protected $fillable = [
        'min_bid',
        'max_bid',
        'step_size',
    ];

    public function lots()
    {
        return $this->belongsToMany(Lot::class);
    }
}
