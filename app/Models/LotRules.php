<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotRules extends Model
{
    use hasFactory;

    public function lots()
    {
        return $this->belongsToMany(Lot::class);
    }
}
