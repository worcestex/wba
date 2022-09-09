<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\BidIncrement;
use App\Models\Lot;
use App\Models\User;
use App\Events\AuctionEndEvent;



use Carbon\Carbon;
use Illuminate\Http\Request;

//https://www.whiskybull.com/admin/bids

class BidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // admin only
        return Bid::all();


        // for auth user
        // shows all users bids
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if(Auth()->user()->allowed_to_bid)
        {

            
            // auth users to current auctions
            // allow $user place bid to an item if $item->auction->is_active;

            $lot = Lot::find($request->lot_id);
            $auction = Auction::find($lot->auction_id);

            // check that lot exists
            if (!$lot) {
                return response()->json(['message' => 'Lot not Found'], 404);
            }

            // check that auction is active
            if (!$auction || $auction->start_date_time > Carbon::now() || $auction->end_date_time < Carbon::now()) {
                return response()->json(['message' => 'Current auction not Found'], 404);
            }

            $latestBid = Bid::where('lot_id', $lot->id)->orderBy('bid_amount', 'DESC')->first();
            $bidIncrement = BidIncrement::find($lot->bid_increment_id);
            $minBid = $bidIncrement->min_bid;
            $maxBid = $bidIncrement->max_bid;
            $stepSize = $bidIncrement->step_size;



            // check if there is a previous bid
            if (!$latestBid) {
                // if bid is smaller than min price + bid increment -> error: bid too low
                if ($request->bid_amount < ($lot->min_price + $minBid) || $request->bid_amount > ($lot->min_price + $maxBid)) {
                    return response()->json(['message' => 'Bid amount out of range'.$minBid."-".$maxBid], 406);
                    // else - place bid
                } else {
                    $lot->winning_bid =$request->bid_amount;

                    $lot->save();
                    return $this->placeBid($request);
                }
            } else {
                // if bid is smaller or bigger than $latestBid + bid increment -> return error
                if ($request->bid_amount < ($latestBid->bid_amount + $minBid) || $request->bid_amount > ($latestBid->bid_amount + $maxBid)) {
                    return response()->json(['message' => 'Bid amount not allowed'], 406);
                } else {
                    // else -> place bid
                    $latestBid->update(['winning_bid' => false]);
                    $lot->winning_bid = $request->bid_amount;
                    $lot->save();

                    return $this->placeBid($request);
                }
            }
        }
        return response()->json(['message' => 'Not Allowed to bid'], 406);

    }

    private function placeBid($request)
    {
        $bid = new Bid();
        $bid->bid_amount = $request->bid_amount;
        $bid->user_id = auth()->user()->id;
        $bid->winning_bid = true;

        // This data will need to be retrieve  externally
        $bid->bid_amount_in_currency = $request->bid_amount;
        $bid->currency = 'GBP';

        $bid->lot_id = $request->lot_id;
        $bid->start_date_time = Carbon::now();
        $bid->save();
        broadcast(new AuctionEndEvent());

        return response()->json(['message' => 'Successful', 'data' => $bid], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        // for admin
        // shows bid with id == $id

        //for user
        //show bid with id $id only if $bid->user_id = auth()->user()->id;
        $bid = Bid::find($id);
        if ($bid) {
            if (auth()->user()->id === $bid->user_id) {
                return response()->json(['message' => 'Successful', 'data' => $bid], 201);
            } else {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
        } else {
            return response()->json(['message' => 'Not found'], 404);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // Delete bid
        $bid = Bid::find($request->bidId);
        if(!$bid){
            return response()->json(['message' => 'Bid not found'], 404);

        }
        else{
            Bid::find($request->bidId)->delete();
            return response()->json(['message' => 'Deleted'], 202);
        }

    }


    public function fetchItemsFromLatestBids()
    {
        $bids = Bid::where('start_date_time', '<', Carbon::now())
        ->orderBy('start_date_time', 'DESC')
        ->select('start_date_time','id','bid_amount','currency','user_id')
        ->get();

        return $this->getItemsFromBids($bids);
    }
        /**
     * @param $pastAuctions
     * @return \Illuminate\Http\JsonResponse
     */
    private function getItemsFromBids($bids): \Illuminate\Http\JsonResponse
    {
        return response()->json(['message' => 'Successful', 'data' => $bids], 201);

    }
}
