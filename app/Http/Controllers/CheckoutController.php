<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;


class CheckoutController extends Controller
{
    public function checkoutItems()
    {
        
        $user = auth()->user();
        
        // calculate subtotal
        $total = Order::where('buyer_id',$user->id)->sum('total_amount');
        
        
        
        
        
        return response()->json(['message'=> 'Checkout', 'data' => $total], 200);

    }
}
