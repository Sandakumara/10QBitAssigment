<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusSchedule extends Model
{
    protected $table='bus_schedules';

    protected $fillable = [
        'direction',
        'start_timestamp',
        'end_timestamp',

    ];
}
