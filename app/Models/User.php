<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable;

class User extends Authenticatable implements MustVerifyEmail
{

    use HasApiTokens, HasFactory, Notifiable, CanResetPassword, Billable;

    

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'first_name',
        'last_name',
        'contact_number',
        'mobile_number' ,
        'address_1' ,
        'address_2' ,
        'city'  ,
        'country' ,
        'postcode',
        'billing_address_1',
        'billing_address_2',
        'billing_postcode',
        'billing_country',
        'shipping_address_1',
        'shipping_address_2',
        'shipping_postcode',
        'shipping_country',


    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function winningBids()
    {
        return $this->hasMany(WinningBid::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function lots()
    {
        return $this->hasMany(Lot::class);
    }

    public function lotStorages()
    {
        return $this->hasMany(LotStorage::class);
    }

    static function generateUserIdKey(User $user): string
    {
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $day = Carbon::now()->day;
        return $user->id . $year . $day . $month;
    }
}
