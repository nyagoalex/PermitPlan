<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guides', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string("first_name", 250);
            $table->string("last_name", 250);
            $table->string("code", 150)->unique();
            $table->date("dob");
            $table->date("experience_since");
            $table->string("email", 250)->nullable();
            $table->string("phone", 30)->nullable();
            $table->enum("contract_basis", ['full_time', 'freelancer'])->default('full_time');
            $table->enum("status", ['working', 'terminated', 'probation'])->default('probation');
            $table->decimal("cost_per_day",  23, 2)->default(0);
            $table->json("parks_experience")->nullable();
            $table->json("vehicle_types_expiience")->nullable();
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
        Schema::dropIfExists('guides');
    }
}
