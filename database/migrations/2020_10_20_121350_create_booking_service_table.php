<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_service', function (Blueprint $table) {
            $table->id();
            $table->integer('service_provide_id');
            $table->string('service_provider_name');
            $table->doubl('service_price');
            $table->decimal('service_provider_latitude', 50, 4);
            $table->decimal('service_provider_longitude', 50, 4);
            $table->string('service_rating')->nullable();
            $table->integer('service_user_id');
            $table->string('service_user_name');
            $table->string('service_user_contact');
            $table->string('service_user_email');
            $table->decimal('service_user_latitude', 50, 4);
            $table->decimal('service_user_longitude', 50, 4);
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
        Schema::dropIfExists('booking_service');
    }
}
