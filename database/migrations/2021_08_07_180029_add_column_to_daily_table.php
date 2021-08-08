<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToDailyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('daily_reports', function (Blueprint $table) {
            //
            $table->float('out_cashier')->after('stc_plus')->default(0);     // المدفوع من الدرج في المشتريات
            $table->float('out_external')->after('out_cashier')->default(0);  // المدفوع من ميزانية خارجية في المشتريات
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('daily_reports', function (Blueprint $table) {
            //
        });
    }
}
