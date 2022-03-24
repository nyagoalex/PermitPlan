<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_vehicle', function (Blueprint $table) {
           $table->id();
           $table->uuid('booking_id');
           $table->uuid('vehicle_id');
           $table->timestamps();

           $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
           $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_vehicle');
    }
}
