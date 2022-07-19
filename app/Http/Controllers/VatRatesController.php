<?php

namespace App\Http\Controllers;

use App\Models\VatRate;


use Illuminate\Http\Request;

//https://www.whiskybull.com/admin/vat-rates


class VatRatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return VatRate::all();

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
        $vatRates = new VatRate($request->all());
        $vatRates->save();

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

        $vatRates = VatRate::find($id);


    
        if (!$vatRates) {
            return response()->json(['message' => 'Vat rate not Found'], 404);
        }


        // create lot
        $vatRates->update($request->all());
        $vatRates->save();      
    
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

        
        $vatRates = VatRate::find($request);
        if(!$vatRates){
            return response()->json(['message' => 'Vat rate not found'], 404);

        }
        else{
            VatRate::find($request)->delete();
            return response()->json(['message' => 'Deleted'], 202);
        }
    }
}
