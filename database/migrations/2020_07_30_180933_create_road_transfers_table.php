<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoadTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('road_transfers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string("name", 250);
            $table->string("starting_point", 250);
            $table->string("destination", 250);
            $table->uuid('vehicle_id');
            $table->decimal("cost_per_person",  23, 2)->default(0);
            $table->decimal("distance",  23, 2)->default(0);
            $table->time("est_time");
            $table->timestamps();
           
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
        Schema::dropIfExists('road_transfers');
    }
}
