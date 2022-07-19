<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliverySubZone extends Model
{
    use HasFactory;

    public $fillable = [ 

        'name',


    ]; 
    public function deliverySubZones()
    {
        return $this->belongsTo(DeliveryZone::class);
    }
}
