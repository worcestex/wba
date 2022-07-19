<?php

namespace App\Http\Controllers;

use App\Models\Lot;
use App\Models\UserWishList;
use Illuminate\Http\Request;

class UserWishListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserWishList::all();
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
        } else if (UserWishList::where([
            ['user_id', auth()->user()->id],
            ['lot_id', $request->lot_id]
        ])->first()) {
            return response()->json(['message' => 'You already added this lot to your wishlist'], 406);
        } else {
            $wishlist = new UserWishList();
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
        $wishlist = UserWishList::where('user_id', auth()->user()->id)->select()->get();
        return response()->json(['message' => auth()->user()->id, 'data' => $wishlist], 202);
    }


    /**
     * Remove the specified resource from storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $wishListItem = UserWishList::find($request->wishListId);

        if (!$wishListItem) {
            return response()->json(['message' => 'Not found'], 404);
        } else if ($wishListItem->user_id !== auth()->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        } else {
            UserWishList::find($request->wishListId)->delete();
            return response()->json(['message' => 'Deleted'], 202);
        }
    }
}
