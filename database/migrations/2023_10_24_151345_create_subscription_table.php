<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription', function (Blueprint $table) {
            $table->increments('subscription_id');
            $table->unsignedInteger('client_id');
            $table->unsignedInteger('genre_id');
            $table->foreign('client_id')->references('client_id')->on('client')->onDelete('cascade')->unsigned();
            $table->foreign('genre_id')->references('genre_id')->on('genre')->onDelete('cascade')->unsigned();
            $table->date('subscription_date');
            $table->integer('subscription_length');
            $table->double('subscription_cost', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription');
    }
}
