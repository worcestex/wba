<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
        use hasFactory;

        public $table = 'order_status';

        protected $fillable = [
            'status',
            'email_text'

        ];

        public function orders()
        {
            return $this->belongsToMany(Order::class);
        }
}
