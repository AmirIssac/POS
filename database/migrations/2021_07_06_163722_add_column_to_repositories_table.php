<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToRepositoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('repositories', function (Blueprint $table) {
            //
            $table->float('balance')->after('stc_balance')->default(0);  //  رصيد الدرج الذي لا يتم تصفيره إلا بعملية ايداع
            //$table->float('today_sales')->after('balance')->default(0); // مبيعات اليوم تحوي مجموع الفواتير لليوم سواء تم دفع مبلغها او لم يتم
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('repositories', function (Blueprint $table) {
            //
        });
    }
}
