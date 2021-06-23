<?php

namespace App\Http\Controllers;

use App\Models\BusSchedule;
use App\Models\BusScheduleBooking;
use App\Models\BusSeates;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class book_schedule extends Controller
{
    public function busScheduleBooking(Request $request, $userId, $busSeatId, $busSchedulId)
    {

        if (BusSeates::where('id', $busSeatId)->exists() && User::where('id', $userId)->exists() && BusSchedule::where('id', $busSchedulId)->exists()) {

            $busSchedulBooking = new BusScheduleBooking();

            $busSeates = DB::table('bus_seates')->select('seat_number')->get();
            $busSeatesPrice = DB::table('bus_seates')->select('price')->get();

            $busSchedulBooking->user_id = $userId;
            $busSchedulBooking->bus_seate_id = $busSeatId;
            $busSchedulBooking->bus_schedule_id =$busSchedulId ;

            $busSchedulBooking->seat_number = $busSeates;
            $busSchedulBooking->price = $busSeatesPrice;
            $busSchedulBooking->status = $request->input('status');
            $busSchedulBooking->save();
            return response()->json([
                $busSchedulBooking,

                "message" => "Bus Schedul Booking successfully"

                ],200);

        } else {
            return response()->json([
                "message" => "Not found valid Bus Seates OR User OR Bus Schedul"
            ], 404);
        }

    }
}
