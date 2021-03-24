<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentinfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paymentinfo', function (Blueprint $table) {
            $table->id();
            $table->string('payment_ref_id');
            $table->integer('provider_id');
            $table->integer('user_id');
            $table->integer('booking_id');
            $table->double('price', 10, 2);
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
        Schema::dropIfExists('paymentinfo');
    }
}
