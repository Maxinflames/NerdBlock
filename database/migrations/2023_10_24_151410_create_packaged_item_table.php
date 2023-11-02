<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagedItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packaged_item', function (Blueprint $table) {
            $table->increments('packaged_item_id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('package_id');
            $table->foreign('product_id')->references('product_id')->on('product')->onDelete('cascade')->unsigned();
            $table->foreign('package_id')->references('package_id')->on('package')->onDelete('cascade')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packaged_item');
    }
}
