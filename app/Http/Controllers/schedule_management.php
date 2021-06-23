<?php

namespace App\Http\Controllers;

use App\Models\BusRoutes;
use App\Models\BusSchedule;
use App\Models\BusScheduleBooking;
use App\Models\superAdmin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class schedule_management extends Controller
{
    public function CreateSchedule(Request $request, $aId, $busRouteId)
    {

        if (superAdmin::where('id', $aId)->exists()) {

            if (BusRoutes::where('id', $busRouteId)->exists()) {

            } else {

                return response()->json([
                    "message" => "Can't Create, first insert expected  Bus Route "
                ], 400);

            }

            $validetor = Validator::make($request->all(), [
                "direction" => "required",
                "start_timestamp" => "required",
                "end_timestamp" => "required"
            ]);
            if ($validetor->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => "Bad request"
                ], 400);
            }



            $busSchedule = new BusSchedule();
            $busSchedule->bus_route_id=$busRouteId;

            $busSchedule->direction = $request->input('direction');

            $startTime= $request->input('start_timestamp');
            $date11 = strtotime($startTime);
            $startTime2 = date('Y-m-d H:i:s', $date11);
            $busSchedule->start_timestamp = $startTime2;


            $endTime=$request->input('end_timestamp');
            $date22 = strtotime($endTime);
            $endTime2 = date('Y-m-d H:i:s', $date22);
            $busSchedule->end_timestamp = $endTime2;

            $busSchedule->save();


            return response()->json([
                "message" => "Bus Rejistration Successful"
            ], 200);

        } else {
            return response()->json([
                "message" => "Not a Admin Account"
            ], 404);
        }


    }

    public function updateSchedule(Request $request, $id, $aId, $busRouteId)
    {
        if (superAdmin::where('id', $aId)->exists()) {

            if (BusRoutes::where('id', $busRouteId)->exists()) {

                if (BusSchedule::where('id', $id)->exists()) {
                    $busSchedule = BusSchedule::find($id);
                    $busSchedule->direction = is_null($request->direction) ? $busSchedule->direction : $request->input('direction');
                    $busSchedule->start_timestamp = is_null($request->start_timestamp) ? $busSchedule->start_timestamp : $request->input('start_timestamp');
                    $busSchedule->end_timestamp = is_null($request->end_timestamp) ? $busSchedule->end_timestamp : $request->input('end_timestamp');
                    $busSchedule->save();

                    return response()->json([
                        "message" => "records updated successfully"
                    ], 200);
                } else {

                    return response()->json([
                        "message" => "Bus not found"
                    ], 404);

                }

            } else {

                return response()->json([
                    "message" => "Can't Update, first insert expected  Bus Route "
                ], 400);

            }


        } else {
            return response()->json([
                "message" => "Not a Admin Account"
            ], 404);
        }


    }

    public function viewAllSchedule($aId)
    {

        if (superAdmin::where('id', $aId)->exists()) {

            $busSchedule = BusSchedule::get()->toJson(JSON_PRETTY_PRINT);
            return response($busSchedule, 200);

        } else {
            return response()->json([
                "message" => "Not a Admin Account"
            ], 404);
        }


    }

    public function viewSchedule($id, $aId)
    {
        if (superAdmin::where('id', $aId)->exists()) {

            if (BusSchedule::where('id', $id)->exists()) {
                $busSchedule = BusSchedule::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
                return response($busSchedule, 200);

            } else {
                return response()->json([
                    "message" => "Student not found"
                ], 404);
            }

        } else {
            return response()->json([
                "message" => "Not a Admin Account"
            ], 404);
        }


    }

    public function deleteSchedule($id, $aId)
    {

        if (superAdmin::where('id', $aId)->exists()) {

            if (BusScheduleBooking::where('bus_schedule_id', $id)->exists()) {
                return response()->json([
                    "message" => "Can't delete, first delete  bus schedule booking"
                ], 400);
            } else {

                if (BusSchedule::where('id', $id)->exists()) {

                    $busSchedule = BusSchedule::find($id);
                    $busSchedule->delete();

                    return response()->json([
                        "message" => "records deleted"
                    ], 202);
                } else {
                    return response()->json([
                        "message" => "Student not found"
                    ], 404);
                }

            }


        } else {
            return response()->json([
                "message" => "Not a Admin Account"
            ], 404);
        }


    }
}
