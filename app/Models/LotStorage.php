<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotStorage extends Model
{
    use hasFactory;

    public function lot()
    {
        return $this->hasOne(Lot::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
