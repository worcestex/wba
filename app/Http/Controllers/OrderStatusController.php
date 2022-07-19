<?php

namespace App\Http\Controllers;

use App\Models\OrderStatus;


use Illuminate\Http\Request;

//https://www.whiskybull.com/admin/order-status


class OrderStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return OrderStatus::all();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //  
        $orderStatus = new OrderStatus($request->all());
        $orderStatus->save();

        return response()->json(['message' => 'Successful', 'data' => $request->all()], 201);


        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //

        $orderStatus = OrderStatus::find($id);


    
        if (!$orderStatus) {
            return response()->json(['message' => 'Lot not Found'], 404);
        }


        // create lot
        $orderStatus->update($request->all());
        $orderStatus->save();      
    
        return response()->json(['data' => 'Uploaded Successfully'], 201);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($request)
    {   

        
        $orderStatus = OrderStatus::find($request);
        if(!$orderStatus){
            return response()->json(['message' => 'Lot collection point not found'], 404);

        }
        else{
            OrderStatus::find($request)->delete();
            return response()->json(['message' => 'Deleted'], 202);
        }
    }
}
