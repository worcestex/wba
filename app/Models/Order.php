<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use hasFactory;
    protected $fillable = [
        'order_id',
        'payment_method',
        'shipping_service',
        'starting_price',
        'buyer_id',
        'order_status_id',
        'number_of_boxes',
        'billing_country',
        'cost',
        'is_shipped',
        'shipment_details',
        'is_confirmation_sent',
        'delivery_cost',
        'vat_percentage_id',
        'vat_amount',
        'total_amount',
        'is_payment_confirmed',
        'client_ip'
    
    ];


    public function lots() {
        return $this->hasMany(Lot::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function vatRate() {
        return $this->hasOne(VatRate::class);
    }

    public function orderStatus() {
        return $this->hasOne(OrderStatus::class);
    }


}
