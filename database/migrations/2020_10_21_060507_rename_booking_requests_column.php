<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameBookingRequestsColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_requests', function(Blueprint $table) {
            $table->renameColumn('booking_id', 'booking_service_id');
        });
    }


    public function down()
    {
        Schema::table('booking_requests', function(Blueprint $table) {
            $table->renameColumn('booking_service_id', 'booking_id');
        });
    }
}
