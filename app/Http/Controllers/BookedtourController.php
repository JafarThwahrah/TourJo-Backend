<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\Review;
use App\Models\Bookedtour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookedtourController extends Controller
{

    public function bookedToursEachUser($userRole, $userid)
    {
        // $BookedTours = $userRole == 'Advisor' ? Bookedtour::where('user_id2', $userid) : Bookedtour::where('user_id', $userid);
        $BookedTours = $userRole == 'Advisor'
            ?  DB::table('destinations')->join('tours', 'destinations.id', '=', 'tours.destination_id')->join('bookedtours', 'tours.id', '=', 'bookedtours.tour_id')->join('users', 'users.id', '=', 'bookedtours.user_id')->where('user_id2', $userid)->get()
            :  DB::table('destinations')->join('tours', 'destinations.id', '=', 'tours.destination_id')->join('bookedtours', 'tours.id', '=', 'bookedtours.tour_id')->join('users', 'users.id', '=', 'bookedtours.user_id2')->where('bookedtours.user_id', $userid)->get();


        return response()->json([

            'status' => 'Booked success',
            'bookedtours' => $BookedTours,

        ]);
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

        if ($request->user_id == $request->user_id2) {
            return response()->json([

                'status' => 'Wrong action',
                'message' => 'Tour advisors cannot book their own Tours'
            ]);
        } else {
            $bookedtour = Bookedtour::create([
                'user_id' => $request->user_id,
                'user_id2' => $request->user_id2,
                'tour_id' => $request->tour_id,
                'tour_price' => $request->tour_price,

            ]);

            $Tour = Tour::findOrFail($request->tour_id);
            DB::table('tours')
                ->where('id', $request->tour_id)
                ->update(['is_published' => 0]);
            $Tour->delete();
            return response()->json([
                'status' => 'success',
                'bookedtour' => $bookedtour
            ]);
        }
    }

    public function rateandreview(Request $request)
    {
        DB::table('bookedtours')
            ->where('tour_id', $request->tour_id)
            ->update(['booked_rating' => $request->rating]);


        $review = Review::create([
            'user_id' => $request->user_id,
            'tour_id' => $request->tour_id,
            'review_description' => $request->review,


        ]);

        return response()->json([
            'status' => 'success',
            'review' => $review,

        ]);
    }
}
