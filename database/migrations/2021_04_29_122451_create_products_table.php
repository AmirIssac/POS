<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repository_id');
            $table->string('barcode'); // read from scanner
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->float('cost_price')->default(0);  // سعر التكلفة
            $table->float('price');
            $table->integer('quantity');
            $table->foreignId('type_id')->nullable();  // null able for original products
            $table->boolean('accept_min')->default(1);   // يقبل الحد الأدنى  
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
        Schema::dropIfExists('products');
    }
}
