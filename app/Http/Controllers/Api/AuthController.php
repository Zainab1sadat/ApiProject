<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function index()
    {

        $user = User::all();

        if (count($user) > 0) {
            return UserResource::collection($user);
        } else {
            return response()->json([
                'message' => 'no user found',
            ], 400);
        }
    }


    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|max:100',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation fails',
                'error' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));


        return response()->json([
            'message' => 'Validation Successfuly',
            'data' => $user
        ], 200);
    }

    //  Login function
    public function login(Request $request)
    {
        // validation
        $validator = validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'validatoion fails',
                'error'   => $validator->errors()
            ], 422);
        }

        //get user email
        $user = User::where('email', $request->email)->first();


        if ($user) {

            // if password matched user password in database
            if (Hash::check($request->password, $user->password)) {
                $token = $user->CreateToken('auth-token')->plainTextToken;
                return response()->json([
                    'message' => 'Login Successfuly',
                    'token' => $token,
                    'data' => $user
                ], 200);
            } else {
                return response()->json([
                    'message' => 'incorrect credentials',
                ], 400);
            }
        } else {
            return response()->json([
                'message' => 'incorrect credentials',
            ], 400);
        }
    }

    // protected user api function
    public function user(Request $request)
    {
        return response()->json([
            'message' => 'user successfuly fetched',
            'data' => $request->user()
        ], 200);
    }

    // logout function
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'user successfuly logout',
        ], 200);
    }
}
