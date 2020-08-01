<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLodgePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lodge_photos', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('lodge_id');
            $table->text("name"); // encoded
            $table->string("title", 250);
            $table->text("description");
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
        Schema::dropIfExists('lodge_photos');
    }
}
