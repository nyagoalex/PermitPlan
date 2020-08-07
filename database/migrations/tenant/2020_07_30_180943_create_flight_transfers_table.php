<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlightTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flight_transfers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string("name", 250);
            $table->string("starting_point", 250);
            $table->string("destination", 250);
            $table->string("airline_operator", 250)->nullable();
            $table->enum('flight_type', ['scheduled', 'chartered']);
            $table->decimal("cost_per_person",  23, 2)->default(0);
            $table->decimal("distance",  23, 2)->default(0);
            $table->time("est_time");
            $table->time("departure_time");
            $table->time("arrival_time");
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
        Schema::dropIfExists('flight_transfers');
    }
}
