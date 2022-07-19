<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lot extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'auction_id',
        'description',
        'price',
        'distillery',
        'distillery_status',
        'country',
        'region',
        'size',
        'type',
        'age',
        'number_of_bottles',
        'strength',
        'shipping_weight',
        'seller_id',
        'starting_price',
        'buy_it_now_price'
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lotProperties()
    {
        return $this->hasMany(LotProperty::class);
    }

    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    public function bidIncrement()
    {
        return $this->hasOne(BidIncrement::class);
    }

}
