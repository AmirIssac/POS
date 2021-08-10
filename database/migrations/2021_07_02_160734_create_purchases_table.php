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
            $table->string('supplier_invoice_num')->default(null)->nullable(); // رقم فاتورة المورد حقل اختياري
            $table->float('total_price');
            $table->enum('payment',['later','cashier','external']); // آجل او درج أو ميزانية خارجية
            $table->boolean('daily_report_check')->after('status')->default(true);
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
