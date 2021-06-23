<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;

//use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Boolean;
use Illuminate\Support\Facades\Validator;

//use Validator;


class LoginController extends Controller
{
    /**
     * cheackAdmin, if user check admin or user
     * @return $user
     */

    public function cheackAdmin(Request $request)
    {

        $user = $request->user();

        if ($user->tokenCan('admin')) {
            return response()->json([

                'message' => $user->name . "is an Admin"

            ], 200);
        }
        return response()->json([
            'message' => $user->name . "is not an Admin"
        ], 401);


    }


    /**
     * Get User token
     * @return $user
     */

    public function getUser(Request $request)
    {

        return response()->json([
            'user' => $request->user()
        ], 200);

    }

    /**
     *  User logout
     * @return $user
     */

    public function logOut(Request $request)
    {

        $user = $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => "User LogOUt"
        ], 201);


    }


    /**
     * registration
     * @param Request $request
     * @return JsonResponse
     *
     */

    public function register(Request $request)
    {


        $validetor = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required|email",
            "password" => "required|min:8"
        ]);
        if ($validetor->fails()) {
            return response()->json([
                'status' => 400,
                'message' => "Bad request"
            ], 400);
        }

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password =$request->input('password');
        $user->roles = ["user"];
        $user->save();


        return response()->json([

            $user,
            "message" => "User Rejistration Successful"
        ], 200);
    }


    /**
     * user login
     * @param Request $request
     * @return JsonResponse
     * @return User $user with token
     *
     */

    public function login(Request $request)
    {

        $validetor = Validator::make($request->all(), [

            "email" => "required|email",
            "password" => "required"
        ]);

        if ($validetor->fails()) {
            return response()->json([
                'status' => 400,
                'message' => "Bad request"
            ], 400);
        }
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => 401,
                'message' => "Unauthorized"
            ], 401);
        }


        $user = User::where("email", $request->email)->select('id', 'name', 'email', 'roles')->first();
        $token = $user->createToken('user-token', $user->roles)->plainTextToken;
        Arr::add($user, 'token', $token);

        return response()->json([
            $user,
            "message" => "User Login Successful"

            ],200);

    }


}
