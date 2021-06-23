<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BusSchedules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bus_schedules', function (Blueprint $table) {


            $table->id();
            $table->unsignedBigInteger('bus_route_id');
            $table->foreign('bus_route_id')->references('id')->on('bus_routes')->onUpdate('cascade')->onDelete('cascade');

            $table->boolean('direction')->default(0);
            $table->dateTime('start_timestamp');
            $table->dateTime('end_timestamp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
