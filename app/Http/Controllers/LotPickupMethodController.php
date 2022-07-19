<?php

namespace App\Http\Controllers;

use App\Models\LotPickupMethod;


use Illuminate\Http\Request;

//https://www.whiskybull.com/admin/lot-pickup

class LotPickupMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return LotPickupMethod::all();

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


        $lotDeliveryMethod = new LotPickupMethod($request->all());
        $lotDeliveryMethod->save();

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

        $lotDeliveryMethod = LotPickupMethod::find($id);


        // If delivery method exists
        if (!$lotDeliveryMethod) {
            return response()->json(['message' => 'Lot delivery not Found'], 404);
        }


        // create lot
        $lotDeliveryMethod->update($request->all());
        $lotDeliveryMethod->save();      
    
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

        
        $lotDeliveryMethod = LotPickupMethod::find($request);
        if(!$lotDeliveryMethod){
            return response()->json(['message' => 'Lot collection point not found'], 404);

        }
        else{
            LotPickupMethod::find($request)->delete();
            return response()->json(['message' => 'Deleted'], 202);
        }
    }
}
