<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Routes extends Model
{
    protected $table='routes';

    protected $fillable = [
        'node_one',
        'node_two',
        'route_number',
        'distance',
        'time',


    ];
}
