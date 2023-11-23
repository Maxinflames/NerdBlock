<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSentPackageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sent_package', function (Blueprint $table) {
            $table->increments('sent_package_id');
            $table->unsignedInteger('subscription_id');
            $table->unsignedInteger('package_id');
            $table->foreign('subscription_id')->references('subscription_id')->on('subscription')->onDelete('cascade');
            $table->foreign('package_id')->references('package_id')->on('package')->onDelete('cascade');
            $table->date('sent_package_date');
            $table->Integer('sent_package_rating')->nullable(true);
            $table->string('sent_package_rating_description', 255)->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sent_package');
    }
}
