<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipmentItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipment_item', function (Blueprint $table) {
            $table->increments('shipment_item_id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('shipment_id');
            $table->foreign('product_id')->references('product_id')->on('product')->onDelete('cascade')->unsigned();
            $table->foreign('shipment_id')->references('shipment_id')->on('shipment')->onDelete('cascade')->unsigned();
            $table->integer('shipment_item_quantity');
            $table->double('shipment_item_unit_cost', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipment_item');
    }
}
