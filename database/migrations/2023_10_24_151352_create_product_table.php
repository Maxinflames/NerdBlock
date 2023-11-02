<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->increments('product_id');
            $table->unsignedInteger('genre_id');
            $table->foreign('genre_id')->references('genre_id')->on('genre')->onDelete('cascade')->unsigned();
            $table->string('product_title', 50);
            $table->string('product_description',255);
            $table->double('product_cost', 10, 2);
            $table->string('product_manufacturer', 50)->nullable(true);
            $table->string('product_brand', 50)->nullable(true);
            $table->string('product_license', 50)->nullable(true);
            $table->integer('product_quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}
