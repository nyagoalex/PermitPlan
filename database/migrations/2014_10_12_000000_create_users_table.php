<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

                $table->uuid('id')->primary();
                $table->string('first_name', 20);
                $table->string('last_name', 20);
                $table->string('username', 10)->unique();
                $table->string('email', 30)->unique()->nullable();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('phone', 30)->unique();
                $table->timestamp('last_login')->nullable();
                $table->string('password', 120);
                $table->boolean('active')->default(false);
                $table->date("last_pass_reset_date")->nullable();
                //will keep incrementing
                $table->integer("failed_login_count")->unsigned()->default(0); //0 impplies actual
                $table->rememberToken()->nullable();

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
        Schema::dropIfExists('users');
    }
}
