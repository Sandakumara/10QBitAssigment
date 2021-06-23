<?php

namespace App\Http\Controllers;


use App\Models\BusRoutes;
use App\Models\Routes;
use App\Models\superAdmin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class route_management extends Controller
{
    public function CreateRoute(Request $request, $aId)
    {

        if (superAdmin::where('id', $aId)->exists()) {

            $validetor = Validator::make($request->all(), [
                "node_one" => "required",
                "node_two" => "required",
                "route_number" => "required",
                "distance" => "required",

            ]);
            if ($validetor->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => "Bad request"
                ], 400);
            }


            $nowTime = Carbon::now();


            $route = new Routes();
            $route->node_one = $request->input('node_one');
            $route->node_two = $request->input('node_two');
            $route->route_number = $request->input('route_number');
            $route->distance = $request->input('distance');
            $route->time = $nowTime;
            $route->save();


            return response()->json([
                "message" => "Route added Successful"
            ], 200);


        } else {
            return response()->json([
                "message" => "Not a Admin Account"
            ], 404);
        }





    }

    public function updateRoute(Request $request, $id, $aId)
    {
        if (superAdmin::where('id', $aId)->exists()) {

            if (Routes::where('id', $id)->exists()) {

                $nowTime = Carbon::now();
                $route = Routes::find($id);
                $route->node_one = is_null($request->node_one) ? $route->node_one : $request->input('node_one');
                $route->node_two = is_null($request->node_two) ? $route->node_two : $request->input('node_two');
                $route->route_number = is_null($request->route_number) ? $route->route_number : $request->input('route_number');
                $route->distance = is_null($request->distance) ? $route->distance : $request->input('distance');
                $route->time = is_null($request->time) ? $route->time :$nowTime;
                $route->save();

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
                "message" => "Not a Admin Account"
            ], 404);
        }




    }

    public function viewAllRoute($aId)
    {

        if (superAdmin::where('id', $aId)->exists()) {

            $route = Routes::get()->toJson(JSON_PRETTY_PRINT);
            return response($route, 200);

        } else {
            return response()->json([
                "message" => "Not a Admin Account"
            ], 404);
        }




    }

    public function viewRoute($id, $aId)
    {

        if (superAdmin::where('id', $aId)->exists()) {

            if (Routes::where('id', $id)->exists()) {
                $route = Routes::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
                return response($route, 200);

            } else {
                return response()->json([
                    "message" => "Route not found"
                ], 404);
            }

        } else {
            return response()->json([
                "message" => "Not a Admin Account"
            ], 404);
        }



    }

    public function deleteRoute($id, $aId)
    {


        if (superAdmin::where('id', $aId)->exists()) {

            if (BusRoutes::where('route_id', $id)->exists()) {
                return response()->json([
                    "message" => "Can't delete, first delete  bus routes"
                ], 400);

            } else {

                if (Routes::where('id', $id)->exists()) {

                    $route = Routes::find($id);
                    $route->delete();

                    return response()->json([
                        "message" => "records deleted"
                    ], 202);
                } else {
                    return response()->json([
                        "message" => "Route not found"
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
