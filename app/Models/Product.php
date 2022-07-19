<?php

namespace App\Models;

use App\Traits\Uuids;
use Database\Seeders\AuctionSeeder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected $casts = [];

}
