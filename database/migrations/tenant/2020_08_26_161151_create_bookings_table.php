<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string("number", 10)->unique();
            $table->string("ref");
            $table->uuid('user_id');
            $table->uuid('agent_id')->nullable();
            $table->enum("status", ['confirmed', 'tentative', 'cancelled'])->default('tentative');
            $table->integer('no_of_persons');
            $table->float('cost_per_person', 9, 2)->default(0);
            $table->date("arrival_date");
            $table->date("departure_date");
            $table->string("client_name");
            $table->text("comment")->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('agent_id')->references('id')->on('agents');
        });
        DB::statement("ALTER TABLE bookings ADD CONSTRAINT chk_bookings_dates CHECK(arrival_date <= departure_date)");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
