<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\BusScheduleBooking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class my_booking extends Controller
{
    public function viewAllMyBooking($userId)
    {
        if (User::where('id', $userId)->exists()) {

            $myBookings = BusScheduleBooking::get()->toJson(JSON_PRETTY_PRINT);
            return response($myBookings, 200);

        } else {
            return response()->json([
                "message" => "User not found"
            ], 404);
        }


    }


}
