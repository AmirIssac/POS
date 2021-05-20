<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repository_id');
            $table->foreignId('user_id');   // the cashier who print this invoice
            $table->string('code',8);
            $table->string('details',10000);
            $table->float('total_price');
            $table->boolean('cash_check')->default(0);
            $table->boolean('card_check')->default(0);
            $table->float('cash_amount')->default(0);
            $table->float('card_amount')->default(0);
            $table->enum('status',['delivered','pending']);    // حالة الفاتورة تم التسليم و معلق
            $table->string('phone')->nullable();  // client number
            $table->timestamp('created_at');   // custom timestamp
            //$table->timestamp('updated_at')->nullable();   // custom timestamp for update from pending to delivered
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
