<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\BusScheduleBooking;
use App\Models\BusSeates;
use App\Models\superAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class bus_seats_management extends Controller
{
    public function CreateBusSeats(Request $request, $aId, $busId)
    {

        if (superAdmin::where('id', $aId)->exists()) {

            if (Bus::where('id', $busId)->exists()) {

                $validetor = Validator::make($request->all(), [
                    "seat_number" => "required",
                    "price" => "required"

                ]);
                if ($validetor->fails()) {
                    return response()->json([
                        'status' => 400,
                        'message' => "Bad request"
                    ], 400);
                }

                $busSeates = new BusSeates();

                $busSeates->bus_id = $busId;

                $busSeates->seat_number = $request->input('seat_number');
                $busSeates->price = $request->input('price');

                $busSeates->save();


                return response()->json([
                    $busSeates,
                    "message" => "Seat added Successful"
                ], 200);




            } else {
                return response()->json([
                    "message" => "Can't Create, first insert expected  bus "
                ], 400);
            }



        } else {
            return response()->json([
                "message" => "Not a Admin Account"
            ], 404);
        }


    }

    public function updateSeat(Request $request, $id, $aId, $busId)
    {
        if (superAdmin::where('id', $aId)->exists()) {

            if (Bus::where('id', $busId)->exists()) {

                if (BusSeates::where('id', $id)->exists()) {
                    $busSeates = BusSeates::find($id);

                    $busSeates->bus_id = $busId;

                    $busSeates->seat_number = is_null($request->seat_number) ? $busSeates->seat_number : $request->input('seat_number');
                    $busSeates->price = is_null($request->price) ? $busSeates->price : $request->input('price');
                    $busSeates->save();

                    return response()->json([
                        $busSeates,
                        "message" => "records updated successfully"
                    ], 200);
                } else {

                    return response()->json([
                        "message" => "Bus not found"
                    ], 404);

                }

            } else {
                return response()->json([
                    "message" => "Can't Update, first insert expected  bus "
                ], 400);
            }

        } else {
            return response()->json([
                "message" => "Not a Admin Account"
            ], 404);
        }


    }

    public function viewAllSeates($aId)
    {
        if (superAdmin::where('id', $aId)->exists()) {

            $busSeates = BusSeates::get()->toJson(JSON_PRETTY_PRINT);
            return response($busSeates, 200);

        } else {
            return response()->json([
                "message" => "Not a Admin Account"
            ], 404);
        }


    }

    public function viewSeat($id, $aId)
    {
        if (superAdmin::where('id', $aId)->exists()) {

            if (BusSeates::where('id', $id)->exists()) {
                $busSeates = BusSeates::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
                return response($busSeates, 200);

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

    public function deleteSeate($id, $aId)
    {
        if (superAdmin::where('id', $aId)->exists()) {

            if (BusScheduleBooking::where('bus_seate_id', $id)->exists()) {

                return response()->json([
                    "message" => "Can't delete, first delete  bus schedule booking"
                ], 400);

            } else {

                if (BusSeates::where('id', $id)->exists()) {

                    $busSeates = BusSeates::find($id);
                    $busSeates->delete();

                    return response()->json([
                        "message" => "records deleted"
                    ], 202);
                } else {
                    return response()->json([
                        "message" => "Bus Seate not found"
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
