<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Support extends Migration
{
   
    public function up()
    {
        Schema::create('customer_support', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->nullable();
            $table->string('message')->nullable();
            $table->string('ticket_number')->default('1');
            $table->string('del_status')->default('1');
            $table->string('status')->default('0');
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('customer_support');
    }
}
