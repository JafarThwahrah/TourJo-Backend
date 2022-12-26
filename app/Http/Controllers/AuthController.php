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

    public function getallusers()
    {

        $Allusers = User::all();

        return response()->json([

            'users' => $Allusers,
        ]);
    }

    public function getalladvisors()
    {

        $Advisors = DB::table('users')->where('user_role', 'Advisor')->orderBy('rating', 'desc')->get();

        $best6Advisors = [];
        for ($i = 0; $i < 6; $i++) {

            array_push($best6Advisors, $Advisors[$i]);
        }
        return response()->json([
            'Advisors' => $best6Advisors,
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

    public function googlelogin(Request $request)
    {

        $checkEmail = User::where('user_email', $request->email)->first();

        if (!$checkEmail) {

            $user = User::create([
                'user_name' => $request->name,
                'user_email' => $request->email,
                'user_role' => 'Tourist',
                'user_image' => $request->picture,

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
        } else {
            $user = User::where('user_email', $request->email)->first();
            $token = $user->createToken($user->user_email)->plainTextToken;

            $response = [
                'user' => $user,
                'token' => $token,
            ];
            return response($response, 201);
        }
    }



    public function logout(Request $request)
    {

        auth()->user()->tokens()->delete();

        return [

            'message' => 'logged out'
        ];
    }
    public function destroy($id)
    {

        $user = User::find($id);
        $user->delete();
        return response()->json([
            'success' => 'User deleted successfully'
        ]);
    }
}
