<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BidIncrement;


class BidIncrementController extends Controller
{   

    

   public function update(Request $request, $id)
   {

    // Check if money
    if(!preg_match("/^\d+(\.\d{1,2})?$/",$request->min_bid)) 
    {
        return response()->json(['message' => 'Wrong Format'], 406);
    }

    $current_bid_increment = BidIncrement::find($id);
    $previous_bid_increment = BidIncrement::find($id-1);



    //Update current min and previous max-0.01 value
    $current_bid_increment->update(['min_bid' => $request->min_bid]);
    $previous_bid_increment->update(['max_bid' => ($request->min_bid)-0.01]);




    return response()->json(['message' => $current_bid_increment->min_bid], 200);
   }

   public function show()
   {
       // for admin
       // shows all of the bid increments

       $bidIncrement = BidIncrement::all();
       
       return response()->json(['message' => 'Successful', 'data' => $bidIncrement], 201);
       if ($bidIncrement) {
     
               return response()->json(['message' => 'Successful', 'data' => $bidIncrement], 201);

       } else {
           return response()->json(['message' => 'Not found'], 404);
       }
   }


}
