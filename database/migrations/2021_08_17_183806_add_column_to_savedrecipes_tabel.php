<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToSavedrecipesTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('saved_recipes', function (Blueprint $table) {
            //
            $table->string('name')->after('user_id')->default(null)->nullable(); // وصفة ثانية للزبون تكون لاحد من افراد عائلته
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('saved_recipes', function (Blueprint $table) {
            //
        });
    }
}
