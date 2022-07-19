<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Coupon extends Migration
{
    
    public function up()
    {
        Schema::create('coupon', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->nullable();
            $table->string('coupon')->nullable();
            $table->integer('status')->default('0');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('coupon');
    }
}
