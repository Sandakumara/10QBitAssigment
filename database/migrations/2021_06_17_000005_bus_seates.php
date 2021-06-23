<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BusSeates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bus_seates', function (Blueprint $table) {


            $table->id();
            $table->unsignedBigInteger('bus_id');
            $table->foreign('bus_id')->references('id')->on('bus')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('seat_number');
            $table->double('price');
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
