<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartureTourPermitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departure_tour_permits', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('permit_type_id');
            $table->uuid('sector_id');
            $table->uuid('group_tour_id');
            $table->uuid('allocated_permit_id')->nullable();
            $table->string("number", 10)->unique();
            $table->float('cost', 9, 2)->default(0);
            $table->date("tracking_date");
            $table->date("rescheduled_from")->nullable();
            $table->timestamps();

            $table->foreign('group_tour_id')->references('id')->on('departure_tours')->onDelete('cascade');
            $table->foreign('permit_type_id')->references('id')->on('permit_types');
            $table->foreign('sector_id')->references('id')->on('sectors');
            $table->foreign('allocated_permit_id')->references('id')->on('permits')->onDelete('set null');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departure_tour_permits');
    }
}
