<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tours1 = DB::table('users')->join('tours', 'tours.user_id', '=', 'users.id')->whereNull('deleted_at')->get();
        $tours = DB::table('tours')->join('users', 'tours.user_id', '=', 'users.id')->join('destinations', 'destinations.id', '=', 'tours.destination_id')->whereNull('deleted_at')->get();

        for ($i = 0; $i < count($tours1); $i++) {
            $tours[$i]->id = $tours1[$i]->id;
        }
        return response()->json([
            "status" => true,
            "message" => "success",
            "tours" => $tours,
            'tours1' => $tours1
        ]);
    }

    public function getToutsPerUser($userid)
    {

        $toursPerUser = Tour::where('user_id', $userid)->get();
        $ToursJoinDes = DB::table('destinations')->join('tours', 'destinations.id', '=', 'tours.destination_id')->where('user_id', $userid)->get();
        $tours3 = User::findOrFail($userid)->tour;
        $User = User::findOrFail($userid);
        // $comments = Post::findOrFail($id)->comments;


        return response()->json([
            "status" => true,
            "message" => "success",
            "toursPerUser" => $toursPerUser,
            "ToursJoinDes" => $ToursJoinDes,
            "tours3" => $tours3,
        ]);
    }

    public function getsingletour($tourId)
    {
        // $tour = DB::table('users')->join('tours', 'users.id', '=', "tours.user_id")->where('tours.id', $tourId)->get();
        $singleTour = Tour::where('id', $tourId)->get();

        return response()->json([
            'status' => 'success',
            'singleTour' => $singleTour
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // check incoming data
        $request->validate([
            'destination_id' => ['required'],
            'advisor_id' => ['required'],
            'tour_price' => ['required'],
            'advisor_contact_number' => ['required'],
            'tour_route' => ['required'],
            'tour_description' => ['required', 'string'],
            'tour_date' => ['required'],
            'hero_img' => ['required'],
            'img_1' => ['required'],
            'img_2' => ['required'],
            'img_3' => ['required'],
            'img_4' => ['required'],


        ]);

        //     'projectName' => 
        // array(
        //     'required',
        //     'regex:/(^([a-zA-Z]+)(\d+)?$)/u'
        // ),

        $imagehero = $request->file('hero_img');
        $nameh =  rand() . "." . $imagehero->getClientOriginalExtension();
        $imagehero->move('C:\Apache24\htdocs\Masterpiece\backup\src\images', $nameh);


        $img_1 = $request->file('img_1');
        $name1 = rand() . "." . $img_1->getClientOriginalExtension();
        $img_1->move('C:\Apache24\htdocs\Masterpiece\backup\src\images', $name1);

        $img_2 = $request->file('img_2');
        $name2 = rand() . "." . $img_2->getClientOriginalExtension();
        $img_2->move('C:\Apache24\htdocs\Masterpiece\backup\src\images', $name2);

        $img_3 = $request->file('img_3');
        $name3 = rand() . "." . $img_3->getClientOriginalExtension();
        $img_3->move('C:\Apache24\htdocs\Masterpiece\backup\src\images', $name3);

        $img_4 = $request->file('img_4');
        $name4 = rand() . "." . $img_4->getClientOriginalExtension();
        $img_4->move('C:\Apache24\htdocs\Masterpiece\backup\src\images', $name4);

        $tour = Tour::create([
            'destination_id' => $request->destination_id,
            'user_id' => $request->advisor_id,
            'tour_price' => $request->tour_price,
            'tour_description' => $request->tour_description,
            'tour_route' => $request->tour_route,
            'tour_date' => $request->tour_date,
            'advisor_contact_number' => $request->advisor_contact_number,
            'hero_img' => $nameh,
            'img_1' => $name1,
            'img_2' => $name2,
            'img_3' => $name3,
            'img_4' => $name4,

        ]);

        return response()->json([
            'status' => 'success',
            'tour' => $tour
        ]);
    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = Tour::find($id);
        DB::table('tours')
            ->where('id', $id)
            ->update(['is_published' => 0]);
        $deleted->delete();


        return response()->json([
            'status' => 'deleted successfully',
            'DeletedTour' => $deleted
        ]);
    }

    public function getalltours()
    {
        $tours = DB::table('tours')->join('users', 'tours.user_id', '=', 'users.id')->join('destinations', 'destinations.id', '=', 'tours.destination_id')->select('tours.tour_date', 'tours.id', 'users.user_name', 'destinations.destination_name')->whereNull('deleted_at')->get();
        return response()->json([
            'tours' => $tours
        ]);
    }

    public function about()
    {

        $allUsers = User::all();
        $advisors = DB::table('users')->where('user_role', 'Advisor')->get();
        $happyCustomers = DB::table('bookedtours')->where('booked_rating', '>=', 4)->get();
        $publishedTours = DB::table('tours')->where('is_published', 1)->get();

        return response()->json([
            'allUsers' => count($allUsers),
            'advisors' => count($advisors),
            'happyCustomers' => count($happyCustomers),
            'publishedTours' => count($publishedTours)
        ]);
    }

    public function toursnumbers()
    {
        $Aqaba = DB::table('tours')->where('destination_id', 1)->where('is_published', 0)->get();
        $DeadSea = DB::table('tours')->where('destination_id', 2)->where('is_published', 0)->get();
        $Petra = DB::table('tours')->where('destination_id', 3)->where('is_published', 0)->get();
        $Jerash = DB::table('tours')->where('destination_id', 4)->where('is_published', 0)->get();
        $Nebo = DB::table('tours')->where('destination_id', 5)->where('is_published', 0)->get();
        $Amman = DB::table('tours')->where('destination_id', 6)->where('is_published', 0)->get();

        return response()->json([
            'Aqaba' => count($Aqaba),
            'DeadSea' => count($DeadSea),
            'Petra' => count($Petra),
            'Jerash' => count($Jerash),
            'Nebo' => count($Nebo),
            'Amman' => count($Amman)
        ]);
    }
}
