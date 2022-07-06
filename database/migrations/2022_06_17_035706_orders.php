<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Orders extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->nullable();
            $table->string('order_id')->nullable();
            $table->string('product')->default('1');
            $table->string('order_status')->default('1');
            $table->string('payment_status')->default('1');
            $table->string('prescription')->nullable();
            $table->string('address')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('status')->default('1');
            $table->string('del_status')->default('1');
            $table->timestamps();
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
