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
            $table->foreignId('customer_id')->nullable()->default(null); // null in original repository
            $table->string('code',8);
            $table->string('details',10000);
            $table->string('recipe',500)->nullable()->default(null); //الوصفة الطبية
            $table->float('total_price');
            $table->float('discount')->default(0.00);   // discount value
            $table->boolean('cash_check')->default(0);
            $table->boolean('card_check')->default(0);
            $table->float('cash_amount')->default(0);
            $table->float('card_amount')->default(0);
            $table->enum('status',['delivered','pending','retrieved']);    // حالة الفاتورة تم التسليم و معلق مسترجعة لمحل النظارات
            $table->string('phone')->nullable();  // client number
            $table->timestamp('created_at');   // custom timestamp
            $table->boolean('daily_report_check')->default(0);
            $table->enum('transform',['no','p-d','p-r','d-r'])->after('created_at')->default('no');
            $table->float('tax')->after('stc_amount')->default(0);   // real value
            $table->string('tax_code')->after('tax')->default('0000');
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
