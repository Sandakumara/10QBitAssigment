<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\superAdmin;
use App\Models\User;
use Illuminate\Http\Request;

class resetPassword extends Controller
{

    public function adminResetPassword(Request $request, $adminId,$email,$adminPassword ){


        if (superAdmin::where('id', $adminId)->exists()){

            if(superAdmin::where('email', $email)->exists()){
                if (superAdmin::where('password', $adminPassword)->exists()){

                    $adminNewPassword = superAdmin::find($adminId);
                    $adminNewPassword->password = is_null($request->password) ? $adminNewPassword->password : $request->input('password');
                    $adminNewPassword->save();

                    return response()->json([
                        $adminNewPassword,
                        "message" => "Password Reset Successfully"
                    ], 200);


                }else{

                    return response()->json([
                        "message" => "Current Password does not match"
                    ], 404);



                }

            }else{
                return response()->json([
                    "message" => "Email does not match"
                ], 404);

            }

        }

    }

    public function userResetPassword(Request $request, $userId,$email,$adminPassword){

        if (User::where('id', $userId)->exists()){

            if(User::where('email', $email)->exists()){
                if (User::where('password', $adminPassword)->exists()){

                    $userNewPassword = User::find($userId);
                    $userNewPassword->password = is_null($request->password) ? $userNewPassword->password : $request->input('password');
                    $userNewPassword->save();

                    return response()->json([
                        $userNewPassword,
                        "message" => "Password Reset Successfully"
                    ], 200);

                }else{

                    return response()->json([
                        "message" => "Current Password does not match"
                    ], 404);



                }

            }else{
                return response()->json([
                    "message" => "Email does not match"
                ], 404);

            }

        }

    }


}
