<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusScheduleBooking extends Model
{
    protected $table='bus_schedule_bookings';

    protected $fillable = [
        'seat_number',
        'price',
        'status',

    ];
}
