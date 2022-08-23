<?php

namespace App\Http\Controllers;

use App\Models\LotStorage;
use App\Models\Lot;


use Illuminate\Http\Request;

//https://www.whiskybull.com/admin/storage/

class LotStorageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(auth()->user()->business_member){
            return LotStorage::all();

        }
        return Lot::join('lot_storages','lot_storages.lot_id','=','lots.id')->where('lot_storages.buyer_id',auth()->user()->id)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $slot_price = 20.00;

        $user = $request->user();

        $paymentMethods = $user->paymentMethods();

        $user->charge($slot_price*100, $paymentMethods[0]->id);

        $lot = Lot::where('seller_id',$request->user()->id)->where('id', $request->lot_id )->first();
        if(!$lot){
            return response()->json(['message' => 'No lot found for this user'], 404);

        }


        $lot_storage = new LotStorage();
        $lot_storage->lot_id = $request->lot_id;
        $lot_storage->buyer_id = $request->user()->id;
        $lot_storage->save();

        return response()->json(['message' => 'Successful', 'data' => $request->all()], 201);

    /*


        */
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $lot_storage = LotStorage::find($id);
        if(!$lot_storage){
            return response()->json(['message' => 'Lot collection point not found'], 404);

        }
        else{
            LotStorage::find($id)->delete();
            return response()->json(['message' => 'Deleted'], 202);
        }
    }
}
