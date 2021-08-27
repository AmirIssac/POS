<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repository_id');
            $table->boolean('print_prescription')->default(false);  // طباعة الوصفة الطبية
            $table->boolean('discount_by_percent')->after('print_prescription')->default(false);
            $table->boolean('discount_by_value')->after('discount_by_percent')->default(false);
            $table->boolean('discount_change_price')->after('discount_by_value')->default(false);
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
        Schema::dropIfExists('settings');
    }
}
