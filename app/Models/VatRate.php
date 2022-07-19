<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VatRate extends Model
{
    use hasFactory;

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}
