<?php

namespace App\Http\Controllers;

use App\Models\BusScheduleBooking;
use App\Models\BusSeates;
use App\Models\superAdmin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class cancel_bookings extends Controller
{

    public function bookingCancel(Request $request, $id, $UserId)
    {

        if (User::where('id', $UserId)->exists()) {

            if (BusScheduleBooking::where('id', $id)->exists()) {

                $nowTime = Carbon::now();
                $startTimestamp = DB::table('bus_schedules')->select('start_timestamp')->get();

                $diffHours = $startTimestamp->diffInHours($nowTime);


                if (10 > $diffHours) {


                    $cancelBooking = BusScheduleBooking::find($id);
                    $cancelBooking->status = is_null($request->status) ? $cancelBooking->status : $request->input('status');
                    $cancelBooking->save();

                    return response()->json([
                        "message" => "Booking cancel successfully"
                    ], 200);


                } else {
                    return response()->json([
                        "message" => "Times UP Can't cancel booking  "
                    ], 400);
                }


            } else {

                return response()->json([
                    "message" => "Booking not found"
                ], 404);

            }

        } else {

            return response()->json([
                "message" => "Not a User Account"
            ], 404);

        }

    }
}
