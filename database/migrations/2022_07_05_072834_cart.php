<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Cart extends Migration
{
    
    public function up()
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->nullable();
            $table->string('product_id')->nullable();
            $table->string('product_qty')->nullable();
            $table->string('address_id')->nullable();
            $table->string('status')->nullable();
            $table->string('del_status')->default('1');
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('cart');
    }
}
