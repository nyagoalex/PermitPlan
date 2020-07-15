<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string("company_name", 100);
            $table->string("sub_domain", 100);
            $table->integer("permit_expiry_in_days")->default(0);
            $table->string("physical_address", 45)->nullable();
            $table->string("registration_no", 45)->nullable();
            $table->string("email", 30)->nullable();
            $table->string("phone", 30)->nullable();
            $table->text("website")->nullable();
            $table->longText("logo")->nullable();
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
        Schema::dropIfExists('settings');
    }
}
