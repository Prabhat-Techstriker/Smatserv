<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToBookingService extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_service', function (Blueprint $table) {
            $table->decimal('pickup_latitude', 50, 4)->nullable();
            $table->decimal('pickup_longitude', 50, 4)->nullable();
            $table->text('pickup_address')->nullable();
            $table->decimal('drop_latitude', 50, 4)->nullable();
            $table->decimal('drop_longitude', 50, 4)->nullable();
            $table->text('drop_address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_service', function (Blueprint $table) {
            $table->dropColumn('pickup_latitude');
            $table->dropColumn('pickup_longitude');
            $table->dropColumn('pickup_address');
            $table->dropColumn('drop_latitude');
            $table->dropColumn('drop_longitude');
            $table->dropColumn('drop_address');
        });
    }
}
