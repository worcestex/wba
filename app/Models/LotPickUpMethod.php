<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotPickupMethod extends Model
{
    use hasFactory;
    protected $fillable = [
        'name',
        'description',
        'has_date_picker',
        'has_collection_points',
        'sends_reminder',
        'reminder'
    ];
    public function lots()
    {
        return $this->belongsToMany(Lot::class);
    }
}
