<?php

namespace App\Http\Controllers;

use App\Models\LotRules;


use Illuminate\Http\Request;

//https://www.whiskybull.com/admin/lots/complementary


class LotRulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return LotRules::all();

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
        $lotRules = new LotRules($request->all());
        $lotRules->save();

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

        $lotRules = LotRules::find($id);


    
        if (!$lotRules) {
            return response()->json(['message' => 'Lot not Found'], 404);
        }


        // create lot
        $lotRules->update($request->all());
        $lotRules->save();      
    
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

        
        $lotRules = LotRules::find($request);
        if(!$lotRules){
            return response()->json(['message' => 'Lot collection point not found'], 404);

        }
        else{
            LotRules::find($request)->delete();
            return response()->json(['message' => 'Deleted'], 202);
        }
    }
}
