<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repository_id');
            $table->foreignId('user_id');   // the employee who recieve this purchase
            $table->foreignId('supplier_id');
            $table->string('code',8);
            $table->float('total_price');
            $table->boolean('later_check');  // payment
            $table->boolean('cash_check');  // payment
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
        Schema::dropIfExists('purchases');
    }
}
