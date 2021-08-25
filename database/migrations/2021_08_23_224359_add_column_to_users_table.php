<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->timestamp('last_login')->after('remember_token')->default(now());
            $table->timestamp('last_login_old')->after('last_login')->default(now());  //  we need this because we show the last login for auth user
            $table->boolean('is_online')->after('last_login_old')->default(0);
            $table->timestamp('last_logout')->after('is_online')->default(now());
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
            //
        });
    }
}
