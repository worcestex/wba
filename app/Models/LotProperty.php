<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotProperty extends Model
{
    use hasFactory;

    public function lots()
    {
        return $this->belongsToMany(Lot::class);
    }
}
