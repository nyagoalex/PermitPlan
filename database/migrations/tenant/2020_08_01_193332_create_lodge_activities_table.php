<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLodgeActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lodge_activities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('lodge_id');
            $table->string("name", 250);
            $table->decimal("cost_per_person", 23,2)->default(0);
            $table->timestamps();

            $table->foreign('lodge_id')->references('id')->on('lodges')->onDelete('cascade');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lodge_activities');
    }
}
