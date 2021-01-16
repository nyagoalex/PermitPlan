<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePermitTransfersTable extends Migration
{
        /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permit_transfers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->uuid("from_booking_id");
            $table->uuid("to_booking_id");
            $table->uuid("permit_id");

            $table->foreign('from_booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->foreign("to_booking_id")->references("id")->on("bookings")->onDelete('cascade');
            $table->foreign("permit_id")->references("id")->on("permits")->onDelete('cascade');
        });
        DB::statement("ALTER TABLE permit_transfers ADD CONSTRAINT chk_permit_transfers CHECK(from_booking_id != to_booking_id)");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permit_transfers');
    }
}
