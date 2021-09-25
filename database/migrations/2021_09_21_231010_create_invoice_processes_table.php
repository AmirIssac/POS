<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_processes', function (Blueprint $table) {  // نخزن فيها دورة الحياة القديمة للفاتورة
            $table->id();
            $table->foreignId('repository_id');
            $table->foreignId('invoice_id');
            $table->foreignId('user_id');   // the cashier who print this invoice
            $table->string('details',10000);  // to know how many items we delivered in this old process
            $table->float('cash_amount')->default(0);
            $table->float('card_amount')->default(0);
            $table->float('stc_amount')->default(0);
            $table->enum('status',['delivered','pending','retrieved','deleted']);
            $table->timestamp('created_at');   // custom timestamp
            $table->string('note')->default(null)->nullable();
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
        Schema::dropIfExists('invoice_processes');
    }
}
