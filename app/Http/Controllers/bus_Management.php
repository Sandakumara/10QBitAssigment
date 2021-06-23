<?php

namespace App\Http\Controllers;

use App\Models\Bus;

//use App\Models\Student;
use App\Models\BusRoutes;
use App\Models\BusSeates;
use App\Models\Student;
use App\Models\superAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class bus_Management extends Controller
{


    public function CreateBus(Request $request, $id)
    {
//        $superAdmin = new superAdmin();

        if (superAdmin::where('id', $id)->exists()) {

            $validetor = Validator::make($request->all(), [
                "name" => "required",
                "type" => "required",
                "vehical_number" => "required"
            ]);
            if ($validetor->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => "Bad request"
                ], 400);
            }


            $bus = new Bus();
            $bus->name = $request->input('name');
            $bus->type = $request->input('type');
            $bus->vehical_number = $request->input('vehical_number');
            $bus->save();
//            return response()->json($bus);


            return response()->json([
                $bus,
                "message" => "Bus Rejistration Successful"
            ], 200);


        } else {
            return response()->json([
                "message" => "Not a Admin Account"
            ], 404);
        }


    }

    public function updateBus(Request $request, $id, $saId)
    {

        if (superAdmin::where('id', $saId)->exists()) {

            if (Bus::where('id', $id)->exists()) {
                $bus = Bus::find($id);
                $bus->name = is_null($request->name) ? $bus->name : $request->input('name');
                $bus->type = is_null($request->type) ? $bus->type : $request->input('type');
                $bus->vehical_number = is_null($request->vehical_number) ? $bus->vehical_number : $request->input('vehical_number');
                $bus->save();

                return response()->json([
                    $bus,
                    "message" => "records updated successfully"
                ], 200);
            } else {

                return response()->json([
                    "message" => "Bus not found"
                ], 404);

            }

        } else {
            return response()->json([
                "message" => "Not a Admin Account"
            ], 404);
        }


    }

    public function viewAllBuses($saId)
    {

        if (superAdmin::where('id', $saId)->exists()) {

            $bus = Bus::get()->toJson(JSON_PRETTY_PRINT);
            return response($bus, 200);

        } else {
            return response()->json([
                "message" => "Not a Admin Account"
            ], 404);
        }


    }

    public function viewBus($id, $saId)
    {

        if (superAdmin::where('id', $saId)->exists()) {

            if (Bus::where('id', $id)->exists()) {
                $bus = Bus::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
                return response($bus, 200);

            } else {
                return response()->json([
                    "message" => "bus not found"
                ], 404);
            }

        } else {
            return response()->json([
                "message" => "Not a Admin Account"
            ], 404);
        }


    }

    public function deleteBus($id, $saId)
    {

        if (superAdmin::where('id', $saId)->exists()) {

            if (BusSeates::where('bus_id', $id)->exists() && BusRoutes::where('bus_id', $id)->exists()) {

                return response()->json([
                    "message" => "Can't delete, first delete bus seates and bus routes"
                ], 400);

            } else {

                if (Bus::where('id', $id)->exists()) {

                    $bus = Bus::find($id);
                    $bus->delete();

                    return response()->json([
                        "message" => "records deleted"
                    ], 200);
                } else {
                    return response()->json([
                        "message" => "bus not found"
                    ], 404);
                }

            }



        } else{
            return response()->json([
                "message" => "Not a Admin Account"
            ], 404);
        }


    }


}
