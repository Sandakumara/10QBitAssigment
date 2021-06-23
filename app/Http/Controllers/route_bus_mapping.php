<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\BusRoutes;
use App\Models\BusSchedule;
use App\Models\Routes;
use App\Models\superAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class route_bus_mapping extends Controller
{
    public function CreateBusMapping(Request $request, $aId, $busId, $routeId)
    {

        if (superAdmin::where('id', $aId)->exists()) {

            if (Bus::where('id', $busId)->exists() && Routes::where('id', $routeId)->exists()) {

                $validetor = Validator::make($request->all(), [
                    "status" => "required"
                ]);
                if ($validetor->fails()) {
                    return response()->json([
                        'status' => 400,
                        'message' => "Bad request"
                    ], 400);
                }


                $busRoutes = new BusRoutes();
                $busRoutes->bus_id=$busId;
                $busRoutes->route_id=$routeId;
                $busRoutes->status = $request->input('status');
                $busRoutes->save();


                return response()->json([
                    "message" => "Bus Mapping Successful"
                ], 200);

            } else {
                return response()->json([
                    "message" => "Can't Create, first insert expected  bus and routes"
                ], 400);
            }


        } else {
            return response()->json([
                "message" => "Not a Admin Account"
            ], 404);
        }

    }


    public function updateBusMapping(Request $request, $id, $aId, $busId, $routeId)
    {

        if (superAdmin::where('id', $aId)->exists()) {

            if (Bus::where('id', $busId)->exists() && Routes::where('id', $routeId)->exists()) {

                if (BusRoutes::where('id', $id)->exists()) {
                    $busRoutes = BusRoutes::find($id);
                    $busRoutes->status = is_null($request->status) ? $busRoutes->status : $request->input('status');

                    $busRoutes->save();

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
                    "message" => "Can't Update, first insert expected  bus and routes"
                ], 400);

            }


        } else {
            return response()->json([
                "message" => "Not a Admin Account"
            ], 404);
        }


    }

    public function viewAllBusMapping($aId)
    {

        if (superAdmin::where('id', $aId)->exists()) {
            $busRoutes = BusRoutes::get()->toJson(JSON_PRETTY_PRINT);
            return response($busRoutes, 200);

        } else {
            return response()->json([
                "message" => "Not a Admin Account"
            ], 404);
        }


    }

    public function viewBusMapping($id, $aId)
    {

        if (superAdmin::where('id', $aId)->exists()) {

            if (BusRoutes::where('id', $id)->exists()) {
                $busRoutes = BusRoutes::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
                return response($busRoutes, 200);

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

    public function deleteBusMapping($id, $aId)
    {
        if (superAdmin::where('id', $aId)->exists()) {

            if (BusSchedule::where('bus_route_id', $id)->exists()) {

                return response()->json([
                    "message" => "Can't delete, first delete  bus schedule"
                ], 400);

            } else {

                if (BusRoutes::where('id', $id)->exists()) {

                    $busRoutes = BusRoutes::find($id);
                    $busRoutes->delete();

                    return response()->json([
                        "message" => "records deleted"
                    ], 202);


                } else {
                    return response()->json([
                        "message" => "Bus route not found"
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
