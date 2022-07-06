<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Address extends Migration
{
    
    public function up()
    {
        Schema::create('useraddress', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('pincode')->nullable();
            $table->string('house_no')->nullable();
            $table->string('landmark')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('del_status')->default('1');
            $table->timestamps();
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('useraddress');
    }
}
