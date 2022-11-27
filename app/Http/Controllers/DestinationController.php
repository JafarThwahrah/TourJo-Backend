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
}
