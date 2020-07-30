<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string("code", 150)->unique();
            $table->string("reg_no", 250)->unique();
            $table->string("color", 250);
            $table->integer("no_of_seats")->default(1);
            $table->string("type", 250);
            $table->enum("status", ['ready', 'disposed_off', 'too_old', 'has_issues'])->default('ready');
            $table->enum("ownership", ['company', 'hired'])->default('hired');
            $table->decimal("cost_per_day",  23, 2)->default(0);
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
        Schema::dropIfExists('vehicles');
    }
}
