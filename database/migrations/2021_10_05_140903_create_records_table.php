<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repository_id');
            $table->foreignId('user_id');
            $table->foreignId('action_id')->default(null)->nullable(); // تدل على نوع الاجرائية (انشاء فاتورة , حذف فاتورة ...الخ)
            $table->string('note'); //ملاحظة مثلا تحوي رقم الفاتورة لانشاء فاتورة مثلا رقم المنتج لتعديل منتج وهكذا
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
        Schema::dropIfExists('records');
    }
}
