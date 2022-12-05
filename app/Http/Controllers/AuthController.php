<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{

    public function register(Request $request)
    {

        // $request->validate([
        //     'user_name' => 'required|string',
        //     'user_email' => 'required|string|unique:users:user_email',
        //     'password' => 'required|string\confirmed',
        //     'user_role' => 'required',
        //     'user_image' => 'required',
        // ]);

        $request->validate([
            'user_name' => ['required', 'string', 'max:255'],
            'user_email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'user_role' => ['required'],
            'user_image' => ['required'],

        ]);



        $image = $request->file('user_image');
        $name = $request->user_email . "." . $image->getClientOriginalExtension();
        $image->move('C:\Apache24\htdocs\Masterpiece\backup\src\images', $name);

        $user = User::create([
            'user_name' => $request->user_name,
            'user_email' => $request->user_email,
            'password' => Hash::make($request->password),
            'user_role' => $request->user_role,
            'user_image' => $name,

        ]);

        $token = $user->createToken($user->user_email)->plainTextToken;

        // $response = [
        //     'user' => $user,
        //     'token' => $token,
        // ];
        return response()->json([
            'user' => $user,
            'token' => $token,

        ]);
    }

    public function getalladvisors()
    {
        $Advisors = DB::table('users')->where('user_role', 'Advisor')->orderBy('rating', 'desc')->get();

        return response()->json([
            'Advisors' => $Advisors,
        ]);
    }


    public function login(Request $request)
    {

        $fields = $request->validate([
            'user_email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', Password::min(8)],

        ]);

        //check email

        $user = User::where('user_email', $fields['user_email'])->first();
        if (!$user || !Hash::check($fields['password'], $user->password)) {

            return response([
                'message' => 'Bad Creds',
            ], 401);
        }


        $token = $user->createToken($user->user_email)->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];
        return response($response, 201);
    }



    public function logout(Request $request)
    {

        auth()->user()->tokens()->delete();

        return [

            'message' => 'logged out'
        ];
    }
}
