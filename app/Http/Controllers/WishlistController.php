<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{
    public function getFavorites($id)
    {
        $Wishlist = Wishlist::where('user_id', $id)->get();
        return response()->json(['Wishlist' => $Wishlist]);
    }

    public function addtoWishlist(Request $request)
    {


        $wishlist = Wishlist::create([
            'tour_id' => $request->tour_id,
            'user_id' => $request->user_id
        ]);

        return response()->json([
            'wishlist' => $wishlist,
        ]);
    }

    public function removefromFav(Request $request)
    {

        DB::table('wishlists')->where('tour_id', $request->tour_id)->where('user_id', $request->user_id)->delete();

        return response()->json([
            'success' => 'Removed from wishlist successfully'
        ]);
    }

    public function getwishwithtours($id)
    {

        $wishLists = DB::table('wishlists')->join('tours', 'tours.id', '=', 'wishlists.tour_id')->where('wishlists.user_id', $id)->get();

        return response()->json([
            'wishlists' => $wishLists
        ]);
    }
}
