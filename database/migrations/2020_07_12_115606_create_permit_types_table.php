<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermitTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permit_types', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 45)->unique();
            $table->float('east_african_cost', 9, 2)->default(0);
            $table->float('foreign_resident_cost', 9, 2)->default(0);
            $table->float('non_resident_cost', 9, 2)->default(0);
            $table->float('ugandan_cost', 9, 2)->default(0);
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
        Schema::dropIfExists('permit_types');
    }
}
