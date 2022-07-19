<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotCollectionPoint extends Model
{
    use hasFactory;
    protected $fillable = [
        'name',
        'is_active'
    ];
    public function lots()
    {
        return $this->belongsToMany(Lot::class);
    }
}
