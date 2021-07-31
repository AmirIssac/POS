<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthlyReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repository_id');
            $table->foreignId('user_id');
            $table->float('cash_balance');   // كل ما تم دفعه ككاش
            $table->float('card_balance');  // كل ماتم دفعه بالبطاقة
            $table->float('stc_balance');  // كل ما تم دفعه ب stc
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
        Schema::dropIfExists('monthly_reports');
    }
}
