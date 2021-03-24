->nullable();<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotificationTypeToPushnotification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pushnotification', function (Blueprint $table) {
            $table->integer('notification_type')->nullable();
            $table->integer('booking_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pushnotification', function (Blueprint $table) {
            $table->dropColumn('notification_type');
        });
    }
}
