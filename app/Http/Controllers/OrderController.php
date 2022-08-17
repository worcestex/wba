<?php

namespace App\Http\Controllers;

use App\Models\Order;


use Illuminate\Http\Request;

//https://www.whiskybull.com/shop/admin/orders/manage.orders.php

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // for admins
        // admin only
        if(auth()->user()){
            return Order::all();

        }
        return Order::all();

        //for users
        // list orders with user_id == auth()->user()->id;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //for user
        // place new order

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //for admin
        // show order where id == $id

        //for user
        // show order where id == $id if $order->user_id === auth()->user()->id
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $order = Order::find($id);


    
        if (!$order) {
            return response()->json(['message' => 'Lot not Found'], 404);
        }


        // create lot
        $order->update($request->all());
        $order->save();      
    
        return response()->json(['data' => 'Uploaded Successfully'], 201);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // for admin
        // delete order->id
    }


    public function unpaidOrders(){
        
        return Order::where("is_payment_confirmed", 1)->get();
    }

    public function getUserUnpaidOrders(){
        $user = auth()->user();
        return Order::where("buyer_id", $user->id)->where("is_payment_confirmed", 0)->get();
    }
    public function getUserPaidOrders(){
        $user = auth()->user();
        return Order::where("buyer_id", $user->id)->where("is_payment_confirmed", 1)->get();
    }


}
