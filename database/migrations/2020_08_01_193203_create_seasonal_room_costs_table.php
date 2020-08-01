<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeasonalRoomCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seasonal_room_costs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('season_id');
            $table->uuid("room_id");
            $table->decimal("amount", 23,2);
            $table->timestamps();

            $table->unique(['season_id', 'room_id']);
            $table->foreign('season_id')->references('id')->on('seasons')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seasonal_room_costs');
    }
}
