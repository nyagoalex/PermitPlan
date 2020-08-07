<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLodgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lodges', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string("code", 150)->unique();
            $table->string("name", 250);
            $table->decimal("star_rating", 3, 2)->default(0);
            $table->decimal("contracted_rating", 4, 2)->default(0);
            $table->string("email", 250)->nullable();
            $table->string("phone", 50)->nullable();
            $table->text("address")->nullable();
            $table->string("country", 250);
            $table->string("location", 250);
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
        Schema::dropIfExists('lodges');
    }
}
