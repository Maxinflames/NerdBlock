<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('user_id');
            $table->string('user_first_name', 50);
            $table->string('user_last_name', 50);
            $table->string('user_email_address', 255);
            $table->unique('user_email_address');
            $table->string('user_password', 255);
            $table->string('user_type', 1);
            $table->boolean('user_active')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
