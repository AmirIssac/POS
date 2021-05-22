<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repository_id');
            $table->foreignId('user_id');
            $table->float('cash_balance');
            $table->float('card_balance');
            $table->float('cash_shortage')->default(0); // if null take it zero value
            $table->float('card_shortage')->default(0); // if null take it zero value
            $table->float('cash_plus')->default(0); // if null take it zero value
            $table->float('card_plus')->default(0); // if null take it zero value
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
        Schema::dropIfExists('daily_reports');
    }
}
