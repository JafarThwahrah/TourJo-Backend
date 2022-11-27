<?php

namespace App\Http\Controllers;

use App\Models\Tour;
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
        $tours = Tour::all();

        return response()->json([
            "status" => true,
            "message" => "success",
            "tours" => $tours
        ]);
    }

    public function getToutsPerUser($userid)
    {

        // $appointmentsAndusers = DB::table('users')->join('appointment', 'appointment.user_id', '=', 'users.id')->where('appointment.doctor_id', $id)->get();

        $toursPerUser = Tour::where('user_id', $userid)->get();
        $ToursJoinDes = DB::table('tours')->join('destinations', 'destinations.id', '=', 'tours.destination_id')->where('user_id', $userid)->get();


        return response()->json([
            "status" => true,
            "message" => "success",
            "toursPerUser" => $toursPerUser,
            "ToursJoinDes" => $ToursJoinDes
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
        $nameh = time() + 5 . "." . $imagehero->getClientOriginalExtension();
        $imagehero->move('C:\Apache24\htdocs\Masterpiece\backup\src\images', $nameh);


        $img_1 = $request->file('img_1');
        $name1 = time() + 1 . "." . $img_1->getClientOriginalExtension();
        $img_1->move('C:\Apache24\htdocs\Masterpiece\backup\src\images', $name1);

        $img_2 = $request->file('img_2');
        $name2 = time() + 2 . "." . $img_2->getClientOriginalExtension();
        $img_2->move('C:\Apache24\htdocs\Masterpiece\backup\src\images', $name2);

        $img_3 = $request->file('img_3');
        $name3 = time() + 3 . "." . $img_3->getClientOriginalExtension();
        $img_3->move('C:\Apache24\htdocs\Masterpiece\backup\src\images', $name3);

        $img_4 = $request->file('img_4');
        $name4 = time() + 4 . "." . $img_4->getClientOriginalExtension();
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
            'img_2' => $name1,
            'img_3' => $name2,
            'img_4' => $name4,
            // 'hero_img' => 's',

            // 'img_1' => "s",
            // 'img_2' => "s",
            // 'img_3' => "s",
            // 'img_4' => "s",




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
        //
    }
}
