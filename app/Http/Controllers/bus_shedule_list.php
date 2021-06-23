<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\BusSchedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class bus_shedule_list extends Controller
{

    public function viewScheduleList()
    {


        $busScheduleList = BusSchedule::get()->toJson(JSON_PRETTY_PRINT);
        return response($busScheduleList, 200);


    }


}
