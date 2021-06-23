<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BusSchedulesBookings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bus_schedule_bookings', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('bus_seate_id');
            $table->foreign('bus_seate_id')->references('id')->on('bus_seates')->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('bus_schedule_id');
            $table->foreign('bus_schedule_id')->references('id')->on('bus_schedules')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('seat_number');
            $table->double('price');

            $table->boolean('status')->default(1);
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
