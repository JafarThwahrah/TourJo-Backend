<?php

namespace App\Http\Controllers;

use App\Models\Bookedtour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookedtourController extends Controller
{

    public function bookedToursEachUser($userid)
    {

        // $toursPerUser = Bookedtour::where('user_id', $userid)->get();
        // $ToursJoinDes = DB::table('tours')->join('destinations', 'destinations.id', '=', 'tours.destination_id')->where('user_id', $userid)->get();


        // return response()->json([
        //     "status" => true,
        //     "message" => "success",
        //     "toursPerUser" => $toursPerUser,
        //     "ToursJoinDes" => $ToursJoinDes
        // ]);

    }
    public function bookedtourstore(Request $request)
    {

        $bookedtour = Bookedtour::create([
            'user_id' => $request->user_id,
            'user_id2' => $request->user_id2,
            'tour_id' => $request->tour_id,
            'tour_price' => $request->tour_price,
        ]);
        return response()->json([
            'status' => 'success',
            'bookedtour' => $bookedtour
        ]);
    }
}
