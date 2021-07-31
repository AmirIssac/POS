<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepositoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repositories', function (Blueprint $table) {
            $table->id();
            /*$table->foreign('category_id')
            ->references('id')->on('repository_categories')->default(1);*/
            $table->foreignId('category_id')->default(1);
            $table->string('name');
            $table->string('address');
            $table->float('cash_balance')->default(0);
            $table->float('card_balance')->default(0);
            $table->tinyInteger('min_payment')->default(25);
            $table->float('max_discount')->default(0); // أعلى حد للخصم نسبة مئوية
            $table->smallInteger('tax')->default(0);
            $table->timestamps();
            $table->float('balance')->after('stc_balance')->default(0);  //  رصيد الدرج الذي لا يتم تصفيره إلا بعملية ايداع
            $table->time('close_time')->default('00:00:00');
            $table->string('note')->default(null)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repositories');
    }
}
