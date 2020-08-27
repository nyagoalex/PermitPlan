<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuidMorphs('paymentable'); // eg App\Models\Permit

            $table->uuid('user_id');
            $table->float('amount', 9, 2)->default(0);
            $table->date("date");
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->index(['paymentable_id', 'paymentable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_payments');
    }
}
