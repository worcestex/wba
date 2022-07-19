<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\BidIncrement;
use App\Models\Lot;
use App\Models\Auction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

// https://www.whiskybull.com/shop/admin/products/manage.products.php

class LotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // admin only
        return Lot::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $auction = Auction::find($request->auction_id);
        if(!$auction){
            return response()->json(['message' => 'Successful', 'data' => 'Auction not found'], 201);

        }
        
        $request->validate([
            'name' => 'required',

        ]);

        // Ensure request has a starting value
        if(!$request->starting_price){
            $request->starting_price = 0;
        }
        
        //Get starting bid increment
        $bid_increment_id = BidIncrement::
        select('id')
        ->where('min_bid', '<=', $request->starting_price)
        ->where('max_bid','>=', $request->starting_price)
        ->get();
        

        

        $lot = new Lot($request->all());

    
        $lot->bid_increment_id = $bid_increment_id[0]->id;

        // Insert request to database
        $lot->save();

        return response()->json(['message' => 'Successful', 'data' => $lot->id], 201);


       
        
        
        //check auction and bid increment

        //set bid 
                
        
        // check has bid increment with id
        
    }

    /*
     * Display the specified resource.
     *
     * @param  \App\Models\Lot  $itemId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($lotId)
    {
        $lot = Lot::find($lotId);
            return response()->json(['data' => $lot], 201);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lot  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // only admin
        $request->validate([
            'name' => 'required',

        ]); 
        $lot = Lot::find($id);


    
        if (!$lot) {
            return response()->json(['message' => 'Lot not Found'], 404);
        }
    
        $auction = Auction::find($request->auction_id);
    
        if (!$auction) {
            return response()->json(['message' => 'Auction not Found'], 404);
        }

        // create lot
        $lot->update($request->all());
        $lot->save();      
    
        return response()->json(['data' => 'Uploaded Successfully'], 201);

    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lot  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        
        // Delete lot

        $lot = Lot::find($request->lotId);
        if(!$lot){
            return response()->json(['message' => 'Lot not found'], 404);

        }
        else{
            Lot::find($request->lotId)->delete();
            return response()->json(['message' => 'Deleted'], 202);
        }



        
    }

    /**
     * Upload image and store url against model
     *
     * @param $team
     * @param Request $request
     * @return JsonResponse
     */

    public function uploadImage(Request $request) {
        //
    }

    public function showLotBidHistory($id)
    {
        $lotBidHistory = Bid::where('lot_id', $id)->select('lot_id','bid_amount', 'start_date_time')->orderBy('bid_amount', 'DESC')->get();

        if (!$lotBidHistory || $lotBidHistory->isEmpty()) {
            return response()->json(['message' => 'Not found'], 404);
        }
            return response()->json(['message' => 'Successful', 'data' => $lotBidHistory], 201);
    }



}
