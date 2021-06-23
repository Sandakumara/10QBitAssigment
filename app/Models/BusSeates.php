<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusSeates extends Model
{
    protected $table='bus_seates';

    protected $fillable = [


        'seat_number',
        'price',

    ];
}
