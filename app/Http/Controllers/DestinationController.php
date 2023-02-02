<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function index()
    {

        $destinations = Destination::All();

        return response()->json([
            'destinations' => $destinations, 201

        ]);
    }

    public function newdestination(Request $request)
    {

        $des = $request->file('destination_image');
        $nameh =  rand() . "." . $des->getClientOriginalExtension();
        $des->move('C:\Apache24\htdocs\Masterpiece\backup\src\images', $nameh);


        $Des = Destination::create([
            'destination_name' => $request->get('destination_name'),
            'destination_image' => $des,

        ]);


        return response()->json([
            'destinations' => $Des,
            'status' => 'success'
        ]);
    }

    public function destroy($id)
    {
        $destination = Destination::find($id);
        $destination->delete();

        return response()->json([
            'destinations' => $destination,
            'status' => 'deleted successfully'
        ]);
    }
}
