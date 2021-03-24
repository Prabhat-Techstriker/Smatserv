<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_details', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('service_provide_type', 100)->nullable();
            $table->string('vehicle_type', 50)->nullable();
            $table->string('vehicle_number', 50)->nullable();
            $table->string('type_of_mechanic', 50)->nullable();
            $table->string('courier_type', 50)->nullable();
            $table->string('haulage_type', 50)->nullable();
            $table->string('rate_per_hour', 50)->nullable();
            $table->string('identification_document')->nullable();
            $table->string('bussiness_certificate')->nullable();
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
        Schema::dropIfExists('users_details');
    }
}
