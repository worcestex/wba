<?php

namespace App\Http\Controllers;

use App\Models\Lot;
use App\Models\User;
use App\Models\UserWatchlist;
use Illuminate\Http\Request;

class UserWatchlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserWatchlist::all();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if (!Lot::find($request->lot_id)) {
            return response()->json(['message' => 'Lot not found'], 404);
        } else if (UserWatchlist::where([
            ['user_id', auth()->user()->id],
            ['lot_id', $request->lot_id]
        ])->first()) {
            return response()->json(['message' => 'You already added this lot to your watchlist'], 406);

        } else {
            $wishlist = new UserWatchlist();
            $wishlist->user_id = auth()->user()->id;
            $wishlist->lot_id = $request->lot_id;
            $wishlist->save();
            return response()->json(['message' => 'Saved', 'data' => $wishlist], 202);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        $wishlist = UserWatchlist::where('user_id', auth()->user()->id)->select()->get();
        return response()->json(['message' => auth()->user()->id, 'data' => $wishlist], 202);
    }


    /**
     * Remove the specified resource from storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $watchListItem = UserWatchlist::find($request->watchlistId);

        if (!$watchListItem) {
            return response()->json(['message' => 'Not found'], 404);
        } else if ($watchListItem->user_id !== auth()->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        } else {
            UserWatchlist::find($request->watchlistId)->delete();
            return response()->json(['message' => 'Deleted'], 202);
        }
    }
}
