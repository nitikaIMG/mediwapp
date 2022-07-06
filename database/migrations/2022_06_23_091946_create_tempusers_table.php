<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempusersTable extends Migration
{
   
    public function up()
    {
        Schema::create('tempusers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('password')->nullable();
            $table->string('code')->nullable();
            $table->string('status')->default('1');
            $table->string('del_status')->default('1');
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('tempusers');
    }
}
