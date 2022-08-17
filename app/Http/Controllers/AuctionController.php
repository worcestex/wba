<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Lot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;


//https://www.whiskybull.com/admin/auctions
class AuctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return Auction::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'start_date_time'  => 'required',
            'end_date_time'  => 'required'
        ]);


        if($request->start_date_time > $request->end_date_time)
        {
            return response()->json(['message' => 'Invalid Date'], 201);

        }

        $auction = new Auction($request->all());

        $auction->lots=0;
        $auction->views=0;
        // Insert request to database
        $auction->save();

        return response()->json(['message' => 'Successful', 'data' => 'test'], 201);


    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Auction $auctionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($auctionId)
    {
        $auction = Auction::find($auctionId);
        if (auth()->user()->id) {
            return response()->json(['data' => $auction], 201);
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Auction $auction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $auction = Auction::find($id);


    
        if (!$auction) {
            return response()->json(['message' => 'Lot not Found'], 404);
        }



        //Update lots in auction table
        $auction->lots = $this->updateLots($auction);



        $auction->update($request->all());
        $auction->save();      
    
        return response()->json(['data' => 'Uploaded Successfully'], 201);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Auction $auction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Auction $auction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchNextAuction()
    {
        $nextAuction = Auction::orderBy('start_date_time', 'ASC')
            ->where('start_date_time', '>', Carbon::now())
            ->first();

        return $nextAuction
            ? response()->json(['message' => 'Successful', 'data' => $nextAuction], 201)
            : response()->json(['message' => 'Not found'], 404);
    }

    public function fetchItemsFromPastAuctions()
    {
        $auctions = Auction::where('end_date_time', '<', Carbon::now())
            ->orderBy('end_date_time', 'DESC')
            ->select('id')
            ->get();

        return $this->getItemsFromAuctions($auctions);
    }

    public function fetchItemsFromCurrentAuctions()
    {
        $auctions = Auction::where('start_date_time', '<', Carbon::now())
            ->where('end_date_time', '>', Carbon::now())
            ->orderBy('start_date_time', 'ASC')
            ->select('id')
            ->get();

        return $this->getItemsFromAuctions($auctions);
    }

    /**
     * @param $pastAuctions
     * @return \Illuminate\Http\JsonResponse
     */
    private function getItemsFromAuctions($auctions): \Illuminate\Http\JsonResponse
    {
        if (!$auctions || $auctions->isEmpty()) {
            return response()->json(['message' => 'Not found'], 404);
        } else {
            $itemsFromAuctions = [];
            foreach ($auctions as $auction) {
                array_push($itemsFromAuctions, $auction->lots()->get());
            }
            $itemsFromAuctionsData = Arr::collapse($itemsFromAuctions);
            return response()->json(['message' => 'Successful', 'data' => $itemsFromAuctionsData], 201);
        }
    }
    private function updateLots($auction){

        $lots = Lot::where('auction_id', '=', $auction->id)->get();
        $numLots = $lots->count();

        return $numLots;

    }

}
