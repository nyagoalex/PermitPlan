<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLodgeFacilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lodge_facilities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('lodge_id');
            $table->string("name", 250);
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
        Schema::dropIfExists('lodge_facilities');
    }
}
