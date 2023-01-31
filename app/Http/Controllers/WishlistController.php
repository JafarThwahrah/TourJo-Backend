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

        $wishLists = DB::table('wishlists')->join('tours', 'tours.id', '=', 'wishlists.tour_id')->join('users', 'users.id', '=', 'tours.user_id')->join('destinations', 'destinations.id', '=', 'tours.destination_id')->where('wishlists.user_id', $id)->select('tours.id', 'users.user_name', 'destinations.destination_name', 'users.user_image', 'users.rating', 'tours.tour_description', 'tours.tour_date', 'tours.created_at', 'tours.hero_img')->get();

        return response()->json([
            'wishlists' => $wishLists
        ]);
    }
}
