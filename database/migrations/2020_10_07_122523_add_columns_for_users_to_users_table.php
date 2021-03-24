<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsForUsersToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phonenumber')->after('name');
            $table->integer('service_type')->comment('1 => user , 2 => provider')->after('phonenumber');
            $table->boolean('is_verified')->nullable()->after('service_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phonenumber');
            $table->dropColumn('service_type');
            $table->dropColumn('is_verified');
        });
    }
}
